<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Octw\Aramex\Aramex;

class ShipmentAll extends Component
{
    public $shipment;

    public $test;



    public $status1 = [
        'SH044',
        'SH157',
        'SH162',
        'SH163',
        'SH199',
        'SH033',
        'SH043',
        'SH294',
        'SH480',
        'SH240',
        'SH266',
        'SH267',
        'SH573',
        'SH217',
        'SH218',
        'SH219',
        'SH220',
        'SH221',
        'SH253',
        'SH254',
        'SH255',
        'SH258',
        'SH259',
        'SH260',
        'SH265',
        'SH276',
        'SH277',
        'SH378',
        'SH397',
        'SH398',
        'SH400',
        'SH402',
        'SH403',
        'SH406',
        'SH410',
        'SH411',
        'SH443',
        'SH444',
        'SH445',
        'SH446',
        'SH447',
        'SH013',
        'SH014',
        'SH203',
        'SH235',
        'SH396',
        'SH256',
        'SH003',
        'SH004',
        'SH025',
        'SH073',
        'SH252',
        'SH200',
        'SH249',
        'SH250',
        'SH251',
        'SH262',
        'SH271',
        'SH295',
        'SH273',
        'SH296',
        'SH369',
        'SH375',
        'SH575',
        'SH516',
        'SH237',
        'SH476',
        'SH477',
        'SH478',
        'SH008',
        'SH156',
        'SH162',
        'SH340',
        'SH341',
        'SH342',
        'SH343',
        'SH344',
        'SH376',
        'SH377',
        'SH467',
        'SH468',
        'SH469',
        'SH470',
        'SH471',
        'SH472',
        'SH473',
        'SH489',
        'SH498',
        'SH157',
        'SH515',
        'SH556',
        'SH018',
        'SH164',
        'SH521',
        'SH001',
        'SH010',
        'SH022',
        'SH023',
        'SH047',
        'SH048',
        'SH208',
        'SH209',
        'SH210',
        'SH211',
    ];

    public $status2= [
        'SH005',
        'SH006',
        'SH007',
        'SH012',
        'SH154',
        'SH234',
        'SH354',
        'SH239',
        'SH355',
        'SH496',
        'SH527',
        'SH528',
    ];

    public function loaded()
    {
        try {
            $this->statusGet();
        } catch (\Throwable $th) {
        }
    }

    public function mount()
    {
        $this->test = 'test';
        $this->statusGet();
    }

    public function statusGet()
    {
        // dd('mhd');
        $shipment = $this->shipment;
        if ($shipment) {
            if ($shipment->status != 5) {
                //  dd($shipment);
                try {
                    // dd($shipment);
                    // $data = Aramex::trackShipments([$shipment->shipmentID]);
                    // if (!$data->HasErrors) {
                    //     // dd($data);
                    //     $det = $data->TrackingResults->KeyValueOfstringArrayOfTrackingResultmFAkxlpY->Value->TrackingResult;

                    //     if (gettype($det) == "array") {
                    //         // dd(array_search($det[0]->UpdateCode, $this->status1));
                    //         if ($det[0]->UpdateCode == "SH014") {
                    //             $shipment->update(['status' => 0]);
                    //         }
                    //         elseif (array_search($det[0]->UpdateCode, $this->status1) !== false) {
                    //             $shipment->update(['status' => 1]);
                    //         }
                    //         elseif (array_search($det[0]->UpdateCode, $this->status2) !== false) {
                    //             $shipment->update(['status' => 2]);
                    //         }
                    //         elseif ($data->TrackingResults->KeyValueOfstringArrayOfTrackingResultmFAkxlpY->Value->TrackingResult[0]->UpdateCode == "SH069") {
                    //             $shipment->update(['status' => 3]);
                    //         }
                    //     } else {
                    //         if ($data->TrackingResults->KeyValueOfstringArrayOfTrackingResultmFAkxlpY->Value->TrackingResult->UpdateCode == "SH014") {
                    //             $shipment->update(['status' => 0]);
                    //         }
                    //     }

                    //     // dd($data);
                    // }
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }
    }
    public function render()
    {
        return view('livewire.shipment-all', [
            // 'status' => $this->shipment->get_status(),
            'status' => $this->shipment->get_status_ar(),
            'test'   => $this->test,
        ]);
    }
}
