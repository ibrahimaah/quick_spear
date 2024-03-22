<?php

namespace App\Imports;

use App\Models\Shipment;
use App\Models\Transaction;
use App\Models\ShipmentImport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TransactionsImport implements ToCollection, WithHeadingRow
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function collection(Collection $rows)
    {
        $diff = [];
        $notFound = [];
        $repeat = [];

        foreach ($rows as $key=>$row) {
            $shipment = Shipment::where('shipmentID', $row['awb'])->first();

           
            if (!$shipment) {

                $notFound[$key]['awb'] = $row['awb'];
                $notFound[$key]['codvalue'] = $row['codvalue'];
                continue;


                // return back()->with('error', 'شحنة رقم ('.$row['awb'].') غير موجوده');
            }
            if ($shipment->cash_on_delivery_amount != $row['codvalue']) {

                $diff[$key]['awb'] = $row['awb'];
                $diff[$key]['codvalue'] = $shipment->cash_on_delivery_amount;
                $diff[$key]['codvalue_excel'] = $row['codvalue'];
                $diff[$key]['consignee_name'] = $shipment->consignee_name;
                
                continue;
                // return back()->with('error', 'شحنة رقم ('.$row['awb'].') يوجد اختلاف في COD On System : ' . $shipment->cash_on_delivery_amount . ' On Sheet : ' .$row['codvalue']);
            
            }
            if ($shipment) {
                $transaction =  Transaction::firstOrCreate([
                    'value' => $row['codvalue'],
                    'user_id' => $shipment->user_id,
                    'image'     => 'N/A',
                ]);
                if ($transaction->imports()->where('AWB', $row['awb'])->count() > 0) {
                    $repeat[$key]['awb'] = $row['awb'];
                    $repeat[$key]['codvalue'] = $shipment->cash_on_delivery_amount;
                    $repeat[$key]['codvalue_excel'] = $row['codvalue'];
                    $repeat[$key]['consignee_name'] = $shipment->consignee_name;
                    continue;
                    // return back()->with('error', 'شحنة رقم ('.$row['awb'].') مكرره ');
                }
                $shipment->update(['status' => 0]);
                $transaction->imports()->create([
                    'AWB'                   => $row['awb'],
                    'CODValue'              => $row['codvalue'],
                    'ShipperNumber'         => $row['shippernumber'] ?? 0,
                    'ShipperReference'      => $row['shipperreference'] ?? 0,
                    'ShipperReference2'     => $row['shipperreference2'] ?? 0,
                    'ShipperName'           => $row['shippername'] ?? 0,
                    'user_id'               => $shipment->user_id ?? 0,
                ]);

            }                
        }
    
        return back()->with([
            'diff' => json_encode($diff),
            'notFound' => json_encode($notFound),
            'repeat' => json_encode($repeat)
        ]);
        // foreach ($rows as $row) {
        //     $shipment = Shipment::where('shipmentID', $row['awb'])->first();

        //     if ($shipment->cash_on_delivery_amount != $row['codvalue']) {
        //         return back()->with('error', 'شحنة رقم ('.$row['awb'].') يوجد اختلاف في COD On System : ' . $shipment->cash_on_delivery_amount . ' On Sheet : ' .$row['codvalue']);
        //     }
        //     if (!$shipment) {
        //         return back()->with('error', 'شحنة رقم ('.$row['awb'].') غير موجوده');
        //     }
        //     if ($shipment) {
        //         $transaction =  Transaction::firstOrCreate([
        //             'value' => $row['codvalue'],
        //             'user_id' => $shipment->user_id,
        //             'image'     => 'N/A',
        //         ]);
        //         $shipment->update(['status' => 4]);
        //         $transaction->imports()->create([
        //             'AWB'                   => $row['awb'],
        //             'CODValue'              => $row['codvalue'],
        //             'ShipperNumber'         => $row['shippernumber'],
        //             'ShipperReference'      => $row['shipperreference'],
        //             'ShipperReference2'     => $row['shipperreference2'],
        //             'ShipperName'           => $row['shippername'],
        //             'user_id'               => $shipment->user_id ?? 0,
        //         ]);
        //     }
        // }
        //     $diff = [];
        //     foreach ($rows as $key=>$row) {
        //         $diff[$key]['awb'] = $row['awb'];
        //         $diff[$key]['codvalue'] = $row['codvalue'];
        //     }
               
        // return back()->with('diff', json_encode($diff));
    }
}

