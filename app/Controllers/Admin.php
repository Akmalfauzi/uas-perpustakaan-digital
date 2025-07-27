<?php

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\UserModel;
use App\Models\LoanModel;
use App\Models\SettingsModel;

class Admin extends BaseController
{
    protected $bookModel;
    protected $userModel;
    protected $loanModel;
    protected $settingsModel;
    protected $session;

    public function __construct()
    {
        $this->bookModel = new BookModel();
        $this->userModel = new UserModel();
        $this->loanModel = new LoanModel();
        $this->settingsModel = new SettingsModel();
        $this->session = \Config\Services::session();
    }

    /**
     * Check if user is admin
     */
    private function checkAdminAccess()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        if ($this->session->get('userRole') !== 'admin') {
            return redirect()->to('/')->with('error', 'Anda tidak memiliki akses admin');
        }
        
        return null;
    }

    /**
     * Admin Dashboard
     */
    public function dashboard()
    {
        $check = $this->checkAdminAccess();
        if ($check) return $check;

        // Get statistics
        $bookStats = $this->bookModel->getStatistics();
        $userStats = $this->userModel->getUserStatistics();
        $loanStats = $this->loanModel->getStatistics();
        
        // Get recent activities
        $recentBooks = $this->bookModel->getRecentBooks(5);
        $recentUsers = $this->userModel->getRecentUsers(5);
        $recentLoans = $this->loanModel->getLoansWithDetails(5);
        
        // Get popular books
        $popularBooks = $this->bookModel->getPopularBooks(10);

        $data = [
            'title' => 'Admin Dashboard',
            'bookStats' => $bookStats,
            'userStats' => $userStats,
            'loanStats' => $loanStats,
            'recentBooks' => $recentBooks,
            'recentUsers' => $recentUsers,
            'recentLoans' => $recentLoans,
            'popularBooks' => $popularBooks,
            'currentUser' => $this->session->get()
        ];

        return view('admin/dashboard', $data);
    }

    /**
     * Admin Books Management
     */
    public function books()
    {
        $check = $this->checkAdminAccess();
        if ($check) return $check;

        $pager = \Config\Services::pager();
        
        // Get search parameters
        $search = $this->request->getGet('search');
        $category = $this->request->getGet('category');
        $status = $this->request->getGet('status');
        $perPage = 20;

        // Get books with pagination
        $books = $this->bookModel->getBooks($search, $category, $perPage, $status);
        $categories = $this->bookModel->getCategories();

        $data = [
            'title' => 'Kelola Buku',
            'books' => $books,
            'categories' => $categories,
            'pager' => $this->bookModel->pager,
            'search' => $search,
            'category' => $category,
            'status' => $status
        ];

        return view('admin/books', $data);
    }

    /**
     * Display form to create new book
     */
    public function newBook()
    {
        $check = $this->checkAdminAccess();
        if ($check) return $check;

        $data = [
            'title' => 'Tambah Buku Baru',
            'validation' => null
        ];

        return view('admin/books/create', $data);
    }

    /**
     * Create new book
     */
    public function createBook()
    {
        $check = $this->checkAdminAccess();
        if ($check) return $check;

        $data = $this->request->getPost();
        
        // Handle file upload for cover image
        $coverImage = $this->request->getFile('cover_image');
        if ($coverImage && $coverImage->isValid() && !$coverImage->hasMoved()) {
            $newName = $coverImage->getRandomName();
            $coverImage->move(ROOTPATH . 'public/uploads/covers', $newName);
            $data['cover_image'] = 'uploads/covers/' . $newName;
        }

        // Handle file upload for book file
        $bookFile = $this->request->getFile('file_path');
        if ($bookFile && $bookFile->isValid() && !$bookFile->hasMoved()) {
            $newName = $bookFile->getRandomName();
            $bookFile->move(ROOTPATH . 'public/uploads/books', $newName);
            $data['file_path'] = 'uploads/books/' . $newName;
        }

        if ($this->bookModel->insert($data)) {
            return redirect()->to('/admin/books')->with('success', 'Buku berhasil ditambahkan');
        } else {
            return view('admin/books/create', [
                'title' => 'Tambah Buku Baru',
                'validation' => $this->bookModel->errors()
            ]);
        }
    }

    /**
     * Display form to edit book
     */
    public function editBook($id = null)
    {
        $check = $this->checkAdminAccess();
        if ($check) return $check;

        $book = $this->bookModel->find($id);
        
        if (!$book) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Buku tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Buku: ' . $book['title'],
            'book' => $book,
            'validation' => null
        ];

        return view('admin/books/edit', $data);
    }

    /**
     * Update book
     */
    public function updateBook($id = null)
    {
        $check = $this->checkAdminAccess();
        if ($check) return $check;

        $book = $this->bookModel->find($id);
        if (!$book) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Buku tidak ditemukan');
        }

        $data = $this->request->getPost();

        // Handle file upload for cover image
        $coverImage = $this->request->getFile('cover_image');
        if ($coverImage && $coverImage->isValid() && !$coverImage->hasMoved()) {
            // Delete old cover if exists
            if ($book['cover_image'] && file_exists(ROOTPATH . 'public/' . $book['cover_image'])) {
                unlink(ROOTPATH . 'public/' . $book['cover_image']);
            }
            
            $newName = $coverImage->getRandomName();
            $coverImage->move(ROOTPATH . 'public/uploads/covers', $newName);
            $data['cover_image'] = 'uploads/covers/' . $newName;
        }

        // Handle file upload for book file
        $bookFile = $this->request->getFile('file_path');
        if ($bookFile && $bookFile->isValid() && !$bookFile->hasMoved()) {
            // Delete old file if exists
            if ($book['file_path'] && file_exists(ROOTPATH . 'public/' . $book['file_path'])) {
                unlink(ROOTPATH . 'public/' . $book['file_path']);
            }
            
            $newName = $bookFile->getRandomName();
            $bookFile->move(ROOTPATH . 'public/uploads/books', $newName);
            $data['file_path'] = 'uploads/books/' . $newName;
        }

        if ($this->bookModel->update($id, $data)) {
            return redirect()->to('/admin/books')->with('success', 'Buku berhasil diperbarui');
        } else {
            return view('admin/books/edit', [
                'title' => 'Edit Buku: ' . $book['title'],
                'book' => $book,
                'validation' => $this->bookModel->errors()
            ]);
        }
    }

    /**
     * Delete book
     */
    public function deleteBook($id = null)
    {
        $check = $this->checkAdminAccess();
        if ($check) return $check;

        $book = $this->bookModel->find($id);
        if (!$book) {
            return redirect()->to('/admin/books')->with('error', 'Buku tidak ditemukan');
        }

        // Start database transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Check if book has active loans
            $activeLoanCount = $this->loanModel->where('book_id', $id)
                                               ->where('status', 'approved')
                                               ->countAllResults();
            
            if ($activeLoanCount > 0) {
                return redirect()->to('/admin/books')->with('error', 'Tidak dapat menghapus buku yang sedang dipinjam');
            }

            // Delete related records first (if not using CASCADE)
            // The foreign keys are set to CASCADE, so this should happen automatically
            // But we'll do it explicitly for safety
            $this->loanModel->where('book_id', $id)->delete();
            
            // Delete download logs
            $db->table('download_logs')->where('book_id', $id)->delete();

            // Delete the book record from database
            if (!$this->bookModel->delete($id)) {
                throw new \Exception('Gagal menghapus data buku dari database');
            }

            // If database deletion successful, then delete associated files
            $fileErrors = [];
            
            // Delete cover image
            if ($book['cover_image']) {
                $coverPath = ROOTPATH . 'public/' . $book['cover_image'];
                if (file_exists($coverPath)) {
                    if (!unlink($coverPath)) {
                        $fileErrors[] = 'cover image';
                    }
                }
            }
            
            // Delete book file
            if ($book['file_path']) {
                $filePath = ROOTPATH . 'public/' . $book['file_path'];
                if (file_exists($filePath)) {
                    if (!unlink($filePath)) {
                        $fileErrors[] = 'book file';
                    }
                }
            }

            // Complete the transaction
            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Gagal menghapus buku karena error database');
            }

            // Success message with file deletion warnings if any
            $message = 'Buku berhasil dihapus';
            if (!empty($fileErrors)) {
                $message .= ', namun gagal menghapus beberapa file: ' . implode(', ', $fileErrors);
            }

            return redirect()->to('/admin/books')->with('success', $message);

        } catch (\Exception $e) {
            // Rollback transaction on error
            $db->transRollback();
            
            log_message('error', 'Error deleting book ID ' . $id . ': ' . $e->getMessage());
            return redirect()->to('/admin/books')->with('error', 'Gagal menghapus buku: ' . $e->getMessage());
        }
    }

    /**
     * Admin Users Management
     */
    public function users()
    {
        $check = $this->checkAdminAccess();
        if ($check) return $check;

        $pager = \Config\Services::pager();
        
        // Get search parameters
        $search = $this->request->getGet('search');
        $role = $this->request->getGet('role');
        $status = $this->request->getGet('status');
        $perPage = 20;

        // Get users with pagination
        $users = $this->userModel->getUsers($search, $role, $perPage);

        $data = [
            'title' => 'Kelola Pengguna',
            'users' => $users,
            'pager' => $this->userModel->pager,
            'search' => $search,
            'role' => $role,
            'status' => $status
        ];

        return view('admin/users', $data);
    }

    /**
     * Display form to create new user
     */
    public function newUser()
    {
        $check = $this->checkAdminAccess();
        if ($check) return $check;

        $data = [
            'title' => 'Tambah Pengguna Baru',
            'validation' => null
        ];

        return view('admin/users/create', $data);
    }

    /**
     * Create new user
     */
    public function createUser()
    {
        $check = $this->checkAdminAccess();
        if ($check) return $check;

        $data = $this->request->getPost();

        if ($this->userModel->createUser($data)) {
            return redirect()->to('/admin/users')->with('success', 'Pengguna berhasil ditambahkan');
        } else {
            return view('admin/users/create', [
                'title' => 'Tambah Pengguna Baru',
                'validation' => $this->userModel->errors()
            ]);
        }
    }

    /**
     * Display form to edit user
     */
    public function editUser($id = null)
    {
        $check = $this->checkAdminAccess();
        if ($check) return $check;

        $user = $this->userModel->find($id);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengguna tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Pengguna: ' . $user['name'],
            'user' => $user,
            'validation' => null
        ];

        return view('admin/users/edit', $data);
    }

    /**
     * Update user
     */
    public function updateUser($id = null)
    {
        $check = $this->checkAdminAccess();
        if ($check) return $check;

        $user = $this->userModel->find($id);
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pengguna tidak ditemukan');
        }

        $data = $this->request->getPost();

        if ($this->userModel->updateProfile($id, $data)) {
            return redirect()->to('/admin/users')->with('success', 'Pengguna berhasil diperbarui');
        } else {
            return view('admin/users/edit', [
                'title' => 'Edit Pengguna: ' . $user['name'],
                'user' => $user,
                'validation' => $this->userModel->errors()
            ]);
        }
    }

    /**
     * Toggle user active status
     */
    public function toggleUserStatus($id = null)
    {
        $check = $this->checkAdminAccess();
        if ($check) return $check;

        if ($this->userModel->toggleActiveStatus($id)) {
            return redirect()->to('/admin/users')->with('success', 'Status pengguna berhasil diubah');
        } else {
            return redirect()->to('/admin/users')->with('error', 'Gagal mengubah status pengguna');
        }
    }

    /**
     * Admin Settings
     */
    public function settings()
    {
        $check = $this->checkAdminAccess();
        if ($check) return $check;

        // Get all settings
        $settings = $this->settingsModel->getAllSettings();
        
        // Get statistics for display
        $bookStats = $this->bookModel->getStatistics();
        $userStats = $this->userModel->getUserStatistics();
        $loanStats = $this->loanModel->getStatistics();

        $data = [
            'title' => 'Pengaturan System',
            'settings' => $settings,
            'bookStats' => $bookStats,
            'userStats' => $userStats,
            'loanStats' => $loanStats
        ];

        return view('admin/settings', $data);
    }

    /**
     * Update system settings
     */
    public function updateSettings()
    {
        $check = $this->checkAdminAccess();
        if ($check) return $check;

        // Get POST data
        $postData = $this->request->getPost();
        
        // Remove CSRF token from settings data
        unset($postData['csrf_token_name']);
        unset($postData['csrf_hash_name']);

        // Validate and prepare settings
        $settingsToUpdate = [];
        
        // Handle checkboxes first (they won't be in POST if unchecked)
        $checkboxFields = ['allow_registration', 'email_verification'];
        foreach ($checkboxFields as $field) {
            $settingsToUpdate[$field] = isset($postData[$field]) ? 1 : 0;
        }
        
        // Handle other fields
        foreach ($postData as $key => $value) {
            if (!in_array($key, $checkboxFields)) {
                $settingsToUpdate[$key] = $value;
            }
        }

        // Update settings
        if ($this->settingsModel->updateSettings($settingsToUpdate)) {
            return redirect()->to('/admin/settings')->with('success', 'Pengaturan berhasil diperbarui');
        } else {
            return redirect()->to('/admin/settings')->with('error', 'Gagal memperbarui pengaturan');
        }
    }

    /**
     * Loans Management
     */
    public function loans()
    {
        $check = $this->checkAdminAccess();
        if ($check) return $check;

        $status = $this->request->getGet('status');
        $loans = $this->loanModel->getLoansWithDetails(null, null, $status);
        $loanStats = $this->loanModel->getStatistics();

        $data = [
            'pageTitle' => 'Manajemen Peminjaman',
            'loans' => $loans,
            'loanStats' => $loanStats,
            'currentStatus' => $status
        ];

        return view('admin/loans', $data);
    }

    /**
     * Approve Loan
     */
    public function approveLoan($loanId)
    {
        $check = $this->checkAdminAccess();
        if ($check) return $check;

        $adminId = $this->session->get('userId');
        $adminNotes = $this->request->getPost('admin_notes');

        if ($this->loanModel->approveLoan($loanId, $adminId, $adminNotes)) {
            return redirect()->to('/admin/loans')->with('success', 'Peminjaman berhasil disetujui.');
        } else {
            return redirect()->to('/admin/loans')->with('error', 'Gagal menyetujui peminjaman.');
        }
    }

    /**
     * Reject Loan
     */
    public function rejectLoan($loanId)
    {
        $check = $this->checkAdminAccess();
        if ($check) return $check;

        $adminId = $this->session->get('userId');
        $adminNotes = $this->request->getPost('admin_notes');

        if ($this->loanModel->rejectLoan($loanId, $adminId, $adminNotes)) {
            return redirect()->to('/admin/loans')->with('success', 'Peminjaman berhasil ditolak.');
        } else {
            return redirect()->to('/admin/loans')->with('error', 'Gagal menolak peminjaman.');
        }
    }

    /**
     * Return Book
     */
    public function returnBook($loanId)
    {
        $check = $this->checkAdminAccess();
        if ($check) return $check;

        $adminNotes = $this->request->getPost('admin_notes');

        if ($this->loanModel->returnBook($loanId, $adminNotes)) {
            return redirect()->to('/admin/loans')->with('success', 'Buku berhasil dikembalikan.');
        } else {
            return redirect()->to('/admin/loans')->with('error', 'Gagal memproses pengembalian buku.');
        }
    }
} 