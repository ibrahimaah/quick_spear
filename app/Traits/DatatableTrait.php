<?php

namespace App\Traits;

use Yajra\DataTables\Html\Column;

trait DatatableTrait
{
    public function column($make,$title,$orderable=true,$searchable=true,$exportable=true,$printable=true,$name=null)
    {
             $col = $orderable == true ? Column::make($make) : Column::computed($make);
                if ($name != null) {
                    $col->name($name);
                }
             $col->title($title)
                ->orderable($orderable)
                ->searchable($searchable)
                ->exportable($exportable)
                ->printable($printable)
                ->addClass('text-center');

        return $col;
    }

    public function IndexColumn()
    {
        return $this->column('DT_RowIndex', '#',false,false)->name('DT_RowIndex');
    }

    public function IdColumn($visible = false) {
        return $this->column('id', __('ID'))->visible($visible);
    }
}