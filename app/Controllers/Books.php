<?php

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\LoanModel;
use App\Models\SettingsModel;

class Books extends BaseController
{
    protected $bookModel;
    protected $loanModel;
    protected $settingsModel;
    protected $session;

    public function __construct()
    {
        $this->bookModel = new BookModel();
        $this->loanModel = new LoanModel();
        $this->settingsModel = new SettingsModel();
        $this->session = \Config\Services::session();
    }

    /**
     * Display books list with search and pagination
     */
    public function index()
    {
        $pager = \Config\Services::pager();
        
        // Get search parameters
        $search = $this->request->getGet('search');
        $category = $this->request->getGet('category');
        $perPage = $this->settingsModel->getSetting('books_per_page', 12);

        // Get books with pagination
        $books = $this->bookModel->getBooks($search, $category, $perPage);
        $categories = $this->bookModel->getCategories();

        // Get settings
        $siteName = $this->settingsModel->getSetting('site_name', 'Perpustakaan Digital');
        $siteDescription = $this->settingsModel->getSetting('site_description', 'Sistem Perpustakaan Digital');

        $data = [
            'title' => 'Koleksi Buku',
            'siteName' => $siteName,
            'siteDescription' => $siteDescription,
            'books' => $books,
            'categories' => $categories,
            'pager' => $this->bookModel->pager,
            'search' => $search,
            'category' => $category
        ];

        return view('books/index', $data);
    }

    /**
     * Display single book detail
     */
    public function show($id = null)
    {
        $book = $this->bookModel->find($id);
        
        if (!$book) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Buku tidak ditemukan');
        }

        // Check user's loan status for this book if logged in
        $userLoanStatus = null;
        if (session()->get('userId')) {
            $userId = session()->get('userId');
            
            // Check if user has pending loan
            if ($this->loanModel->hasPendingLoan($userId, $id)) {
                $userLoanStatus = 'pending';
            }
            // Check if user has active loan
            elseif ($this->loanModel->hasActiveLoan($userId, $id)) {
                $userLoanStatus = 'active';
            }
        }

        // Get settings
        $siteName = $this->settingsModel->getSetting('site_name', 'Perpustakaan Digital');
        $siteDescription = $this->settingsModel->getSetting('site_description', 'Sistem Perpustakaan Digital');

        $data = [
            'title' => $book['title'],
            'siteName' => $siteName,
            'siteDescription' => $siteDescription,
            'book' => $book,
            'userLoanStatus' => $userLoanStatus
        ];

        return view('books/show', $data);
    }

    /**
     * Display form to create new book
     */
    public function new()
    {
        // Check if user is logged in and is admin
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        if ($this->session->get('userRole') !== 'admin') {
            return redirect()->to('/books')->with('error', 'Anda tidak memiliki akses untuk menambah buku');
        }

        $data = [
            'title' => 'Tambah Buku Baru',
            'validation' => null
        ];

        return view('books/create', $data);
    }

    /**
     * Create new book
     */
    public function create()
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        if ($this->session->get('userRole') !== 'admin') {
            return redirect()->to('/books')->with('error', 'Anda tidak memiliki akses untuk menambah buku');
        }

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
            return redirect()->to('/books')->with('success', 'Buku berhasil ditambahkan');
        } else {
            return view('books/create', [
                'title' => 'Tambah Buku Baru',
                'validation' => $this->bookModel->errors()
            ]);
        }
    }

    /**
     * Display form to edit book
     */
    public function edit($id = null)
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        if ($this->session->get('userRole') !== 'admin') {
            return redirect()->to('/books')->with('error', 'Anda tidak memiliki akses untuk mengedit buku');
        }

        $book = $this->bookModel->find($id);
        
        if (!$book) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Buku tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Buku: ' . $book['title'],
            'book' => $book,
            'validation' => null
        ];

        return view('books/edit', $data);
    }

    /**
     * Update book
     */
    public function update($id = null)
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        if ($this->session->get('userRole') !== 'admin') {
            return redirect()->to('/books')->with('error', 'Anda tidak memiliki akses untuk mengupdate buku');
        }

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
            return redirect()->to('/books')->with('success', 'Buku berhasil diperbarui');
        } else {
            return view('books/edit', [
                'title' => 'Edit Buku: ' . $book['title'],
                'book' => $book,
                'validation' => $this->bookModel->errors()
            ]);
        }
    }

    /**
     * Delete book
     */
    public function delete($id = null)
    {
        if (!$this->session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        if ($this->session->get('userRole') !== 'admin') {
            return redirect()->to('/books')->with('error', 'Anda tidak memiliki akses untuk menghapus buku');
        }

        $book = $this->bookModel->find($id);
        if (!$book) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Buku tidak ditemukan');
        }

        // Delete associated files
        if ($book['cover_image'] && file_exists(ROOTPATH . 'public/' . $book['cover_image'])) {
            unlink(ROOTPATH . 'public/' . $book['cover_image']);
        }
        
        if ($book['file_path'] && file_exists(ROOTPATH . 'public/' . $book['file_path'])) {
            unlink(ROOTPATH . 'public/' . $book['file_path']);
        }

        if ($this->bookModel->delete($id)) {
            return redirect()->to('/books')->with('success', 'Buku berhasil dihapus');
        } else {
            return redirect()->to('/books')->with('error', 'Gagal menghapus buku');
        }
    }

    /**
     * Download book file
     */
    public function download($id = null)
    {
        // Check if user is logged in
        if (!session()->get('userId')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu untuk mendownload buku.');
        }

        $book = $this->bookModel->find($id);
        
        if (!$book) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Buku tidak ditemukan');
        }

        // Check if book has file
        if (!$book['file_path']) {
            return redirect()->back()->with('error', 'File buku tidak tersedia untuk didownload.');
        }

        $filePath = ROOTPATH . 'public/' . $book['file_path'];
        
        // Check if file exists
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File buku tidak ditemukan di server.');
        }

        // Increment download count
        $this->bookModel->incrementDownload($id);

        // Get file info
        $fileInfo = pathinfo($filePath);
        $fileName = $book['title'] . '.' . $fileInfo['extension'];
        
        // Set headers for download
        $this->response->setHeader('Content-Type', 'application/octet-stream');
        $this->response->setHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"');
        $this->response->setHeader('Content-Length', filesize($filePath));
        $this->response->setHeader('Cache-Control', 'private, max-age=0, must-revalidate');
        $this->response->setHeader('Pragma', 'public');

        // Send file
        readfile($filePath);
        exit;
    }

    /**
     * Request book loan
     */
    public function requestLoan($id = null)
    {
        // Check if user is logged in
        if (!session()->get('userId')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Silakan login terlebih dahulu.']);
        }

        $userId = session()->get('userId');
        $notes = $this->request->getPost('notes');
        $requestedStartDate = $this->request->getPost('requested_start_date');
        $requestedEndDate = $this->request->getPost('requested_end_date');

        // Validate requested dates
        if (!$requestedStartDate) {
            return $this->response->setJSON(['success' => false, 'message' => 'Tanggal mulai peminjaman harus diisi.']);
        }

        if (!$requestedEndDate) {
            return $this->response->setJSON(['success' => false, 'message' => 'Tanggal akhir peminjaman harus diisi.']);
        }

        $startDate = new \DateTime($requestedStartDate);
        $endDate = new \DateTime($requestedEndDate);
        $today = new \DateTime('today', new \DateTimeZone('Asia/Jakarta')); // Today at 00:00:00 WIB

        // Reset time to 00:00:00 for comparison
        $startDate->setTime(0, 0, 0);
        $endDate->setTime(0, 0, 0);

        if ($startDate < $today) {
            return $this->response->setJSON(['success' => false, 'message' => 'Tanggal mulai peminjaman tidak boleh di masa lalu.']);
        }

        if ($endDate < $startDate) {
            return $this->response->setJSON(['success' => false, 'message' => 'Tanggal akhir peminjaman tidak boleh sebelum tanggal mulai.']);
        }

        // Check maximum loan duration (30 days)
        $daysDiff = $endDate->diff($startDate)->days;
        if ($daysDiff > 30) {
            return $this->response->setJSON(['success' => false, 'message' => 'Maksimal masa peminjaman adalah 30 hari.']);
        }
        
        // Allow same day loans (minimum 0 days)
        if ($daysDiff < 0) {
            return $this->response->setJSON(['success' => false, 'message' => 'Durasi peminjaman tidak valid.']);
        }

        // Check if book exists and available
        $book = $this->bookModel->find($id);
        if (!$book) {
            return $this->response->setJSON(['success' => false, 'message' => 'Buku tidak ditemukan.']);
        }

        if ($book['status'] !== 'available') {
            return $this->response->setJSON(['success' => false, 'message' => 'Buku sedang tidak tersedia.']);
        }

        // Check if user already has pending or active loan for this book
        if ($this->loanModel->hasPendingLoan($userId, $id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Anda sudah memiliki permintaan peminjaman yang pending untuk buku ini.']);
        }

        if ($this->loanModel->hasActiveLoan($userId, $id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Anda sedang meminjam buku ini.']);
        }

        // Create loan request
        $loanData = [
            'user_id' => $userId,
            'book_id' => $id,
            'status' => 'pending',
            'notes' => $notes,
            'requested_start_date' => $requestedStartDate,
            'requested_end_date' => $requestedEndDate
        ];

        if ($this->loanModel->insert($loanData)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Permintaan peminjaman berhasil dikirim. Menunggu persetujuan admin.']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengirim permintaan peminjaman.']);
        }
    }

    /**
     * Search books (AJAX endpoint)
     */
    public function search()
    {
        $search = $this->request->getPost('search');
        $category = $this->request->getPost('category');
        
        $books = $this->bookModel->getBooks($search, $category, 20);
        
        return $this->response->setJSON([
            'success' => true,
            'books' => $books,
            'count' => count($books)
        ]);
    }

    /**
     * Get book categories (AJAX endpoint)
     */
    public function categories()
    {
        $categories = $this->bookModel->getCategories();
        
        return $this->response->setJSON([
            'success' => true,
            'categories' => $categories
        ]);
    }
} 