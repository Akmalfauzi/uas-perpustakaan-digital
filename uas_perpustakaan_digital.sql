-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Jul 2025 pada 11.30
-- Versi server: 8.0.27
-- Versi PHP: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uas_perpustakaan_digital`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `books`
--

CREATE TABLE `books` (
  `id` int UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `isbn` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `publisher` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `publication_year` year DEFAULT NULL,
  `category` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `cover_image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `total_pages` int DEFAULT NULL,
  `language` varchar(50) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Indonesian',
  `status` enum('available','borrowed','maintenance') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'available',
  `download_count` int NOT NULL DEFAULT '0',
  `rating` decimal(3,2) NOT NULL DEFAULT '0.00',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `isbn`, `publisher`, `publication_year`, `category`, `description`, `cover_image`, `file_path`, `total_pages`, `language`, `status`, `download_count`, `rating`, `created_at`, `updated_at`) VALUES
(1, 'Pemrograman Web dengan PHP dan MySQL', 'Dr. Ahmad Setiono', '978-602-1234-56-7', 'Gramedia Pustaka Utama', '2023', 'Teknologi', 'Buku komprehensif tentang pengembangan web menggunakan PHP dan MySQL. Cocok untuk pemula hingga intermediate.', NULL, 'uploads/books/sample-programming-book.pdf', 450, 'Indonesian', 'available', 125, 4.50, '2025-06-23 21:10:10', '2025-06-23 21:10:10'),
(2, 'Machine Learning untuk Pemula', 'Prof. Sari Wahyuni', '978-602-1234-78-9', 'Erlangga', '2023', 'Teknologi', 'Pengantar machine learning yang mudah dipahami dengan contoh praktis menggunakan Python.', NULL, 'uploads/books/sample-ml-book.pdf', 320, 'Indonesian', 'available', 89, 4.80, '2025-06-28 21:10:10', '2025-06-28 21:10:10'),
(3, 'Sejarah Nusantara: Dari Majapahit hingga Kemerdekaan', 'Dr. Bambang Sutrisno', '978-602-1234-90-1', 'Mizan', '2022', 'Sejarah', 'Buku sejarah lengkap tentang perjalanan bangsa Indonesia dari masa kerajaan hingga kemerdekaan.', NULL, 'uploads/books/sample-history-book.pdf', 580, 'Indonesian', 'available', 67, 4.30, '2025-07-03 21:10:10', '2025-07-03 21:10:10'),
(4, 'Matematika Diskrit dan Aplikasinya', 'Prof. Dr. Indira Sari', '978-602-1234-12-3', 'Andi Offset', '2023', 'Matematika', 'Buku matematika diskrit dengan pendekatan praktis dan aplikasi dalam ilmu komputer.', NULL, 'uploads/books/sample-math-book.pdf', 400, 'Indonesian', 'available', 43, 4.10, '2025-07-08 21:10:10', '2025-07-08 21:10:10'),
(5, 'Psikologi Pendidikan Modern', 'Dr. Maya Kartika', '978-602-1234-34-5', 'Kencana', '2023', 'Psikologi', 'Pendekatan modern dalam psikologi pendidikan untuk meningkatkan efektivitas pembelajaran.', NULL, 'uploads/books/sample-psychology-book.pdf', 350, 'Indonesian', 'available', 78, 4.60, '2025-07-13 21:10:10', '2025-07-13 21:10:10'),
(6, 'Ekonomi Digital dan Startup', 'Budi Santoso, M.B.A.', '978-602-1234-56-7', 'Grasindo', '2023', 'Ekonomi', 'Panduan lengkap memahami ekonomi digital dan membangun startup yang sukses.', NULL, 'uploads/books/sample-economy-book.pdf', 280, 'Indonesian', 'available', 156, 4.70, '2025-07-18 21:10:10', '2025-07-18 21:10:10'),
(7, 'Seni Menulis Kreatif', 'Tere Liye', '978-602-1234-78-9', 'Republika', '2022', 'Sastra', 'Panduan praktis untuk mengembangkan kemampuan menulis kreatif dari penulis terkenal.', NULL, 'uploads/books/sample-writing-book.pdf', 250, 'Indonesian', 'available', 234, 4.90, '2025-07-20 21:10:10', '2025-07-20 21:10:10'),
(8, 'Manajemen Keuangan Personal', 'Ligwina Hananto', '978-602-1234-90-1', 'Elex Media', '2023', 'Keuangan', 'Cara mengelola keuangan personal dengan bijak untuk mencapai kebebasan finansial.', NULL, 'uploads/books/sample-finance-book.pdf', 320, 'Indonesian', 'available', 198, 4.40, '2025-07-21 21:10:10', '2025-07-21 21:10:10'),
(9, 'Fisika Kuantum untuk Semua', 'Prof. Dr. Rudi Hermawan', '978-602-1234-12-3', 'ITB Press', '2023', 'Sains', 'Penjelasan fisika kuantum yang mudah dipahami untuk pembaca umum.', NULL, 'uploads/books/sample-physics-book.pdf', 420, 'Indonesian', 'available', 76, 4.20, '2025-07-22 21:10:10', '2025-07-22 21:10:10'),
(10, 'Filosofi Hidup Sederhana', 'Emha Ainun Nadjib', '978-602-1234-34-5', 'Bentang', '2023', 'Filosofi', 'Renungan tentang kehidupan sederhana dan bermakna dalam era modern.', NULL, 'uploads/books/sample-philosophy-book.pdf', 180, 'Indonesian', 'available', 145, 4.80, '2025-07-23 21:10:10', '2025-07-23 21:10:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `download_logs`
--

CREATE TABLE `download_logs` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `book_id` int UNSIGNED NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_general_ci,
  `download_date` datetime DEFAULT NULL,
  `file_size` bigint DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `loans`
--

CREATE TABLE `loans` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `book_id` int UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected','returned') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'pending',
  `loan_date` datetime DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `return_date` datetime DEFAULT NULL,
  `notes` text COLLATE utf8mb4_general_ci,
  `requested_start_date` datetime DEFAULT NULL,
  `requested_end_date` datetime DEFAULT NULL,
  `admin_notes` text COLLATE utf8mb4_general_ci,
  `approved_by` int UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `loans`
--

INSERT INTO `loans` (`id`, `user_id`, `book_id`, `status`, `loan_date`, `due_date`, `return_date`, `notes`, `requested_start_date`, `requested_end_date`, `admin_notes`, `approved_by`, `created_at`, `updated_at`) VALUES
(1, 2, 10, 'returned', '2025-07-27 00:00:00', '2025-08-03 00:00:00', '2025-07-27 17:29:49', '', '2025-07-27 00:00:00', '2025-08-03 00:00:00', '', 1, '2025-07-27 17:28:06', '2025-07-27 17:29:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(7, '2024-01-01-000001', 'App\\Database\\Migrations\\CreateBooksTable', 'default', 'App', 1753279748, 1),
(8, '2024-01-01-000002', 'App\\Database\\Migrations\\CreateUsersTable', 'default', 'App', 1753279748, 1),
(9, '2024-01-01-000004', 'App\\Database\\Migrations\\CreateLoansTable', 'default', 'App', 1753279748, 1),
(10, '2024-01-01-000005', 'App\\Database\\Migrations\\AddRequestedStartDateToLoans', 'default', 'App', 1753279748, 1),
(11, '2024-01-01-000006', 'App\\Database\\Migrations\\CreateDownloadLogsTable', 'default', 'App', 1753279748, 1),
(12, '2024-01-01-000007', 'App\\Database\\Migrations\\AddRequestedEndDateToLoans', 'default', 'App', 1753279748, 1),
(13, '2024-01-01-000008', 'App\\Database\\Migrations\\CreateSettingsTable', 'default', 'App', 1753280269, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `settings`
--

CREATE TABLE `settings` (
  `id` int UNSIGNED NOT NULL,
  `setting_key` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `setting_value` text COLLATE utf8mb4_general_ci,
  `setting_type` enum('string','number','boolean','json') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'string',
  `description` text COLLATE utf8mb4_general_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `setting_type`, `description`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Perpustakaan Digital', 'string', 'Nama website perpustakaan', '2025-07-23 21:17:48', '2025-07-27 18:09:19'),
(2, 'site_description', 'Sistem Perpustakaan Digital Modern', 'string', 'Deskripsi website perpustakaan', '2025-07-23 21:17:48', '2025-07-27 18:09:19'),
(3, 'books_per_page', '4', 'number', 'Jumlah buku per halaman', '2025-07-23 21:17:48', '2025-07-27 18:09:19'),
(4, 'max_file_size', '50', 'number', 'Ukuran file maksimal upload dalam MB', '2025-07-23 21:17:48', '2025-07-27 18:09:19'),
(5, 'allow_registration', '0', 'boolean', 'Izinkan registrasi pengguna baru', '2025-07-23 21:17:48', '2025-07-27 18:09:19'),
(6, 'email_verification', '0', 'boolean', 'Verifikasi email untuk akun baru', '2025-07-23 21:17:48', '2025-07-27 18:09:19'),
(7, 'min_password_length', '6', 'number', 'Panjang password minimal', '2025-07-23 21:17:48', '2025-07-27 17:00:11'),
(8, 'session_timeout', '60', 'number', 'Session timeout dalam menit', '2025-07-23 21:17:48', '2025-07-27 17:00:11'),
(9, 'max_loan_days', '30', 'number', 'Maksimal hari peminjaman buku', '2025-07-23 21:17:48', '2025-07-23 21:17:48'),
(10, 'max_loan_books', '5', 'number', 'Maksimal buku yang bisa dipinjam per user', '2025-07-23 21:17:48', '2025-07-23 21:17:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@perpustakaan.com', '$2y$10$tpT2e/lCLcahcVOwettXsuU5Bskevw0IdoW3YHW8KNC9pntLRl5nS', 'admin', 1, '2025-07-27 17:29:42', '2025-07-23 21:09:24', '2025-07-27 17:29:42'),
(2, 'User Demo', 'user@perpustakaan.com', '$2y$10$xoiemlKNjmyLdqy1VveND.6DKYp9rIpOH05QN3VkB1LaVW.bvZs.C', 'user', 1, '2025-07-27 17:29:17', '2025-07-23 21:09:24', '2025-07-27 17:29:17'),
(3, 'Budi Santoso', 'budi@example.com', '$2y$10$YyvPByCADlgboo3O3BcgaO18dOspusFGtkKVBycGgvRHsOvrn1v/C', 'user', 1, NULL, '2025-07-23 21:09:24', '2025-07-23 21:09:24'),
(4, 'Siti Rahayu', 'siti@example.com', '$2y$10$P2t1780pMaTSkIeLfu6j4OVrUFo1ZmWAKtv/Q1eH09ASSBwdrPqWm', 'user', 1, NULL, '2025-07-23 21:09:24', '2025-07-23 21:09:24');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title` (`title`),
  ADD KEY `author` (`author`),
  ADD KEY `category` (`category`),
  ADD KEY `status` (`status`);

--
-- Indeks untuk tabel `download_logs`
--
ALTER TABLE `download_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `download_logs_book_id_foreign` (`book_id`),
  ADD KEY `user_id_book_id` (`user_id`,`book_id`),
  ADD KEY `download_date` (`download_date`);

--
-- Indeks untuk tabel `loans`
--
ALTER TABLE `loans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loans_book_id_foreign` (`book_id`),
  ADD KEY `loans_approved_by_foreign` (`approved_by`),
  ADD KEY `user_id_book_id` (`user_id`,`book_id`),
  ADD KEY `status` (`status`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role` (`role`),
  ADD KEY `is_active` (`is_active`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `books`
--
ALTER TABLE `books`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `download_logs`
--
ALTER TABLE `download_logs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `loans`
--
ALTER TABLE `loans`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `download_logs`
--
ALTER TABLE `download_logs`
  ADD CONSTRAINT `download_logs_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `download_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `loans`
--
ALTER TABLE `loans`
  ADD CONSTRAINT `loans_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE SET NULL,
  ADD CONSTRAINT `loans_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `loans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
