<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\DataTables\OrdersDataTable;
class DashboardController extends Controller
{
    public function getUsers(UsersDataTable $dataTable) {
        return $dataTable->render('dashboard.users');
    }

    public function getOrders(OrdersDataTable $dataTable) {
        return $dataTable->render('dashboard.orders');
    }
}
