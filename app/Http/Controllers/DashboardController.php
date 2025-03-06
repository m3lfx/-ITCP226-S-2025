<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\DataTables\OrdersDataTable;
use App\Charts\CustomerChart;
use DB;

class DashboardController extends Controller
{

    public function index() {
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
        $dataset = $dataset->backgroundColor([
            '#7158e2',
            '#3ae374',
            '#ff3838',
        ]);

        $customerChart->options([
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

          return view('dashboard.index', compact('customerChart'));
    }

    public function getUsers(UsersDataTable $dataTable) {
        return $dataTable->render('dashboard.users');
    }

    public function getOrders(OrdersDataTable $dataTable) {
        return $dataTable->render('dashboard.orders');
    }
}
