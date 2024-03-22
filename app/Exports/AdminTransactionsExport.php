<?php

namespace App\Exports;

use App\Models\Shipment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Dompdf\Adapter\CPDF;      
use Dompdf\Dompdf;
use Dompdf\Exception;

class AdminTransactionsExport implements FromView
{
    public $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function view(): View
    {
        $transactions = Transaction::get();
        foreach ($transactions as $transaction) {
            $awb = [];
            foreach ($transaction->imports as $im) {
                $awb[] = $im->AWB;
            }

            $shipments = Shipment::whereIn('shipmentID', $awb)->get();
            $transaction->value = $shipments->sum('cash_on_delivery_amount') - $shipments->sum('collect_amount');
        }
        return view('pages.user.payments.export2', [
            'transactions' => $transactions,
            'shipments' => $shipments
        ]);
    }

    // Transaction::whereDateBetween('created_at', [$this->request->from, $this->request->to])->get();
}
