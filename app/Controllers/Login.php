<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\SettingsModel;

class Login extends BaseController
{
    protected $userModel;
    protected $settingsModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->settingsModel = new SettingsModel();
    }

    public function index()
    {
        // Redirect if already logged in
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        // Get settings
        $siteName = $this->settingsModel->getSetting('site_name', 'Perpustakaan Digital');
        $siteDescription = $this->settingsModel->getSetting('site_description', 'Sistem Perpustakaan Digital');
        $allowRegistration = $this->settingsModel->getSetting('allow_registration', true);

        $data = [
            'siteName' => $siteName,
            'siteDescription' => $siteDescription,
            'allowRegistration' => $allowRegistration
        ];

        return view('auth/login', $data);
    }

    public function authenticate()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return view('auth/login', ['validation' => $this->validator]);
        }

        // Get form data
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Authenticate user
        $user = $this->userModel->authenticate($email, $password);

        if ($user) {
            // Set session data
            session()->set([
                'isLoggedIn' => true,
                'userId' => $user['id'],
                'userEmail' => $user['email'],
                'userName' => $user['name'],
                'userRole' => $user['role']
            ]);

            // Set flash message based on role
            $welcomeMessage = $user['role'] === 'admin' 
                ? 'Selamat datang Admin, ' . $user['name'] . '!' 
                : 'Selamat datang, ' . $user['name'] . '!';

            session()->setFlashdata('success', $welcomeMessage);
            
            // Redirect to appropriate page
            if ($user['role'] === 'admin') {
                return redirect()->to('/admin/dashboard')->with('success', 'Selamat datang di panel admin, ' . $user['name']);
            } else {
                return redirect()->to('/dashboard')->with('success', 'Selamat datang, ' . $user['name']);
            }
        } else {
            session()->setFlashdata('error', 'Email atau password salah. Silakan coba lagi.');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        // Get user name for farewell message
        $userName = session()->get('userName');
        
        // Destroy session
        session()->destroy();
        
        $farewellMessage = $userName ? "Sampai jumpa, {$userName}!" : 'Anda telah berhasil logout.';
        session()->setFlashdata('info', $farewellMessage);
        
        return redirect()->to('/login');
    }
} 