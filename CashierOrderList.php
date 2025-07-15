<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class CashierOrderList extends BaseController
{
    public function index()
    {
        // Static sample orders
        $orders = [
            [
                'order_number' => 'ORD-2001',
                'customer'     => 'Ana Cruz',
                'items'        => 'Burger x1, Fries x1, Soda x1',
                'total'        => 189.00,
                'status'       => 'Completed',
                'date'         => '2025-07-15 10:00 AM'
            ],
            [
                'order_number' => 'ORD-2002',
                'customer'     => 'Luis Reyes',
                'items'        => 'Spaghetti x1, Iced Tea x2',
                'total'        => 215.00,
                'status'       => 'Pending',
                'date'         => '2025-07-15 10:45 AM'
            ]
        ];

        return view('cashier/order_list', [
            'page_title' => 'Cashier Order List',
            'orders'     => $orders
        ]);
    }
}
