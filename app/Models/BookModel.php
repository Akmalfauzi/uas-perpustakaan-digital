<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'title', 'author', 'isbn', 'publisher', 'publication_year',
        'category', 'description', 'cover_image', 'file_path',
        'total_pages', 'language', 'status', 'download_count', 'rating'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'title' => 'required|max_length[255]',
        'author' => 'required|max_length[255]',
        'category' => 'required|max_length[100]',
        'isbn' => 'permit_empty|max_length[20]',
        'publisher' => 'permit_empty|max_length[255]',
        'publication_year' => 'permit_empty|integer|greater_than[1800]|less_than_equal_to[2030]',
        'total_pages' => 'permit_empty|integer|greater_than[0]',
        'language' => 'permit_empty|max_length[50]',
        'status' => 'permit_empty|in_list[available,borrowed,maintenance]',
        'rating' => 'permit_empty|decimal|greater_than_equal_to[0]|less_than_equal_to[5]'
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Judul buku harus diisi',
            'max_length' => 'Judul buku maksimal 255 karakter'
        ],
        'author' => [
            'required' => 'Penulis buku harus diisi',
            'max_length' => 'Nama penulis maksimal 255 karakter'
        ],
        'category' => [
            'required' => 'Kategori buku harus diisi',
            'max_length' => 'Kategori maksimal 100 karakter'
        ],
        'publication_year' => [
            'greater_than' => 'Tahun terbit tidak valid',
            'less_than_equal_to' => 'Tahun terbit tidak boleh melebihi tahun sekarang'
        ],
        'rating' => [
            'greater_than_equal_to' => 'Rating minimal 0',
            'less_than_equal_to' => 'Rating maksimal 5'
        ]
    ];

    protected $skipValidation = false;

    /**
     * Get recent books
     */
    public function getRecentBooks($limit = 10)
    {
        return $this->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->find();
    }

    /**
     * Get popular books
     */
    public function getPopularBooks($limit = 10)
    {
        return $this->orderBy('download_count', 'DESC')
                    ->limit($limit)
                    ->find();
    }

    /**
     * Get all categories
     */
    public function getCategories()
    {
        return $this->distinct()
                    ->select('category')
                    ->where('category !=', '')
                    ->orderBy('category', 'ASC')
                    ->findColumn('category');
    }

    /**
     * Get books with search and filters
     */
    public function getBooks($search = null, $category = null, $perPage = 10, $status = null)
    {
        if ($search) {
            $this->groupStart()
                 ->like('title', $search)
                 ->orLike('author', $search)
                 ->orLike('description', $search)
                 ->groupEnd();
        }

        if ($category) {
            $this->where('category', $category);
        }

        if ($status) {
            $this->where('status', $status);
        }

        return $this->orderBy('created_at', 'DESC')
                    ->paginate($perPage);
    }

    /**
     * Get book statistics
     */
    public function getStatistics()
    {
        $total = $this->countAll();
        $available = $this->where('status', 'available')->countAllResults(false);
        $borrowed = $this->where('status', 'borrowed')->countAllResults(false);
        $totalDownloads = $this->selectSum('download_count', 'total')->first()['total'] ?? 0;

        return [
            'total_books' => $total,
            'available_books' => $available,
            'borrowed_books' => $borrowed,
            'total_downloads' => $totalDownloads,
            'total_categories' => count($this->getCategories())
        ];
    }

    /**
     * Increment download count
     */
    public function incrementDownload($id)
    {
        $book = $this->find($id);
        if ($book) {
            return $this->update($id, ['download_count' => $book['download_count'] + 1]);
        }
        return false;
    }

    /**
     * Search books with advanced filters
     */
    public function searchBooks($filters = [])
    {
        $builder = $this->builder();

        if (!empty($filters['search'])) {
            $builder->groupStart()
                    ->like('title', $filters['search'])
                    ->orLike('author', $filters['search'])
                    ->orLike('description', $filters['search'])
                    ->groupEnd();
        }

        if (!empty($filters['category'])) {
            $builder->where('category', $filters['category']);
        }

        if (!empty($filters['year'])) {
            $builder->where('publication_year', $filters['year']);
        }

        if (!empty($filters['language'])) {
            $builder->where('language', $filters['language']);
        }

        if (!empty($filters['status'])) {
            $builder->where('status', $filters['status']);
        }

        return $builder->orderBy('created_at', 'DESC');
    }
} 