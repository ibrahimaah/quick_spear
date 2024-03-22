<?php

namespace App\Exports;

use App\Models\Shipment;
use App\Models\Transaction;
use Illuminate\Http\Request; 
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AdminPaymentExport implements FromView
{
    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }
    public function view(): View
    {
        $transaction = Transaction::where('id', $this->request)->first();
        if (!$transaction) {
            return back()->with('error', 'Not Found');
        }
        $awb = [];
        foreach ($transaction->imports as $im) {
            $awb[] = $im->AWB;
        }

        $shipments = Shipment::whereIn('shipmentID', $awb)->latest()->get(); 
        
        return view('pages.user.express.export', [
            'shipments' => $shipments,
            'pdf' => false
        ]);
    }

    // Transaction::whereDateBetween('created_at', [$this->request->from, $this->request->to])->get();
}
