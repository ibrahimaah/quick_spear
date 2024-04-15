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
    private $is_from_admin;
    public function __construct($filterData,$is_from_admin=false)
    {
        $this->filterData = $filterData;
        $this->is_from_admin = $is_from_admin;
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
            return '<input type="checkbox" class="sub_chk" data-id="'. $query->id .'">';
        }) 
        ->addColumn('status', function ($query) {
            return $query->get_status();
        })
        ->addColumn('actions', function ($query) {
            return '<a href="express/edit/'.$query->id.'" class="btn btn-warning"><i class="bi bi-pencil"></i></button>';
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
        $columns = [
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
            $this->column('created_at',__('Created.')),
            $this->column('accepted_by_admin_at',__('accepted_by_admin_at')), 
            
        ];

        
        if($this->is_from_admin)
        {
            // Find the index of 'customer_notes'
            $index = array_search('customer_notes', array_column($columns, 'name'));
            if ($index !== false) {
                // Insert 'delegate_notes' after 'customer_notes'
                array_splice($columns, $index + 1, 0, [$this->column('delegate_notes', __('Delegate notes'))]);
            }
        }
        if (!$this->is_from_admin) {
            $columns[]=$this->column('actions', __('Actions'),false,false,false,false);
        }
        return $columns;
      
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
