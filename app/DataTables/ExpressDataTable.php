<?php

namespace App\DataTables;

use App\Models\City;
use App\Models\Shipment;
use App\Models\ShipmentRate;
use App\Traits\DatatableTrait;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Livewire\Livewire;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ExpressDataTable extends DataTable
{
    use DatatableTrait;

    public $filterData;

    public function __construct($filterData)
    {
        $this->filterData = $filterData;
    }


    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addIndexColumn()
        ->editColumn('created_at', function ($query) {
            return $query->created_at->format('Y-m-d h:i A');
        })
        ->editColumn('consignee_city', function ($query) {
            return City::findOrFail($query->consignee_city)->name;
        })
        ->editColumn('value_on_delivery', function($query) {
            // return '<input type="checkbox" ' . $this->html->attributes($query->id) . '/>';
            if(!$query->value_on_delivery)
            {
                return __('not_determined_yet');
            }
            else{
                return $query->value_on_delivery;
            }
        })
        ->editColumn('delegate_notes', function($query) {
            // return '<input type="checkbox" ' . $this->html->attributes($query->id) . '/>';
            if(!$query->delegate_notes)
            {
                return __('There is no notes');
            }else{
                return $query->delegate_notes;
            }
        })
        ->editColumn('customer_notes', function($query) {
            // return '<input type="checkbox" ' . $this->html->attributes($query->id) . '/>';
            if(!$query->customer_notes)
            {
                return __('There is no notes');
            }else{
                return $query->customer_notes;
            }
        })
        ->editColumn('delivery_fees', function($query) {
            // return '<input type="checkbox" ' . $this->html->attributes($query->id) . '/>';
            $city_from = $query->address->City->id; 
            $city_to = $query->city_to->id; 
            $delivery_fees = ShipmentRate::where('city_from',"$city_from")->where('city_to',"$city_to")->first()?->rate;

            if(!$delivery_fees)
            {
                return __('not_determined_yet');
            }else{
                return $delivery_fees;
            }
        })
        ->editColumn('accepted_by_admin_at', function ($query) {
            if(!$query->accepted_by_admin_at){
                return __('not_determined_yet');
            }
            return $query->created_at->format('Y-m-d h:i A');
        })
        ->addColumn('checkbox', function($query) {
            // return '<input type="checkbox" ' . $this->html->attributes($query->id) . '/>';
            return '<input type="checkbox" class="sub_chk" data-id="'. $query->id .'">';
        })
        // ->addColumn('Aramix', function ($query) {
        //     return 'Aramix';
        // })
        ->addColumn('status', function ($query) {
            return Livewire::mount('shipment-all', ['shipment' => $query])->html();
        })
        ->addColumn('actions', function ($query) {
         $html = '';
         $shipmentImp = \App\Models\ShipmentImport::where('awb', $query->shipmentID)->first();
         if ($shipmentImp) {
             $transaction = \App\Models\Transaction::find($shipmentImp->transaction_id);
             if ($transaction) {
                if ($transaction->image != 'N/A') {
                    $html .= ' <a href="'. url($transaction->image) .'" style="background-color: yellow; border-color: yellow;" target="_blanck" class="btn btn-info"><span class="text text-warning">$</span></a>';
                 }
             }
         }
        //  $html .= '<a class="btn btn-success" href="'. route('front.express.show', $query->id) .'"><i
        //  class="fa fa-eye"></i> '. __('Showing') .'</a>
        $html .= '<a href="express/edit/'.$query->id.'" class="btn btn-warning"><i class="bi bi-pencil"></i></button>';

        // $html .= '<button type="button" class="btn btn-primary" data-bs-toggle="modal"
        //    data-bs-target="#editOrder_'. $query->status . '_' . $query->id .'">'. __('Editing Orders') .'</button>';

        //  $html .='<div class="modal fade" id="editOrder_'. $query->status . '_' . $query->id .'"
        //  tabindex="-1"
        //  aria-labelledby="editOrder_'. $query->status . '_' . $query->id .'Label"
        //  aria-hidden="true">
        //         <div class="modal-dialog">
        //             <div class="modal-content">
        //                 <div class="modal-header">
        //                     <h5 class="modal-title"
        //                         id="editOrder_'. $query->status . '_' . $query->id .'Label">
        //                         '. __('Editing Orders') .'</h5>
        //                     <button type="button" class="btn-close" data-bs-dismiss="modal"
        //                         aria-label="Close"></button>
        //                 </div>
        //                 <form method="POST"
        //                     action="'. route('front.express.shipment_update') .'">
        //                     '.csrf_field() .'
        //                     <div class="modal-body">
        //                         <div class="mb-3">
        //                             <input type="hidden" name="shipment_id"
        //                                 value="'. $query->id .'" class="form-control"
        //                                 id="recipient-name">
        //                         </div>
        //                         <div class="mb-3">
        //                             <label for="message-text"
        //                                 class="col-form-label">'. __('Description') .'</label>
        //                             <textarea class="form-control" name="desc" id="message-text"></textarea>
        //                         </div>
        //                     </div>
        //                     <div class="modal-footer">
        //                         <button type="button" class="btn btn-secondary"
        //                             data-bs-dismiss="modal">'. __('Close') .'</button>
        //                         <button type="submit"
        //                             class="btn btn-primary">'. __('Apply') .'</button>
        //                     </div>
        //                 </form>
        //             </div>
        //         </div>
        //     </div>';

         return $html;
        })
        ->rawColumns(['actions','status','checkbox'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Express $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Shipment $model): QueryBuilder
    {
        $query = $model::where('user_id', auth()->user()->id)->where(function ($q) {
            if ($this->filterData->from!=null) {
                $q->whereBetween('created_at', [$this->filterData->from, $this->filterData->to]);
            }
            if ($this->filterData->status!=null) {
                $q->where('status', 'LIKE', "%".$this->filterData->status."%");
            }
            // if ($this->filterData->process!=null && $this->filterData->cod!=null) {
            //     $q->where('cash_on_delivery_amount', $this->filterData->process, $this->filterData->cod);
            // }
            if ($this->filterData->phone!=null) {
                $q->where('consignee_phone', 'LIKE', "%".$this->filterData->phone."%");
            }
        })->with('address');

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('express-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->autoWidth(false)
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ])
                    
                    ;
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            // $this->IndexColumn(),
            // $this->column('checkbox',$this->form->checkbox('', '', false, ['id' => 'dataTablesCheckbox']),false,false,false,false,'checkbox'),
            $this->column('checkbox','<input type="checkbox" id="master">',false,false,false,false,'checkbox'),
            $this->column('consignee_city',__('City')), 
            $this->column('consignee_region',__('consignee_region')),
            $this->column('consignee_phone', __('Phone')),
            $this->column('order_price', __('Order price includes delivery')),
            $this->column('value_on_delivery', __('Value on delivery')),
            $this->column('delivery_fees',__('delivery_fees')),
            $this->column('status', __('Action Status'),false,false),
            $this->column('id',__('order_number')),
            $this->column('customer_notes',__('Customer notes')),
            $this->column('delegate_notes',__('Delegate notes')),
            $this->column('created_at',__('Created.')),
            $this->column('accepted_by_admin_at',__('accepted_by_admin_at')),
            // $this->column('consignee_name',  __('Consignee')), 
            
            // $this->column('cash_on_delivery_amount', __('Cash On Delivery')), 
            
            $this->column('actions', __('Actions'),false,false,false,false)
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Express_' . date('YmdHis');
    }
}
