<?php namespace App\Controllers;

use App\Models\UserModel; // Ensure this path is correct for your UserModel
// Removed redundant use CodeIgniter\Controller; assuming BaseController handles it

class AdminDashboard extends BaseController // CLASS NAME RENAMED
{
    // UserModel is kept here in case you need user-related stats for the main dashboard
    protected UserModel $userModel;
    protected $session;

    public function __construct()
    {
        // Call the parent constructor if your BaseController has one (important for CI4)
        // parent::__construct();

        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
        helper(['url']); // Load URL helper
    }

    /**
     * Main Admin Dashboard - Displays overall admin overview.
     */
    public function index() // Method for the main dashboard view
    {
        // Check if user is logged in and is an admin
        if (!$this->session->get('isLoggedIn') || $this->session->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Access denied. Please log in as an administrator.');
        }

        // --- Data for the *Main Admin Dashboard* goes here ---
        // This controller should focus on general admin overview stats, not cashier management details.
        $data = [
            'page_title' => 'Admin Dashboard Overview',
            // Example data (replace with actual logic from your models):
            'total_orders' => 1234, // Fetch from OrderModel
            'revenue_today' => 5678.90, // Fetch from TransactionModel
            'new_users' => 87, // Fetch from UserModel
            'pending_tasks' => 12, // Fetch from TaskModel
            'recent_activity' => [ // Fetch from an ActivityLogModel or similar
                ['description' => 'John Doe placed a new order (#1001).', 'time' => '2 mins ago'],
                ['description' => 'New user Jane Smith registered.', 'time' => '1 hour ago'],
                ['description' => 'Product "Awesome Gadget" updated by Admin.', 'time' => '3 hours ago'],
                ['description' => 'Payment for order #998 received.', 'time' => 'Yesterday'],
            ]
        ];

        // Ensure this view path is correct for your main dashboard content
        return view('admin/dashboard_view', $data);
    }
}