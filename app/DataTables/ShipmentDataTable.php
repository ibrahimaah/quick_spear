<?php

namespace App\DataTables;

use App\Models\Shipment;
use App\Traits\DatatableTrait;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Livewire\Livewire;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ShipmentDataTable extends DataTable
{
    use DatatableTrait;
    protected $status;
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function __construct($status=null)
    {
        $this->status = $status;
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $query = $query->where('status',$this->status);
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('created_at', function ($query) {
                return $query->created_at->format('Y-m-d');
            })
            // ->addColumn('Aramix', function ($query) {
            //     return 'Aramix';
            // })
            ->editColumn('status', function ($query) {
                // return Livewire::mount('shipment-all', ['shipment' => $query])->html();
                return getStatusInfo($query->status);
            })
            ->addColumn('actions', function ($query) {
                return '<a class="" href="'. route('admin.shipments.edit', $query->id) .'"><i
                class="fa fa-edit"></i> تعديل</a>
        <a class="" href="'. route('admin.shipments.show', $query->id) .'"><i
                class="fa fa-eye"></i> عرض</a>
                <a onclick="confirm(\'برجاء تأكيد الحذف\') ? document.getElementById(\'des'. $query->id .'\').submit() : \'\';" style="color: #f73164; cursor: pointer"><i class="fa fa-trash"></i> حذف</a>
                <form action="'. route('admin.shipments.destroy', $query->id) .'" id="des'. $query->id .'" method="post">
                '. csrf_field() .'
                '. method_field("DELETE") .'
                </form>
                ';
            })
            ->rawColumns(['actions','status'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Shipment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Shipment $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('shipment-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        // Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            $this->IndexColumn(),
            $this->column('created_at','التاريخ',false),
            $this->column('consignee_name', 'المرسل إليه',false),
            $this->column('consignee_phone', 'رقم الهاتف',false),
            $this->column('status', 'الحاله',false,false),
            $this->column('actions', 'العمليات',false,false,false,false)
        ]; 
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Shipment_' . date('YmdHis');
    }
}
