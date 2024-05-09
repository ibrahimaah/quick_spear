<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use Exception;

class InvoiceController extends Controller
{
    public function invoice()
    {
        // return view('admin.invoices.index');
        try 
        {

            set_time_limit(300);
            // $pdf = PDF::load/View('pdf.document', $data); 
            $pdf = PDF::loadView('admin.invoices.index');
            return $pdf->stream('invoice.pdf');
        }
        catch(Exception $ex)
        {
            return $ex->getMessage();
        }
        
    }
}
