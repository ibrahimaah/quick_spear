<?php

namespace App\Exports;

use App\Models\Shipment;
use App\Models\Transaction;
use Illuminate\Http\Request; 
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PaymentExport implements FromView
{
    public $request;
    public $user_id;
    public function __construct($request, $user_id)
    {
        $this->request = $request;
        $this->user_id = $user_id;
    }
    public function view(): View
    {
        $transaction = Transaction::where(['id' => $this->request, 'user_id' => $this->user_id])->first();
        if (!$transaction) {
            return back()->with('error', 'Not Found');
        }
        $awb = [];
        foreach ($transaction->imports as $im) {
            $awb[] = $im->AWB;
        }

        $shipments = Shipment::whereIn('shipmentID', $awb)->where('user_id', $this->user_id)->latest()->get(); 
        
        return view('pages.user.express.export', [
            'shipments' => $shipments,
            'pdf' => false
        ]);
    }

    // Transaction::whereDateBetween('created_at', [$this->request->from, $this->request->to])->get();
}
