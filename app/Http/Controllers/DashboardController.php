<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
class DashboardController extends Controller
{
    public function getUsers(UsersDataTable $dataTable) {
        return $dataTable->render('dashboard.users');
    }
}
