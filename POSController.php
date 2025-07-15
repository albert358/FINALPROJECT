<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class POSController extends BaseController
{
    public function index()
    {
        return view('cashier/pos');
    }
}

