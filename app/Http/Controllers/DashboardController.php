<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\DataTables\OrdersDataTable;
use App\Charts\CustomerChart;
use App\Charts\MonthlySales;

use App\Charts\ItemChart;
use DB;

class DashboardController extends Controller
{
    protected $bgcolor;
    public function __construct()
    {

        $this->bgcolor = collect([
            '#7158e2',
            '#3ae374',
            '#ff3838',
            "#FF851B",
            "#7FDBFF",
            "#B10DC9",
            "#FFDC00",
            "#001f3f",
            "#39CCCC",
            "#01FF70",
            "#85144b",
            "#F012BE",
            "#3D9970",
            "#111111",
            "#AAAAAA",
        ]);
    }
    public function index()
    {
        // SELECT count(addressline), addressline from customer group by addressline;
        $customer = DB::table('customer')
            ->whereNotNull('addressline')
            ->groupBy('addressline')
            ->orderBy('total')
            ->pluck(DB::raw('count(addressline) as total'), 'addressline')->all();

        // dd($customer);
        // dd(array_values($customer));
        $customerChart = new CustomerChart;
        $dataset = $customerChart->labels(array_keys($customer));
        $dataset = $customerChart->dataset(
            'Customer Demographics',
            'bar',
            array_values($customer)
        );
        $dataset = $dataset->backgroundColor($this->bgcolor);

        $customerChart->options([
            'indexAxis' => 'y',
            'responsive' => true,
            'legend' => ['display' => true],
            'tooltips' => ['enabled' => true],
            'aspectRatio' => 1,
            'scales' => [
                'yAxes' => [
                    [
                        'display' => true,
                    ],
                ],
                'xAxes' => [
                    [
                        'gridLines' => ['display' => false],
                        'display' => true,
                    ],
                ],
            ],
        ]);

        //SELECT monthname(date_placed), sum(i.sell_price * ol.quantity) FROM `orderinfo` o inner join orderline ol on o.orderinfo_id = ol.orderinfo_id inner join item i on i.item_id = ol.item_id group by month(date_placed);

        $sales = DB::table('orderinfo AS o')
            ->join('orderline AS ol', 'o.orderinfo_id', '=', 'ol.orderinfo_id')
            ->join('item AS i', 'ol.item_id', '=', 'i.item_id')
            ->orderBy(DB::raw('month(o.date_placed)'), 'ASC')
            ->groupBy(DB::raw('month(o.date_placed)'))
            ->pluck(
                DB::raw('sum(ol.quantity * i.sell_price) AS total'),
                DB::raw('monthname(o.date_placed) AS month')
            )
            ->all();
        // dd($sales);

        $salesChart = new MonthlySales;
        $dataset = $salesChart->labels(array_keys($sales));
        $dataset = $salesChart->dataset(
            'Monthly sales 2025',
            'line',
            array_values($sales)
        );
        $dataset = $dataset->backgroundColor($this->bgcolor);

        $salesChart->options([
            'responsive' => true,
            'legend' => ['display' => true],
            'tooltips' => ['enabled' => true],
            'aspectRatio' => 1,
            'scales' => [
                'yAxes' => [
                    [
                        'display' => true,
                    ],
                ],
                'xAxes' => [
                    [
                        'gridLines' => ['display' => false],
                        'display' => true,
                    ],
                ],
            ],
        ]);

        $items = DB::table('orderline AS ol')
        ->join('item AS i', 'ol.item_id', '=', 'i.item_id')
        ->groupBy('i.description')
        ->orderBy('total', 'DESC')
        ->pluck(DB::raw('sum(ol.quantity) AS total'), 'description')
        ->all();
        // dd($items);

        $itemChart = new ItemChart;
        $dataset = $itemChart->labels(array_keys($items));
        // dd($dataset);
        $dataset = $itemChart->dataset(
            'Item sold',
            'doughnut',
            array_values($items)
        );
       
        $dataset = $dataset->backgroundColor($this->bgcolor);
       
        $dataset = $dataset->fill(false);
        $itemChart->options([
            'responsive' => true,
            'legend' => ['display' => true],
            'tooltips' => ['enabled' => true],
            'aspectRatio' => 1,
    ]);

        return view('dashboard.index', compact('customerChart', 'salesChart', 'itemChart'));
    }

    public function getUsers(UsersDataTable $dataTable)
    {
        return $dataTable->render('dashboard.users');
    }

    public function getOrders(OrdersDataTable $dataTable)
    {
        return $dataTable->render('dashboard.orders');
    }
}
