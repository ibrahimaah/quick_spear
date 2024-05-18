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

    
    // public $filterData;
    private $is_from_admin;
    // private $user_id;
    private $shop_id;
    private $delegate_id;
    //$user_id , to show shipments for each user in dashboard
    //$delegate_id to show delegate shipments
    // public function __construct($filterData,$is_from_admin=false,$user_id=null,$delegate_id=null)
    public function __construct($is_from_admin=false,$shop_id=null,$delegate_id=null)
    {
        // $this->filterData = $filterData;
        $this->is_from_admin = $is_from_admin;
        $this->shop_id = $shop_id;
        $this->delegate_id = $delegate_id;
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
        ->editColumn('checkbox', function ($query) {
            return '<input type="checkbox" class="chk_shipment" value="'.$query->id.'">';
        })
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
            // $city_from = $query->address->City->id; 
            $city_from = $query->shop?->city_id;
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
        ->editColumn('status', function ($query) {
            return $query->get_status();
        })
        ->addColumn('user_actions', function ($query) {
            return view('components.user-actions',['query'=>$query]);
        })
        ->addColumn('delegate_actions', function ($query) 
        {
            return ' <a onclick="confirm(\'برجاء تأكيد العملية\') ? document.getElementById(\'cancel'. $query->id .'\').submit() : \'\';" class="btn btn-sm btn-secondary"> إلغاء</a>

            <form action="'. route('admin.shipments.cancel_assign_delegate', $query->id) .'" id="cancel'. $query->id .'" method="post">
            '. csrf_field() .'
            '. method_field("POST") .'
            </form>';
        })

        ->addColumn('admin_actions', function ($query) 
        {
            return view('components.shipments-admin-actions',['query'=>$query]);;
        })
        ->rawColumns(['actions','admin_actions','status','checkbox','delegate_actions'])
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
        if($this->is_from_admin)
        {
            return $model->newQuery()->orderBy('id','DESC');
        }

        if ($this->delegate_id) 
        {
            return $model->newQuery()->where('delegate_id',$this->delegate_id)->orderBy('id','DESC');
        }

        // $user_id =  $this->user_id ?? auth()->user()->id;
        
        // return $model->newQuery()->where('user_id',$user_id);
        return $model->newQuery()->where('shop_id',$this->shop_id)->orderBy('id','DESC');

        // $query = $model::where('user_id', $user_id)->where(function ($q) {
        //     if ($this->filterData->from!=null) {
        //         $q->whereBetween('created_at', [$this->filterData->from, $this->filterData->to]);
        //     }
        //     if ($this->filterData->status!=null) {
        //         $q->where('status', 'LIKE', "%".$this->filterData->status."%");
        //     }
        //     // if ($this->filterData->process!=null && $this->filterData->cod!=null) {
        //     //     $q->where('cash_on_delivery_amount', $this->filterData->process, $this->filterData->cod);
        //     // }
        //     if ($this->filterData->phone!=null) {
        //         $q->where('consignee_phone', 'LIKE', "%".$this->filterData->phone."%");
        //     }
        // })->with('address');

        // return $query;
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
        if($this->is_from_admin)
        {
            $columns = [
                // $this->column('checkbox','<input type="checkbox" id="master">',false,false,false,false,'checkbox'),
                $this->column('checkbox', false, false, false, false),
                // $this->column('id','#',false,false,false,false), 
                $this->column('DT_RowIndex','#',false,false,false,false), 
                $this->column('consignee_city',__('City'),false,false,false,false), 
                $this->column('consignee_region',__('consignee_region'),false,false,false,false),
                $this->column('consignee_phone', __('Phone'),false,false,false,false),
                // $this->column('order_price', __('Order price includes delivery'),false,false,false,false),
                $this->column('order_price', __('Order price'),false,false,false,false),
                $this->column('value_on_delivery', __('Value on delivery'),false,false,false,false),
                $this->column('delivery_fees',__('delivery_fees'),false,false,false,false),
                $this->column('status', __('Action Status'),false,true,false,false),
                $this->column('id',__('order_number'),false,true,false,false),
                $this->column('customer_notes',__('Customer notes'),false,false,false,false),
                $this->column('delegate_notes', __('Delegate notes')),
                $this->column('created_at',__('Created.'),false,false,false,false),
                $this->column('accepted_by_admin_at',__('accepted_by_admin_at'),false,false,false,false), 
                $this->column('admin_actions',__('Actions'),false,false,false,false), 
            ];
        }
        elseif($this->delegate_id)
        {
            $columns = [
                // $this->column('checkbox','<input type="checkbox" id="master">',false,false,false,false,'checkbox'),
                // $this->column('checkbox', false, false, false, false),
                $this->column('DT_RowIndex','#',false,false,false,false), 
                // $this->column('consignee_city',__('City'),false,false,false,false), 
                $this->column('consignee_region',__('consignee_region'),false,false,false,false),
                $this->column('consignee_phone', __('Phone'),false,false,false,false),
                // $this->column('order_price', __('Order price includes delivery'),false,false,false,false),
                $this->column('order_price', __('Order price'),false,false,false,false),
                // $this->column('value_on_delivery', __('Value on delivery'),false,false,false,false),
                // $this->column('delivery_fees',__('delivery_fees'),false,false,false,false),
                $this->column('status', __('Action Status'),false,true,false,false),
                $this->column('id',__('order_number'),false,true,false,false),
                // $this->column('customer_notes',__('Customer notes'),false,false,false,false),
                $this->column('delegate_notes', __('Delegate notes')),
                $this->column('delegate_actions', __('Actions')),
                // $this->column('created_at',__('Created.'),false,false,false,false),
                // $this->column('accepted_by_admin_at',__('accepted_by_admin_at'),false,false,false,false), 
            ];
        }
        elseif (!$this->is_from_admin && !$this->delegate_id)  //user datatable
        {
            $columns = [
                // $this->column('checkbox','<input type="checkbox" id="master">',false,false,false,false,'checkbox'),
                $this->column('checkbox', false, false, false, false),
                $this->column('DT_RowIndex','#',false,false,false,false), 
                $this->column('consignee_city',__('City'),false,false,false,false), 
                $this->column('consignee_region',__('consignee_region'),false,false,false,false),
                $this->column('consignee_phone', __('Phone'),false,false,false,false),
                // $this->column('order_price', __('Order price includes delivery'),false,false,false,false),
                $this->column('order_price', __('Order price'),false,false,false,false),
                $this->column('value_on_delivery', __('Value on delivery'),false,false,false,false),
                $this->column('delivery_fees',__('delivery_fees'),false,false,false,false),
                $this->column('status', __('Action Status'),false,true,false,false),
                $this->column('id',__('order_number'),false,true,false,false),
                $this->column('customer_notes',__('Customer notes'),false,false,false,false),
                $this->column('delegate_notes', __('Delegate notes')),
                $this->column('created_at',__('Created.'),false,false,false,false),
                $this->column('accepted_by_admin_at',__('accepted_by_admin_at'),false,false,false,false), 
                $this->column('user_actions', __('Actions'),false,false,false,false)
            ];
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
