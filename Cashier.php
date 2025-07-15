<?php namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Cashier extends BaseController
{
    protected UserModel $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
        helper(['url']); // Load URL helper
    }

    /**
     * Displays the pending page for cashiers.
     * This page will check the user's status.
     */
    public function pending()
    {
        // Ensure user is logged in and is a cashier
        if (!$this->session->get('isLoggedIn') || $this->session->get('role') !== 'cashier') {
            return redirect()->to('/login')->with('error', 'Access denied. Please log in as a cashier.');
        }

        $userId = $this->session->get('id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            // User not found, perhaps session is stale
            $this->session->destroy();
            return redirect()->to('/login')->with('error', 'User not found. Please log in again.');
        }

        if ($user['status'] === 'approved') {
            // If approved, redirect to cashier dashboard
            return redirect()->to('/cashier/dashboard')->with('message', 'Your account has been approved! You can now access your dashboard.');
        } elseif ($user['status'] === 'rejected') {
            // If rejected, inform the user
            $this->session->destroy(); // Log them out as they cannot proceed
            return redirect()->to('/login')->with('error', 'Your account has been rejected by the administrator. Please contact support.');
        }

        // Still pending, display pending message
        return view('cashier/pending', ['userStatus' => $user['status']]);
    }

    /**
     * Cashier Dashboard - Accessible only after approval.
     */
    public function dashboard()
    {
        // Check if user is logged in and is a cashier
        if (!$this->session->get('isLoggedIn') || $this->session->get('role') !== 'cashier') {
            return redirect()->to('/login')->with('error', 'Access denied. Please log in as a cashier.');
        }

        // Re-check status to ensure they are approved, in case they bypassed pending page
        $userId = $this->session->get('id');
        $user = $this->userModel->find($userId);

        if (!$user || $user['status'] !== 'approved') {
            $this->session->destroy(); // Log them out if not approved
            return redirect()->to('/login')->with('error', 'Your account is not approved yet or has been rejected. Please wait for admin approval.');
        }

        return view('cashier/dashboard');
    }
}
