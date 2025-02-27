<?php

namespace App\DataTables;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use DB;

class OrdersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable( $query)
    {
        return datatables()->query($query)
        ->addColumn('action',  function ($row) {
            $actionBtn = '<a href="#"  class="btn details btn-primary">Details</a>';
            // $actionBtn = '<a href="' . route('admin.orderDetails', $row->orderinfo_id) . '"  class="btn details btn-primary">Details</a>';
            return $actionBtn;
        })->rawColumns(['action'])
        ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Order $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $orders = DB::table('customer as c')
            ->join('orderinfo as o', 'o.customer_id', '=', 'c.customer_id')
            ->join('orderline as ol', 'o.orderinfo_id', '=', 'ol.orderinfo_id')
            ->join('item as i', 'ol.item_id', '=', 'i.item_id')
            ->select('o.orderinfo_id as orderinfo_id', 'c.fname', 'c.lname', 'c.addressline', 'o.date_placed', 'o.status', DB::raw("SUM(ol.quantity * i.sell_price) as total"))
            ->groupBy('o.orderinfo_id');

        return $orders;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('orders-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->parameters([
                'dom'          => 'Blfrtip',
                'buttons'      => ['export', 'print', 'reset', 'reload', 'pdf', 'excel'],
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
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
                ['data' => 'orderinfo_id', 'name' => 'o.orderinfo_id', 'title' => 'order id'],
                ['data' => 'lname', 'name' => 'c.lname', 'title' => 'last name'],
                ['data' => 'fname', 'name' => 'c.fname', 'title' => 'first Name'],
                ['data' => 'addressline', 'name' => 'c.addressline', 'title' => 'address'],
                ['data' => 'date_placed', 'name' => 'o.date_placed', 'title' => 'date ordered'],
                ['data' => 'status', 'name' => 'o.status', 'title' => 'status'],
                Column::make('total')->searchable(false)
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Orders_' . date('YmdHis');
    }
}
