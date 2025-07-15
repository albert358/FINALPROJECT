<?php namespace App\Controllers;

use App\Models\UserModel; // Ensure this path is correct for your UserModel

class ManageCashier extends BaseController
{
    protected UserModel $userModel;
    protected $session;

    public function __construct()
    {
        // parent::__construct(); // Call the parent constructor if your BaseController has one
        $this->userModel = new UserModel();

        // FIX: Changed to use the service() helper function
        $this->session = service('session');

        helper(['url']);
    }

    /**
     * Displays pending and approved cashier accounts for management.
     */
    public function index()
    {
        // Remove temporary debug lines now that we know the problem was session instantiation
        // echo "Reached ManageCashier::index() method.<br>";
        // echo "Is Logged In: " . var_export($this->session->get('isLoggedIn'), true) . "<br>";
        // echo "User Role: " . $this->session->get('role') . "<br>";

        // Check if user is logged in and is an admin
        if (!$this->session->get('isLoggedIn') || $this->session->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Access denied. Please log in as an administrator.');
        }

        $pendingCashiers = $this->userModel->getPendingCashiers();
        $approvedCashiers = $this->userModel->getApprovedCashiers();

        return view('admin/cashier_management_view', [ // Ensure this view path is correct
            'page_title' => 'Manage Cashiers', // Set page title
            'pendingCashiers' => $pendingCashiers,
            'approvedCashiers' => $approvedCashiers
        ]);
    }

    /**
     * Approve a cashier account.
     * @param int $userId
     */
    public function approve($userId)
    {
        // Check if user is logged in and is an admin
        if (!$this->session->get('isLoggedIn') || $this->session->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Access denied.');
        }

        // Add server-side validation to ensure userId is valid (e.g., numeric, exists)
        if (!is_numeric($userId) || $userId <= 0) {
            return redirect()->back()->with('error', 'Invalid cashier ID.');
        }

        // Assuming updateUserStatus can update the 'status' column
        if ($this->userModel->updateUserStatus($userId, 'approved')) {
            return redirect()->back()->with('message', 'Cashier account approved successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to approve cashier account.');
        }
    }

    /**
     * Reject a cashier account.
     * @param int $userId
     */
    public function reject($userId)
    {
        // Check if user is logged in and is an admin
        if (!$this->session->get('isLoggedIn') || $this->session->get('role') !== 'admin') {
            return redirect()->to('/login')->with('error', 'Access denied.');
        }

        // Add server-side validation to ensure userId is valid
        if (!is_numeric($userId) || $userId <= 0) {
            return redirect()->back()->with('error', 'Invalid cashier ID.');
        }

        // Assuming updateUserStatus can update to 'rejected' or delete the user
        // If 'rejected' means deletion, then you might call delete($userId) instead.
        if ($this->userModel->updateUserStatus($userId, 'rejected')) {
            return redirect()->back()->with('message', 'Cashier account rejected successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to reject cashier account.');
        }
    }
}