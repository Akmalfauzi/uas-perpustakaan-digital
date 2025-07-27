<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'name', 'email', 'password', 'role', 'is_active', 'last_login'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|max_length[255]',
        'email' => 'required|valid_email|max_length[255]|is_unique[users.email,id,{id}]',
        'password' => 'required|min_length[6]',
        'role' => 'permit_empty|in_list[admin,user]'
    ];

    protected $validationMessages = [
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
            'min_length' => 'Password minimal 6 karakter'
        ],
        'role' => [
            'in_list' => 'Role harus admin atau user'
        ]
    ];

    protected $skipValidation = false;

    // Callbacks
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    /**
     * Hash password before saving
     */
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    /**
     * Authenticate user login
     */
    public function authenticate($email, $password)
    {
        $user = $this->where('email', $email)
                    ->where('is_active', true)
                    ->first();

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user['password'])) {
            // Update last login
            $this->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);
            
            // Remove password from return data
            unset($user['password']);
            return $user;
        }

        return false;
    }

    /**
     * Get user by email
     */
    public function getUserByEmail($email)
    {
        return $this->where('email', $email)
                    ->where('is_active', true)
                    ->first();
    }

    /**
     * Create new user
     */
    public function createUser($data)
    {
        // Set default role if not provided
        if (!isset($data['role'])) {
            $data['role'] = 'user';
        }

        if ($this->insert($data)) {
            $userId = $this->getInsertID();
            return $this->find($userId);
        }

        return false;
    }

    /**
     * Get all users with pagination
     */
    public function getUsers($search = null, $role = null, $perPage = 10)
    {
        if ($search) {
            $this->groupStart()
                 ->like('name', $search)
                 ->orLike('email', $search)
                 ->groupEnd();
        }

        if ($role && $role !== 'all') {
            $this->where('role', $role);
        }

        return $this->orderBy('created_at', 'DESC')
                    ->paginate($perPage);
    }

    /**
     * Get user statistics
     */
    public function getUserStatistics()
    {
        $total = $this->countAll();
        $active = $this->where('is_active', true)->countAllResults(false);
        $admins = $this->where('role', 'admin')->countAllResults(false);
        $users = $this->where('role', 'user')->countAllResults(false);

        return [
            'total_users' => $total,
            'active_users' => $active,
            'total_admins' => $admins,
            'total_regular_users' => $users
        ];
    }

    /**
     * Update user profile
     */
    public function updateProfile($id, $data)
    {
        // Remove password from data if empty
        if (isset($data['password']) && empty($data['password'])) {
            unset($data['password']);
        }

        return $this->update($id, $data);
    }

    /**
     * Change user password
     */
    public function changePassword($id, $currentPassword, $newPassword)
    {
        $user = $this->find($id);
        
        if (!$user) {
            return ['success' => false, 'message' => 'User tidak ditemukan'];
        }

        if (!password_verify($currentPassword, $user['password'])) {
            return ['success' => false, 'message' => 'Password lama tidak benar'];
        }

        $result = $this->update($id, ['password' => $newPassword]);
        
        if ($result) {
            return ['success' => true, 'message' => 'Password berhasil diubah'];
        } else {
            return ['success' => false, 'message' => 'Gagal mengubah password'];
        }
    }

    /**
     * Toggle user active status
     */
    public function toggleActiveStatus($id)
    {
        $user = $this->find($id);
        if ($user) {
            return $this->update($id, ['is_active' => !$user['is_active']]);
        }
        return false;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin($userId)
    {
        $user = $this->find($userId);
        return $user && $user['role'] === 'admin';
    }

    /**
     * Get recent users
     */
    public function getRecentUsers($limit = 10)
    {
        return $this->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->find();
    }
} 