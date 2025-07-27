<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanModel extends Model
{
    protected $table = 'loans';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'user_id', 'book_id', 'status', 'loan_date', 'due_date', 
        'return_date', 'notes', 'admin_notes', 'approved_by', 'requested_start_date', 'requested_end_date'
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'user_id' => 'required|integer',
        'book_id' => 'required|integer',
        'status' => 'required|in_list[pending,approved,rejected,returned]',
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'User ID harus diisi.',
            'integer' => 'User ID harus berupa angka.'
        ],
        'book_id' => [
            'required' => 'Book ID harus diisi.',
            'integer' => 'Book ID harus berupa angka.'
        ],
        'status' => [
            'required' => 'Status harus diisi.',
            'in_list' => 'Status tidak valid.'
        ]
    ];

    // Skip validation
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get loans with user and book information
     */
    public function getLoansWithDetails($limit = null, $offset = null, $status = null)
    {
        $builder = $this->select('
            loans.*,
            users.name as user_name,
            users.email as user_email,
            books.title as book_title,
            books.author as book_author,
            books.cover_image as book_cover,
            approver.name as approved_by_name
        ')
        ->join('users', 'users.id = loans.user_id')
        ->join('books', 'books.id = loans.book_id')
        ->join('users as approver', 'approver.id = loans.approved_by', 'left')
        ->orderBy('loans.created_at', 'DESC');

        if ($status) {
            $builder->where('loans.status', $status);
        }

        if ($limit !== null) {
            $builder->limit($limit, $offset);
        }

        return $builder->findAll();
    }

    /**
     * Get user's loans
     */
    public function getUserLoans($userId, $status = null)
    {
        $builder = $this->select('
            loans.*,
            books.title as book_title,
            books.author as book_author,
            books.cover_image as book_cover,
            books.category as book_category
        ')
        ->join('books', 'books.id = loans.book_id')
        ->where('loans.user_id', $userId)
        ->orderBy('loans.created_at', 'DESC');

        if ($status) {
            $builder->where('loans.status', $status);
        }

        return $builder->findAll();
    }

    /**
     * Check if user has pending loan for this book
     */
    public function hasPendingLoan($userId, $bookId)
    {
        return $this->where([
            'user_id' => $userId,
            'book_id' => $bookId,
            'status' => 'pending'
        ])->first() !== null;
    }

    /**
     * Check if user has active loan for this book
     */
    public function hasActiveLoan($userId, $bookId)
    {
        return $this->where([
            'user_id' => $userId,
            'book_id' => $bookId,
            'status' => 'approved'
        ])->first() !== null;
    }

    /**
     * Get loan statistics
     */
    public function getStatistics()
    {
        $stats = [];
        
        $stats['total_loans'] = $this->countAll();
        $stats['pending_loans'] = $this->where('status', 'pending')->countAllResults();
        $stats['approved_loans'] = $this->where('status', 'approved')->countAllResults();
        $stats['returned_loans'] = $this->where('status', 'returned')->countAllResults();
        $stats['overdue_loans'] = $this->where('status', 'approved')
            ->where('due_date <', date('Y-m-d H:i:s'))
            ->countAllResults();

        return $stats;
    }

    /**
     * Approve loan
     */
    public function approveLoan($loanId, $adminId, $adminNotes = null)
    {
        // Get loan to check requested dates
        $loan = $this->find($loanId);
        
        // Use requested dates if available, otherwise use default
        if ($loan && $loan['requested_start_date'] && $loan['requested_end_date']) {
            // If requested dates are just dates (without time), add default time
            $loanDate = strlen($loan['requested_start_date']) == 10 ? 
                        $loan['requested_start_date'] . ' 00:00:00' : 
                        $loan['requested_start_date'];
            $dueDate = strlen($loan['requested_end_date']) == 10 ? 
                       $loan['requested_end_date'] . ' 23:59:59' : 
                       $loan['requested_end_date'];
        } elseif ($loan && $loan['requested_start_date']) {
            // Fallback: use start date + 14 days if only start date available
            $loanDate = strlen($loan['requested_start_date']) == 10 ? 
                        $loan['requested_start_date'] . ' 00:00:00' : 
                        $loan['requested_start_date'];
            $dueDate = date('Y-m-d H:i:s', strtotime($loanDate . ' +14 days'));
        } else {
            // Default: current time + 14 days
            $loanDate = date('Y-m-d H:i:s');
            $dueDate = date('Y-m-d H:i:s', strtotime('+14 days'));
        }

        return $this->update($loanId, [
            'status' => 'approved',
            'loan_date' => $loanDate,
            'due_date' => $dueDate,
            'approved_by' => $adminId,
            'admin_notes' => $adminNotes
        ]);
    }

    /**
     * Reject loan
     */
    public function rejectLoan($loanId, $adminId, $adminNotes = null)
    {
        return $this->update($loanId, [
            'status' => 'rejected',
            'approved_by' => $adminId,
            'admin_notes' => $adminNotes
        ]);
    }

    /**
     * Return book
     */
    public function returnBook($loanId, $adminNotes = null)
    {
        return $this->update($loanId, [
            'status' => 'returned',
            'return_date' => date('Y-m-d H:i:s'),
            'admin_notes' => $adminNotes
        ]);
    }
} 