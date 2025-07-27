<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\SettingsModel;

class Register extends BaseController
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

        // Check if registration is allowed
        $allowRegistration = $this->settingsModel->getSetting('allow_registration', true);
        if (!$allowRegistration) {
            return redirect()->to('/login')->with('error', 'Registrasi pengguna baru sedang ditutup.');
        }

        $data = [
            'minPasswordLength' => $this->settingsModel->getSetting('min_password_length', 6)
        ];

        return view('auth/register', $data);
    }

    public function create()
    {
        // Check if registration is allowed
        $allowRegistration = $this->settingsModel->getSetting('allow_registration', true);
        if (!$allowRegistration) {
            return redirect()->to('/login')->with('error', 'Registrasi pengguna baru sedang ditutup.');
        }

        // Get minimum password length from settings
        $minPasswordLength = $this->settingsModel->getSetting('min_password_length', 6);

        $rules = [
            'name' => 'required|max_length[255]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => "required|min_length[{$minPasswordLength}]",
            'password_confirm' => 'required|matches[password]'
        ];

        $messages = [
            'name' => [
                'required' => 'Nama lengkap harus diisi',
                'max_length' => 'Nama maksimal 255 karakter'
            ],
            'email' => [
                'required' => 'Email harus diisi',
                'valid_email' => 'Format email tidak valid',
                'is_unique' => 'Email sudah terdaftar'
            ],
            'password' => [
                'required' => 'Password harus diisi',
                'min_length' => "Password minimal {$minPasswordLength} karakter"
            ],
            'password_confirm' => [
                'required' => 'Konfirmasi password harus diisi',
                'matches' => 'Konfirmasi password tidak sama'
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return view('auth/register', ['validation' => $this->validator]);
        }

        // Get form data
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'role' => 'user' // Default role for new registrations
        ];

        // Create user
        if ($this->userModel->insert($data)) {
            session()->setFlashdata('success', 
                'Registrasi berhasil! Silakan login dengan akun Anda.');
            return redirect()->to('/login');
        } else {
            session()->setFlashdata('error', 
                'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
            return view('auth/register', [
                'validation' => $this->userModel->errors()
            ]);
        }
    }
} 