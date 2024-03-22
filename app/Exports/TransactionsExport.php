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

class TransactionsExport implements FromView
{
    public $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function view(): View
    {
        $shipments = new Shipment();
        $transactions = Transaction::where('user_id', auth()->user()->id)->whereBetween('created_at', [$this->request->from, $this->request->to])->get();
        // dd($transactions);
        foreach ($transactions as $transaction) {
            $awb = [];
            foreach ($transaction->imports as $im) {
                $awb[] = $im->AWB;
            }

            $shipments = Shipment::whereIn('shipmentID', $awb)->where('user_id', auth()->user()->id)->latest()->get();
        }
        return view('pages.user.payments.export', [
            'transactions' => $transactions,
            'shipments' => $shipments
        ]);
    }

    // Transaction::whereDateBetween('created_at', [$this->request->from, $this->request->to])->get();
}
