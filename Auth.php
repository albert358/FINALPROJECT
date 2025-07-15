<?php namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    protected UserModel $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = \Config\Services::session();
        helper(['form', 'url']); // Load form and URL helpers
    }

    /**
     * Display the registration form.
     */
    public function register()
    {
        return view('auth/register');
    }

    /**
     * Handle user registration (for cashiers).
     */
    public function registerSave()
    {
        // Set validation rules
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'password' => 'required|min_length[6]|max_length[255]',
            'confirm_password' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            // If validation fails, reload the form with errors
            return view('auth/register', [
                'validation' => $this->validator
            ]);
        }

        // Save the new cashier user with 'pending' status
        $this->userModel->save([
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'), // Password will be hashed by model's beforeInsert
            'role' => 'cashier',
            'status' => 'pending' // Default status for new cashiers
        ]);

        // Redirect to a pending page
        return redirect()->to('/cashier/pending')->with('message', 'Registration successful! Your account is pending admin approval.');
    }

    /**
     * Display the login form.
     */
    public function login()
    {
        return view('auth/login');
    }

    /**
     * Handle user login.
     */
    public function loginAuth()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $this->userModel->getUserByUsername($username);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                // Password matches
                if ($user['status'] === 'approved') {
                    // Set session data
                    $userData = [
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'role' => $user['role'],
                        'isLoggedIn' => true
                    ];
                    $this->session->set($userData);

                    // Redirect based on role
                    if ($user['role'] === 'admin') {
                        return redirect()->to('/admin/dashboard');
                    } else { // cashier
                        return redirect()->to('/cashier/dashboard');
                    }
                } else {
                    // Account is pending or rejected
                    return redirect()->back()->withInput()->with('error', 'Your account is ' . $user['status'] . '. Please wait for admin approval or contact support.');
                }
            } else {
                // Incorrect password
                return redirect()->back()->withInput()->with('error', 'Invalid credentials.');
            }
        } else {
            // User not found
            return redirect()->back()->withInput()->with('error', 'Invalid credentials.');
        }
    }

    /**
     * Log out the user.
     */
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login')->with('message', 'You have been logged out.');
    }
}