<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Page Header -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Pengaturan System</h2>
            <p class="text-gray-600 mt-1">Atur dan kelola pengaturan sistem perpustakaan digital</p>
        </div>
    </div>
</div>

<!-- Success/Error Messages -->
<?php if (session()->getFlashdata('success')): ?>
<div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
    <div class="flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <?= session()->getFlashdata('success') ?>
    </div>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
    <div class="flex items-center">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <?= session()->getFlashdata('error') ?>
    </div>
</div>
<?php endif; ?>

<!-- Settings Sections -->
<div class="space-y-6">
    <!-- General Settings -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
            <i class="fas fa-cog mr-2 text-primary-600"></i>
            Pengaturan Umum
        </h3>
        
        <form action="/admin/settings/update" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="site_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Website
                    </label>
                    <input 
                        type="text" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                        id="site_name" 
                        name="site_name" 
                        value="<?= esc($settings['site_name'] ?? 'Perpustakaan Digital') ?>"
                    >
                </div>
                <div>
                    <label for="site_description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Website
                    </label>
                    <input 
                        type="text" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                        id="site_description" 
                        name="site_description" 
                        value="<?= esc($settings['site_description'] ?? 'Sistem Perpustakaan Digital') ?>"
                    >
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="books_per_page" class="block text-sm font-medium text-gray-700 mb-2">
                        Buku per Halaman
                    </label>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" id="books_per_page" name="books_per_page">
                        <option value="12" <?= ($settings['books_per_page'] ?? 12) == 12 ? 'selected' : '' ?>>12</option>
                        <option value="24" <?= ($settings['books_per_page'] ?? 12) == 24 ? 'selected' : '' ?>>24</option>
                        <option value="36" <?= ($settings['books_per_page'] ?? 12) == 36 ? 'selected' : '' ?>>36</option>
                        <option value="48" <?= ($settings['books_per_page'] ?? 12) == 48 ? 'selected' : '' ?>>48</option>
                    </select>
                </div>
                <div>
                    <label for="max_file_size" class="block text-sm font-medium text-gray-700 mb-2">
                        Ukuran File Maksimal (MB)
                    </label>
                    <input 
                        type="number" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                        id="max_file_size" 
                        name="max_file_size" 
                        value="<?= esc($settings['max_file_size'] ?? 50) ?>"
                        min="1"
                        max="500"
                    >
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>

    <!-- User Management Settings -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
            <i class="fas fa-users mr-2 text-primary-600"></i>
            Pengaturan Pengguna
        </h3>
        
        <form action="/admin/settings/update" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="allow_registration" value="1" class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200" <?= ($settings['allow_registration'] ?? 1) ? 'checked' : '' ?>>
                        <span class="ml-2 text-sm text-gray-700">Izinkan registrasi pengguna baru</span>
                    </label>
                </div>
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" name="email_verification" value="1" class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200" <?= ($settings['email_verification'] ?? 1) ? 'checked' : '' ?>>
                        <span class="ml-2 text-sm text-gray-700">Verifikasi email untuk akun baru</span>
                    </label>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="min_password_length" class="block text-sm font-medium text-gray-700 mb-2">
                        Panjang Password Minimal
                    </label>
                    <input 
                        type="number" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                        id="min_password_length" 
                        name="min_password_length" 
                        value="<?= esc($settings['min_password_length'] ?? 6) ?>"
                        min="6"
                        max="20"
                    >
                </div>
                <div>
                    <label for="session_timeout" class="block text-sm font-medium text-gray-700 mb-2">
                        Session Timeout (menit)
                    </label>
                    <input 
                        type="number" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                        id="session_timeout" 
                        name="session_timeout" 
                        value="<?= esc($settings['session_timeout'] ?? 60) ?>"
                        min="15"
                        max="480"
                    >
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>

    <!-- Loan Settings -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
            <i class="fas fa-book-open mr-2 text-primary-600"></i>
            Pengaturan Peminjaman
        </h3>
        
        <form action="/admin/settings/update" method="POST" class="space-y-4">
            <?= csrf_field() ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="max_loan_days" class="block text-sm font-medium text-gray-700 mb-2">
                        Maksimal Hari Peminjaman
                    </label>
                    <input 
                        type="number" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                        id="max_loan_days" 
                        name="max_loan_days" 
                        value="<?= esc($settings['max_loan_days'] ?? 30) ?>"
                        min="1"
                        max="365"
                    >
                    <p class="text-xs text-gray-500 mt-1">Default durasi maksimal peminjaman buku</p>
                </div>
                <div>
                    <label for="max_loan_books" class="block text-sm font-medium text-gray-700 mb-2">
                        Maksimal Buku per User
                    </label>
                    <input 
                        type="number" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                        id="max_loan_books" 
                        name="max_loan_books" 
                        value="<?= esc($settings['max_loan_books'] ?? 5) ?>"
                        min="1"
                        max="50"
                    >
                    <p class="text-xs text-gray-500 mt-1">Jumlah buku yang bisa dipinjam bersamaan</p>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>

    <!-- System Information -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
            <i class="fas fa-info-circle mr-2 text-primary-600"></i>
            Informasi System
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-600">PHP Version</div>
                <div class="text-lg font-semibold text-gray-900"><?= PHP_VERSION ?></div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-600">CodeIgniter Version</div>
                <div class="text-lg font-semibold text-gray-900"><?= \CodeIgniter\CodeIgniter::CI_VERSION ?></div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-600">Server Software</div>
                <div class="text-lg font-semibold text-gray-900"><?= $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' ?></div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-sm text-gray-600">Memory Limit</div>
                <div class="text-lg font-semibold text-gray-900"><?= ini_get('memory_limit') ?></div>
            </div>
        </div>
    </div>

    <!-- Database Management -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
            <i class="fas fa-database mr-2 text-primary-600"></i>
            Manajemen Database
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-book text-blue-600"></i>
                    </div>
                    <div>
                        <div class="text-sm text-blue-600">Total Buku</div>
                        <div class="text-2xl font-bold text-blue-900">
                            <?= number_format($bookStats['total_books'] ?? 0) ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-users text-green-600"></i>
                    </div>
                    <div>
                        <div class="text-sm text-green-600">Total Pengguna</div>
                        <div class="text-2xl font-bold text-green-900">
                            <?= number_format($userStats['total_users'] ?? 0) ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-download text-orange-600"></i>
                    </div>
                    <div>
                        <div class="text-sm text-orange-600">Total Download</div>
                        <div class="text-2xl font-bold text-orange-900">
                            <?= number_format($bookStats['total_downloads'] ?? 0) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add any settings-specific JavaScript here
    console.log('Settings page loaded');
});
</script>
<?= $this->endSection() ?> 