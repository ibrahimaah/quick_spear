<?php

namespace App\Http\Controllers;

use App\DataTables\ExpressDataTable;
use DateTime;
use Carbon\Carbon;
use App\Models\City;
use App\Models\Pickup;
use App\Models\Address;
use Octw\Aramex\Aramex;
use App\Models\Shipment;
use App\Models\EditOrder;
use App\Models\ShipmentRate;
use Illuminate\Http\Request;
use App\Exports\ShipmentsExport;
use App\Jobs\ImportShipments;
use App\Services\ShipmentService;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\Validator;
use PDFMerger;
;

class ExpressController extends Controller
{
    public function __construct(private ShipmentService $shipmentService)
    {
        if (auth('team')->check()) {
            $this->middleware(['auth:team']);
        } else {
            $this->middleware(['auth']);
        }
    }

    public function export(Request $request)
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 500); 
        $fileName = 'shipments_' . $request->from . '_' . $request->to . '.' . $request->fileType;
        return Excel::download(new ShipmentsExport($request), $fileName);
        // return back()->with('success', __('The action ran successfully!'));
    }

    public function index1(Request $request)
    {
        // $ships = Shipment::where('user_id', auth()->user()->id)->latest()->get();
        $ships = Shipment::where('user_id', auth()->user()->id)->where(function ($q) use ($request) {
            if ($request->from!=null) {
                $q->whereBetween('created_at', [$request->from, $request->to]);
            }
            if ($request->status!=null) {
                $q->where('status', 'LIKE', "%$request->status%");
            }
            if ($request->process!=null && $request->cod!=null) {
                $q->where('cash_on_delivery_amount', $request->process, $request->cod);
            }
            if ($request->phone!=null) {
                $q->where('consignee_phone', 'LIKE', "%$request->phone%");
            }
        });

        $ships = $ships->latest()->get();
        return view('pages.user.express.shipping', compact('ships'));
    }

    public function index(Request $request)
    {
        // dd($request->all());
        $dataTable = new ExpressDataTable($request);
        
        // $ships = Shipment::where('user_id', auth()->user()->id)->where(function ($q) use ($request) {

        //     if ($request->from!=null) {
        //         $q->whereBetween('created_at', [$request->from, $request->to]);
        //     }
        //     if ($request->status!=null) {
        //         $q->where('status', 'LIKE', "%$request->status%");
        //     }
        //     if ($request->process!=null && $request->cod!=null) {
        //         $q->where('cash_on_delivery_amount', $request->process, $request->cod);
        //     }
        //     if ($request->phone!=null) {
        //         $q->where('consignee_phone', 'LIKE', "%$request->phone%");
        //     }
        // });
        
        $ships = Shipment::where('user_id', auth()->user()->id);
        $ships = $ships->latest()->get();
        
        // return view('pages.user.express.shipping', compact('dataTable','ships'));
        return $dataTable->render('pages.user.express.shipping', ['ships' => $ships]);
    }

    public function trackingPickup(Request $request)
    {
        // Aramex::trackingPickup(App\Models\Shipment::where('status', 1)->latest()->first()->pickup_guid)
        $pickups = Pickup::where('user_id', auth()->user()->id)->latest()->get();
        // if ($request->from) {
        //     $pickups = Shipment::whereBetween('created_at', [$request->from, $request->to])
        //                         ->where('status', 'LIKE', "%$request->status%")
        //                         ->where('cash_on_delivery_amount', $request->process, $request->cod)
        //                         ->where('consignee_phone', 'LIKE', "%$request->phone%")
        //                         ->where('user_id', auth()->user()->id)
        //                         ->latest()->get();
        // }

        return view('pages.user.express.pickup', compact('pickups'));
    }

    public function create()
    {
        return view('pages.user.express.create');
    }

    public function edit(Shipment $shipment)
    {
        return view('pages.user.express.edit',['shipment'=>$shipment]);
    }
    public function show($id)
    {
        $generator = new BarcodeGeneratorPNG();
        $shipment = Shipment::where(['id' => $id, 'user_id' => auth()->user()->id])->first();
        $editOrders = EditOrder::where(['shipment_id' => $id, 'user_id' => auth()->user()->id])->latest()->get();
        if ($shipment) {
            // dd($shipment);
            // $data = Aramex::trackShipments([$shipment->shipmentID]);
            $barcode = base64_encode($generator->getBarcode($shipment->shipmentID, $generator::TYPE_CODE_128));
            // dd('1');
            return view('pages.user.express.show', compact('shipment', 'barcode', 'editOrders'));
            // dd($data);
        }
        return abort(404);
    }

    // public function AramixCreateShipment($shipmentDetails,$shipper,$ship)
    // {
    //      // dd($shipmentDetails);
    //      $callResponse = Aramex::createShipment($shipmentDetails);
    //      // if (false) {
    //      if (!empty($callResponse->error)) {
    //          foreach ($callResponse->errors as $errorObject) {
    //              return $errorObject->Code . ' => ' . $errorObject->Message;
    //          }
    //      } else {
    //          $file =  file_get_contents($callResponse->Shipments->ProcessedShipment->ShipmentLabel->LabelURL);
    //          $putFile = file_put_contents($callResponse->Shipments->ProcessedShipment->ID . '.pdf', $file);
    //          // $putFile = Storage::put($callResponse->Shipments->ProcessedShipment->ID . '.pdf', $file);
    //          $data = [
    //              'user_id' => auth()->user()->id,
    //              'address_id' => $shipper->id,
    //              'consignee_name' => $shipmentDetails['consignee']['name'],
    //              'consignee_email' => $shipmentDetails['consignee']['email'],
    //              'consignee_phone' => $shipmentDetails['consignee']['phone'],
    //              'consignee_cell_phone' => $shipmentDetails['consignee']['cell_phone'],
    //              'consignee_zip_code' => $shipmentDetails['consignee']['zip_code'],
    //              'consignee_country_code' => $shipmentDetails['consignee']['country_code'],
    //              'consignee_line1' => $shipmentDetails['consignee']['line1'],
    //              'consignee_line2' => $shipmentDetails['consignee']['line2'],
    //              'consignee_line3' => $shipmentDetails['consignee']['line2'],
    //              'consignee_city' => $ship['consignee_city'],

    //              // Shipment Data
    //              'reference' => $ship['reference'],
    //              'shipping_date_time'    => now()->addHours(2),
    //              'due_date'  => now()->addHours(72),
    //              'comments'  => $shipmentDetails['comments'],
    //              'pickup_location'   => $shipmentDetails['pickup_location'],
    //              'pickup_guid'   => $shipmentDetails['pickup_guid'],
    //              'cash_on_delivery_amount'   => $shipmentDetails['cash_on_delivery_amount'],
    //              'product_group' => $shipmentDetails['product_group'],
    //              'product_type'  => $shipmentDetails['product_type'],
    //              'payment_type'  => $shipmentDetails['payment_type'],
    //              'customs_value_amount'  => 0,
    //              'collect_amount' => $this->sumExpress($shipper->city, $shipper->city, $ship['weight']),
    //              'weight'    => $shipmentDetails['weight'],
    //              'number_of_pieces'  => $shipmentDetails['number_of_pieces'],
    //              'description'   => $shipmentDetails['description'],
    //              'shipmentID' => $callResponse->Shipments->ProcessedShipment->ID,
    //              'shipmentLabelURL' => $callResponse->Shipments->ProcessedShipment->ID . '.pdf',
    //              'shipmentAttachments' => $callResponse->Shipments->ProcessedShipment->ShipmentAttachments->ProcessedShipmentAttachment->Url ?? 'N/A',
    //          ];
    //          return $data;
    //      }
    // }


    public function update(Request $request,Shipment $shipment)
    {
        $shipment->address_id = $request->shipper;
        $shipment->consignee_name = $request->consignee_name;
        $shipment->consignee_phone = $request->consignee_phone;
        $shipment->consignee_phone_2 = $request->consignee_phone_2;
        $shipment->consignee_city = $request->consignee_city;
        $shipment->consignee_region = $request->consignee_region;
        $shipment->order_price = $request->order_price;
        $shipment->customer_notes = $request->customer_notes;
        $shipment->delegate_notes = $request->delegate_notes;

        if($shipment->save()){
            return back()->with('success',__('Saved.'));
        }
    }
    public function store(Request $request)
    {
        try 
        {
            $shipment = $this->shipmentService->store($request);

            if($shipment)
            {
                return redirect()->route('front.express.index')->with('success', 'تم اضافة الشحنة بنجاح');
            }
            else 
            {
                return redirect()->route('front.express.index')->with('faild', 'حدث خطأ في إضافة الشحنة');
            }
            
        } 
        catch (\Exception $ex) 
        {
            return $ex->getMessage();
        }
    }
    public function store_old(Request $request)
    {
        dd($request->all());
        
        // return $request->shipments;
        // $spacer_size = 11; // increment me until it works
        // echo str_pad('', (1024 * $spacer_size), "\n");
        // if(ob_get_level()) ob_end_clean();

        if ($request->shipments) {
            // $this->dispatch(new ImportShipments($request->shipments))->afterResponse();
            ImportShipments::dispatchAfterResponse($request->shipments);
            return redirect()->route('front.express.index')->with('success', 'جاري تحليل البيانات في الخلفيه وستظهر بعد ان تكتمل');
            /*
            foreach ($request->shipments as $ship) {
                // dd($ship);
                $shipper = Address::findOrFail($ship['shipper']);
                $city = City::where('id', $shipper->city)->orWhere('name', $shipper->city)->first();
                // dd($city);
                $destinationCity = City::where('id', $ship['consignee_city'])->first();
                $shipmentDetails = [
                    'shipper' => [
                        'name' => $shipper->name,
                        'email' => auth()->user()->email,
                        'phone' => $shipper->phone,
                        'cell_phone' => $shipper->phone,
                        'country_code' => 'JO',
                        'city' => $city->name,
                        'zip_code' => '',
                        'line1' => $shipper->desc,
                        'line2' => $shipper->desc,
                    ],
                    'consignee' => [
                        'name' => $ship['consignee_name'],
                        'email' => auth()->user()->email,
                        'phone' => $ship['consignee_phone'],
                        'cell_phone' => $ship['consignee_cell_phone'] ?? $ship['consignee_phone'],
                        'country_code' => 'JO',
                        'city' => $destinationCity->name,
                        'zip_code' => '',
                        'line1' => $ship['consignee_line1'] ?? $destinationCity->name,
                        'line2' => $ship['consignee_line2'] ?? $destinationCity->name,
                    ],
                    'shipping_date_time' => now()->addHours(2)->timestamp,
                    'reference' => $ship['reference'],
                    'shipper_reference' => $ship['reference'],
                    // 'shipping_date_time' => time() + 50000,
                    'due_date' => now()->addHours(72)->timestamp,
                    'comments' => $ship['comments'] ?? 'No Comment',
                    'pickup_location' => 'at reception',
                    'pickup_guid' => null,
                    'services' => 'CODS',
                    'cash_on_delivery_amount' => floatval(number_format($ship['cash_on_delivery_amount'], 2)),
                    'product_group' => 'DOM', // or EXP (defined in config file, if you dont pass it will take the config value)
                    'product_type' => 'COM', // refer to the official documentation (defined in config file, if you dont pass it
                    'payment_type' => 'P',
                    'customs_value_amount' => 0,
                    'weight' => $ship['weight'],
                    'number_of_pieces' => $ship['number_of_pieces'],
                    'description' => $ship['description'],
                ];
                $data = $this->AramixCreateShipment($shipmentDetails,$shipper,$ship);
                if (is_array($data)) {
                    $ship = Shipment::create($data);
                }else{
                    return $data;
                }
                
            }
            return redirect()->route('front.express.index')->with('success', 'تم اضافة الشحنة بنجاح');
            */
    
        } 
        else 
        {
            $validator = Validator::make($request->all(), [
                "shipper"   => "required",
                "consignee_name"  => "required|min:3",
                "consignee_phone"  => "required|regex:/^[0-9]{10}$/",
                "consignee_city"  => "required",
                "consignee_region"  => "required",
                "order_price" => "required",
                // "cash_on_delivery_amount"  => "required",
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            
            try {
                //code...
                $shipper = Address::findOrFail($request->shipper);
                $city = City::where('id', $shipper->city)->first();
                $destinationCity = City::where('id', $request->consignee_city)->first();
                $shipmentDetails = [
                    'shipper' => [
                        'name' => $shipper->name ?? 'test',
                        'email' => auth()->user()->email,
                        'phone' => $shipper->phone,
                        'cell_phone' => $shipper->phone,
                        'country_code' => 'JO',
                        'city' => $city->name ?? 'Amman',
                        'zip_code' => '',
                        'line1' => $shipper->desc,
                        'line2' => $shipper->desc,
                    ],
                    'consignee' => [
                        'name' => $request->consignee_name,
                        // 'email' => auth()->user()->email,
                        'phone' => $request->consignee_phone,
                        // 'cell_phone' => $request->consignee_cell_phone ?? $request->consignee_phone,
                        'country_code' => 'JO',
                        'city' => $destinationCity->name,
                        'zip_code' => '',
                        'region' => $request->consignee_region,
                        'line2' => $request->consignee_line2,
                    ],
                    // 'shipping_date_time' => now()->addHours(604800)->timestamp,
                    // 'reference' => $request->reference,
                    // 'shipper_reference' => $request->reference,
                    'shipping_date_time' => time() + 50000,
                    'due_date' => time() + 60000,
                    // 'comments' => $request->comments ?? 'No Comment',
                    'pickup_location' => 'at reception',
                    // 'pickup_guid' => null,
                    'services' => 'CODS',
                    'cash_on_delivery_amount' => floatval(number_format($request->cash_on_delivery_amount, 2)),
                    'product_group' => 'DOM', // or EXP (defined in config file, if you dont pass it will take the config value)
                    'product_type' => 'COM', // refer to the official documentation (defined in config file, if you dont pass it
                    'payment_type' => 'P',
                    /*
                    'customs_value_amount' => 0,
                    'weight' => $request->weight,
                    'number_of_pieces' => $request->number_of_pieces,
                    'description' => $request->description,
                    */
                ];
                // dd($shipmentDetails);
                $callResponse = Aramex::createShipment($shipmentDetails);
                // if (false) {
                if (!empty($callResponse->error)) {
                    foreach ($callResponse->errors as $errorObject) {
                        return $errorObject->Code . ' => ' . $errorObject->Message;
                    }
                } else {
                    $file =  file_get_contents($callResponse->Shipments->ProcessedShipment->ShipmentLabel->LabelURL);
                    $putFile = file_put_contents($callResponse->Shipments->ProcessedShipment->ID . '.pdf', $file);
                    // dd($putFile);
                    // $fileUpload = Storage::putFile('lables/' . $callResponse->Shipments->ProcessedShipment->ID . '/' , $putFile);
                    // dd($callResponse);
                    $data = [
                        'user_id' => auth()->user()->id,
                        'address_id' => $shipper->id,
                        'consignee_name' => $shipmentDetails['consignee']['name'],
                        'consignee_email' => $shipmentDetails['consignee']['email'],
                        'consignee_phone' => $shipmentDetails['consignee']['phone'],
                        'consignee_cell_phone' => $shipmentDetails['consignee']['cell_phone'],
                        'consignee_zip_code' => $shipmentDetails['consignee']['zip_code'],
                        'consignee_country_code' => $shipmentDetails['consignee']['country_code'],
                        'consignee_region' => $shipmentDetails['consignee']['region'],
                        // 'consignee_line2' => $shipmentDetails['consignee']['line2'],
                        // 'consignee_line3' => $shipmentDetails['consignee']['line2'],
                        'consignee_city' => $request->consignee_city,

                        // Shipment Data
                        // 'reference' => $request->reference,
                        'shipping_date_time'    => now()->addHours(2),
                        'due_date'  => now()->addHours(72),
                        // 'comments'  => $shipmentDetails['comments'],
                        'pickup_location'   => $shipmentDetails['pickup_location'],
                        'pickup_guid'   => $shipmentDetails['pickup_guid'],
                        'cash_on_delivery_amount'   => $shipmentDetails['cash_on_delivery_amount'],
                        'product_group' => $shipmentDetails['product_group'],
                        'product_type'  => $shipmentDetails['product_type'],
                        'payment_type'  => $shipmentDetails['payment_type'],
                        'customs_value_amount'  => 0,
                        'collect_amount' => $this->sumExpress($shipper->city, $shipper->city, $request->weight),
                        'weight'    => $shipmentDetails['weight'],
                        'number_of_pieces'  => $shipmentDetails['number_of_pieces'],
                        'description'   => $shipmentDetails['description'],
                        'shipmentID' => $callResponse->Shipments->ProcessedShipment->ID,
                        'shipmentLabelURL' => $callResponse->Shipments->ProcessedShipment->ID . '.pdf',
                        'shipmentAttachments' => $callResponse->Shipments->ProcessedShipment->ShipmentAttachments->ProcessedShipmentAttachment->Url ?? 'N/A',
                    ];
                    $ship = Shipment::create($data);
                }

                return redirect()->route('front.express.index')->with('success', 'تم اضافة الشحنة بنجاح');
            } catch (\Exception $ex) {
                return $ex->getMessage();
            }
        }
    }

    public function orderAramex(Request $request)
    {
        $shipments = Shipment::where(['user_id' => auth()->user()->id, 'status' => 0])->get();
        // foreach ($shipments as $value) {
        //     $value->update(['status' => 0]);
        // }
        // return;
        if ($shipments->count() !== 0) {
            $timeS = \Carbon\Carbon::parse($request->start_time);
            $timeE = \Carbon\Carbon::parse($request->end_time);

            $shipper = Address::find($request->address_id);
            $city = City::where('id', $shipper->city)->orWhere('name', $shipper->city)->first();

            $data = Aramex::createPickup([
                'name' => $shipper->name,
                'cell_phone' => $shipper->phone,
                'phone' => $shipper->phone,
                'email' => $shipper->email,
                'city' => $city->name,
                'country_code' => 'JO',
                'zip_code'=> '',
                'line1' => $shipper->desc,
                'line2' => '',
                'line3' => '',
                "pickup_date" => $timeS->timestamp, // time parameter describe the date of the pickup
                "ready_time" => $timeS->timestamp  + 2000, // time parameter describe the ready pickup date
                "last_pickup_time" => $timeS->timestamp + 3000, // time parameter
                "closing_time" => $timeE->timestamp, // time parameter
                'status' => 'Ready',
                'pickup_location' => 'some location',
                'weight' => $shipments->sum('weight'),
                'volume' => '0',
                'number_of_shipments' => $shipments->count(),
            ]);
            // extracting GUID
            if (!$data->error) {
                $guid = $data->pickupID;
                foreach ($shipments as $shipment) {
                    $shipment->update([
                        'status' => 1,
                        'pickup_guid' => $guid,
                    ]);
                }
                try {
                    $tracking = Aramex::trackingPickup($guid);
                    // if ($tracking->HasErrors) {
                    //     $data->errors = $tracking->Notifications;
                    // }
                    $pickup = Pickup::create([
                        'reference' => $guid,
                        'CollectionDate' => $tracking->CollectionDate ?? now(),
                        'LastStatus' => $tracking->LastStatus,
                        'LastStatusDescription' => $tracking->LastStatusDescription,
                        'shipper' => $shipper->name,
                        'user_id' => auth()->user()->id,
                    ]);
                } catch (\Throwable $th) {
                    return back()->with('error', $data->errors);
                }
            } else {
                // dd($data);
                if (gettype($data->errors) == "array" && $data->errors[0]->Message) {
                    return back()->with('error', $data->errors[0]->Message);
                } else {
                    return back()->with('error', $data->errors->Message);
                }
            }

            return back()->with('success', __('The action ran successfully!'));
        }
        return back()->with('success', __('No Results Found.'));
    }
    public function sumExpress($city_from, $city_to, $wighte)
    {
        $value = 0;
        $user_id = auth()->user()->id;
        $shipRate = ShipmentRate::where(['city_from' => $city_from, 'city_to' => $city_to])
                                    ->orWhere(['city_from' => $city_to, 'city_to' => $city_from])
                                    ->first();

        $userShipRate = ShipmentRate::where(['city_from' => $city_from, 'city_to' => $city_to])
                                    ->orWhere(['city_from' => $city_to, 'city_to' => $city_from])
                                    ->where('user_id', $user_id)->first();
        if (!$shipRate || !$userShipRate) {
            return $value;
        }

        if ($userShipRate) {
            $shipRate = $userShipRate;
        }
        if (in_array($wighte, range(1, 10))) {
            $value = $shipRate->rate;
        } elseif (in_array($wighte, range(11, 20))) {
            $value = $shipRate->rate * 1.5;
        } elseif (in_array($wighte, range(21, 30))) {
            $value = $shipRate->rate * 2;
        } elseif (in_array($wighte, range(31, 40))) {
            $value = $shipRate->rate * 2.5;
        } elseif (in_array($wighte, range(41, 50))) {
            $value = $shipRate->rate * 3.5;
        } elseif (in_array($wighte, range(51, 60))) {
            $value = $shipRate->rate * 4.5;
        } elseif (in_array($wighte, range(61, 70))) {
            $value = $shipRate->rate * 5.5;
        } elseif (in_array($wighte, range(71, 80))) {
            $value = $shipRate->rate * 6.5;
        } elseif (in_array($wighte, range(81, 90))) {
            $value = $shipRate->rate * 7.5;
        } elseif (in_array($wighte, range(91, 100))) {
            $value = $shipRate->rate * 8.5;
        } elseif (in_array($wighte, range(101, 105))) {
            $value = $shipRate->rate * 9.5;
        }
        return $value;
    }


    public function shipment_update(Request $request)
    {
        $editOrder = EditOrder::create([
            'type'          => 'تعديل بيانات شحنة',
            'desc'          => $request->desc,
            'user_id'       => auth()->user()->id,
            'shipment_id'   => $request->shipment_id,
        ]);

        NotificationController::NewOrderNotification([
            'user_id'       => auth()->user()->id,
            'type'          => 'تعديل بيانات شحنة',
            'shipment_id'   => $request->shipment_id,
            'body'          => $request->desc,
        ]);
        return back()->with('success', 'تم ارسال طلبك بنجاح');
    }

    public function printSelectedBulk(Request $request)
    {
        try {
            $pdf = PDFMerger::init();

            foreach (explode(',', $request->ids) as $id) {
                try {
                    $shipment = Shipment::find($id);
                    $pdf->addPDF(public_path($shipment->shipmentLabelURL), 'all');
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
            $fileName = time().'.pdf';
            $pdf->merge();
            $pdf->save(public_path($fileName));
        } catch (\Exception $th) {
            return "No PDF Files Found To Merge";
        }

        return response()->download(public_path($fileName));
    }

    public function printSelectedBulkGet(Request $request)
    {
        $data = $request;
        return view('front.express.printSelectedBulk.get', compact('data'));

        // $file =  file_get_contents($callResponse->Shipments->ProcessedShipment->ShipmentLabel->LabelURL);
        // // $putFile = file_put_contents();
        // $putFile = Storage::put($callResponse->Shipments->ProcessedShipment->ID . '.pdf', $file);
        // $bulk = $request->bulk;
    }


    public function destroy(Shipment $shipment)
    {
        $res_rmv = $this->shipmentService->remove($shipment->id);
        if ($res_rmv['code'] == 1) 
        {
            return back()->with('success',__('Deleted Successfully'));
        }
        else 
        {
            return back()->with('error',$res_rmv['msg']);
        }
    }


}
