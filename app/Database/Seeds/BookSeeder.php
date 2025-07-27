<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run()
    {
        // Create sample book data
        $books = [
            [
                'title' => 'Pemrograman Web dengan PHP dan MySQL',
                'author' => 'Dr. Ahmad Setiono',
                'isbn' => '978-602-1234-56-7',
                'publisher' => 'Gramedia Pustaka Utama',
                'publication_year' => 2023,
                'category' => 'Teknologi',
                'description' => 'Buku komprehensif tentang pengembangan web menggunakan PHP dan MySQL. Cocok untuk pemula hingga intermediate.',
                'cover_image' => null,
                'file_path' => 'uploads/books/sample-programming-book.pdf',
                'total_pages' => 450,
                'language' => 'Indonesian',
                'status' => 'available',
                'download_count' => 125,
                'rating' => 4.5,
                'created_at' => date('Y-m-d H:i:s', strtotime('-30 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-30 days'))
            ],
            [
                'title' => 'Machine Learning untuk Pemula',
                'author' => 'Prof. Sari Wahyuni',
                'isbn' => '978-602-1234-78-9',
                'publisher' => 'Erlangga',
                'publication_year' => 2023,
                'category' => 'Teknologi',
                'description' => 'Pengantar machine learning yang mudah dipahami dengan contoh praktis menggunakan Python.',
                'cover_image' => null,
                'file_path' => 'uploads/books/sample-ml-book.pdf',
                'total_pages' => 320,
                'language' => 'Indonesian',
                'status' => 'available',
                'download_count' => 89,
                'rating' => 4.8,
                'created_at' => date('Y-m-d H:i:s', strtotime('-25 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-25 days'))
            ],
            [
                'title' => 'Sejarah Nusantara: Dari Majapahit hingga Kemerdekaan',
                'author' => 'Dr. Bambang Sutrisno',
                'isbn' => '978-602-1234-90-1',
                'publisher' => 'Mizan',
                'publication_year' => 2022,
                'category' => 'Sejarah',
                'description' => 'Buku sejarah lengkap tentang perjalanan bangsa Indonesia dari masa kerajaan hingga kemerdekaan.',
                'cover_image' => null,
                'file_path' => 'uploads/books/sample-history-book.pdf',
                'total_pages' => 580,
                'language' => 'Indonesian',
                'status' => 'available',
                'download_count' => 67,
                'rating' => 4.3,
                'created_at' => date('Y-m-d H:i:s', strtotime('-20 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-20 days'))
            ],
            [
                'title' => 'Matematika Diskrit dan Aplikasinya',
                'author' => 'Prof. Dr. Indira Sari',
                'isbn' => '978-602-1234-12-3',
                'publisher' => 'Andi Offset',
                'publication_year' => 2023,
                'category' => 'Matematika',
                'description' => 'Buku matematika diskrit dengan pendekatan praktis dan aplikasi dalam ilmu komputer.',
                'cover_image' => null,
                'file_path' => 'uploads/books/sample-math-book.pdf',
                'total_pages' => 400,
                'language' => 'Indonesian',
                'status' => 'available',
                'download_count' => 43,
                'rating' => 4.1,
                'created_at' => date('Y-m-d H:i:s', strtotime('-15 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-15 days'))
            ],
            [
                'title' => 'Psikologi Pendidikan Modern',
                'author' => 'Dr. Maya Kartika',
                'isbn' => '978-602-1234-34-5',
                'publisher' => 'Kencana',
                'publication_year' => 2023,
                'category' => 'Psikologi',
                'description' => 'Pendekatan modern dalam psikologi pendidikan untuk meningkatkan efektivitas pembelajaran.',
                'cover_image' => null,
                'file_path' => 'uploads/books/sample-psychology-book.pdf',
                'total_pages' => 350,
                'language' => 'Indonesian',
                'status' => 'available',
                'download_count' => 78,
                'rating' => 4.6,
                'created_at' => date('Y-m-d H:i:s', strtotime('-10 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-10 days'))
            ],
            [
                'title' => 'Ekonomi Digital dan Startup',
                'author' => 'Budi Santoso, M.B.A.',
                'isbn' => '978-602-1234-56-7',
                'publisher' => 'Grasindo',
                'publication_year' => 2023,
                'category' => 'Ekonomi',
                'description' => 'Panduan lengkap memahami ekonomi digital dan membangun startup yang sukses.',
                'cover_image' => null,
                'file_path' => 'uploads/books/sample-economy-book.pdf',
                'total_pages' => 280,
                'language' => 'Indonesian',
                'status' => 'available',
                'download_count' => 156,
                'rating' => 4.7,
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
            ],
            [
                'title' => 'Seni Menulis Kreatif',
                'author' => 'Tere Liye',
                'isbn' => '978-602-1234-78-9',
                'publisher' => 'Republika',
                'publication_year' => 2022,
                'category' => 'Sastra',
                'description' => 'Panduan praktis untuk mengembangkan kemampuan menulis kreatif dari penulis terkenal.',
                'cover_image' => null,
                'file_path' => 'uploads/books/sample-writing-book.pdf',
                'total_pages' => 250,
                'language' => 'Indonesian',
                'status' => 'available',
                'download_count' => 234,
                'rating' => 4.9,
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ],
            [
                'title' => 'Manajemen Keuangan Personal',
                'author' => 'Ligwina Hananto',
                'isbn' => '978-602-1234-90-1',
                'publisher' => 'Elex Media',
                'publication_year' => 2023,
                'category' => 'Keuangan',
                'description' => 'Cara mengelola keuangan personal dengan bijak untuk mencapai kebebasan finansial.',
                'cover_image' => null,
                'file_path' => 'uploads/books/sample-finance-book.pdf',
                'total_pages' => 320,
                'language' => 'Indonesian',
                'status' => 'available',
                'download_count' => 198,
                'rating' => 4.4,
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ],
            [
                'title' => 'Fisika Kuantum untuk Semua',
                'author' => 'Prof. Dr. Rudi Hermawan',
                'isbn' => '978-602-1234-12-3',
                'publisher' => 'ITB Press',
                'publication_year' => 2023,
                'category' => 'Sains',
                'description' => 'Penjelasan fisika kuantum yang mudah dipahami untuk pembaca umum.',
                'cover_image' => null,
                'file_path' => 'uploads/books/sample-physics-book.pdf',
                'total_pages' => 420,
                'language' => 'Indonesian',
                'status' => 'available',
                'download_count' => 76,
                'rating' => 4.2,
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'updated_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ],
            [
                'title' => 'Filosofi Hidup Sederhana',
                'author' => 'Emha Ainun Nadjib',
                'isbn' => '978-602-1234-34-5',
                'publisher' => 'Bentang',
                'publication_year' => 2023,
                'category' => 'Filosofi',
                'description' => 'Renungan tentang kehidupan sederhana dan bermakna dalam era modern.',
                'cover_image' => null,
                'file_path' => 'uploads/books/sample-philosophy-book.pdf',
                'total_pages' => 180,
                'language' => 'Indonesian',
                'status' => 'available',
                'download_count' => 145,
                'rating' => 4.8,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert the data
        foreach ($books as $book) {
            $this->db->table('books')->insert($book);
        }

        echo "Book seeder completed successfully!\n";
    }
} 