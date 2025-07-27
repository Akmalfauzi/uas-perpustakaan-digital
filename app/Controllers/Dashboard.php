<?php

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\LoanModel;
use App\Models\SettingsModel;

class Dashboard extends BaseController
{
    protected $loanModel;
    protected $bookModel;
    protected $settingsModel;

    public function __construct()
    {
        $this->loanModel = new LoanModel();
        $this->bookModel = new BookModel();
        $this->settingsModel = new SettingsModel();
    }

    /**
     * User Dashboard
     */
    public function index()
    {
        // Check if user is logged in
        if (!session()->get('userId')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Get user data
        $userId = session()->get('userId');
        
        // Get user's loan statistics
        $userLoans = $this->loanModel->getUserLoans($userId);
        
        // Get overdue loans
        $overdueLoans = array_filter($userLoans, function($loan) {
            return $loan['status'] === 'approved' && 
                   $loan['due_date'] && 
                   strtotime($loan['due_date']) < time();
        });
        
        $loanStats = [
            'total' => count($userLoans),
            'pending' => count(array_filter($userLoans, fn($loan) => $loan['status'] === 'pending')),
            'approved' => count(array_filter($userLoans, fn($loan) => $loan['status'] === 'approved')),
            'returned' => count(array_filter($userLoans, fn($loan) => $loan['status'] === 'returned')),
            'overdue' => count($overdueLoans),
        ];

        // Get recent loans (last 5)
        $recentLoans = array_slice($userLoans, 0, 5);

        // Get settings
        $siteName = $this->settingsModel->getSetting('site_name', 'Perpustakaan Digital');
        $siteDescription = $this->settingsModel->getSetting('site_description', 'Sistem Perpustakaan Digital');

        $data = [
            'pageTitle' => 'Dashboard Saya',
            'title' => 'Dashboard Saya',
            'siteName' => $siteName,
            'siteDescription' => $siteDescription,
            'loanStats' => $loanStats,
            'recentLoans' => $recentLoans,
            'overdueLoans' => $overdueLoans,
            'userName' => session()->get('userName')
        ];

        return view('dashboard/index', $data);
    }

    /**
     * My Loans page
     */
    public function loans()
    {
        // Check if user is logged in
        if (!session()->get('userId')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userId = session()->get('userId');
        $status = $this->request->getGet('status');
        
        // Get user's loans
        $loans = $this->loanModel->getUserLoans($userId, $status);

        // Get settings
        $siteName = $this->settingsModel->getSetting('site_name', 'Perpustakaan Digital');
        $siteDescription = $this->settingsModel->getSetting('site_description', 'Sistem Perpustakaan Digital');

        $data = [
            'pageTitle' => 'Riwayat Peminjaman',
            'title' => 'Riwayat Peminjaman',
            'siteName' => $siteName,
            'siteDescription' => $siteDescription,
            'loans' => $loans,
            'currentStatus' => $status
        ];

        return view('dashboard/loans', $data);
    }

    /**
     * Request book loan
     */
    public function requestLoan()
    {
        // Check if user is logged in
        if (!session()->get('userId')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Silakan login terlebih dahulu.']);
        }

        $userId = session()->get('userId');
        $bookId = $this->request->getPost('book_id');
        $notes = $this->request->getPost('notes');
        $requestedStartDate = $this->request->getPost('requested_start_date');
        $requestedEndDate = $this->request->getPost('requested_end_date');

        if (!$bookId) {
            return $this->response->setJSON(['success' => false, 'message' => 'Book ID tidak valid.']);
        }

        // Validate requested dates if provided
        if ($requestedStartDate && $requestedEndDate) {
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
        }

        // Check if book exists and available
        $book = $this->bookModel->find($bookId);
        if (!$book) {
            return $this->response->setJSON(['success' => false, 'message' => 'Buku tidak ditemukan.']);
        }

        if ($book['status'] !== 'available') {
            return $this->response->setJSON(['success' => false, 'message' => 'Buku sedang tidak tersedia.']);
        }

        // Check if user already has pending or active loan for this book
        if ($this->loanModel->hasPendingLoan($userId, $bookId)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Anda sudah memiliki permintaan peminjaman yang pending untuk buku ini.']);
        }

        if ($this->loanModel->hasActiveLoan($userId, $bookId)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Anda sedang meminjam buku ini.']);
        }

        // Create loan request
        $loanData = [
            'user_id' => $userId,
            'book_id' => $bookId,
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
     * Cancel loan request (only for pending status)
     */
    public function cancelLoan($loanId)
    {
        // Check if user is logged in
        if (!session()->get('userId')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userId = session()->get('userId');
        
        // Find loan and verify ownership
        $loan = $this->loanModel->find($loanId);
        if (!$loan || $loan['user_id'] != $userId) {
            return redirect()->to('/dashboard/loans')->with('error', 'Peminjaman tidak ditemukan.');
        }

        // Can only cancel pending loans
        if ($loan['status'] !== 'pending') {
            return redirect()->to('/dashboard/loans')->with('error', 'Hanya dapat membatalkan peminjaman yang masih pending.');
        }

        // Delete the loan request
        if ($this->loanModel->delete($loanId)) {
            return redirect()->to('/dashboard/loans')->with('success', 'Permintaan peminjaman berhasil dibatalkan.');
        } else {
            return redirect()->to('/dashboard/loans')->with('error', 'Gagal membatalkan permintaan peminjaman.');
        }
    }
} 