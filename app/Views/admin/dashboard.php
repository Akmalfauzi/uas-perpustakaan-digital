<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Dashboard Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Hello, <?= esc(session()->get('userName')) ?>!</h2>
            <p class="text-gray-600 mt-1">Kelola sistem perpustakaan digital dengan mudah melalui dashboard admin.</p>
        </div>
        <div class="text-right">
            <div class="text-sm text-gray-500"><?= date('d M Y') ?></div>
        </div>
    </div>
</div>

<!-- Metrics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total Books -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-book text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Buku</p>
                        <p class="text-2xl font-bold text-gray-900">
                            <?= number_format($bookStats['total_books'] ?? 0) ?>
                        </p>
                        <p class="text-sm text-green-600">
                            <i class="fas fa-check-circle mr-1"></i>
                            <?= number_format($bookStats['available_books'] ?? 0) ?> tersedia
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Users -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-users text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Pengguna</p>
                        <p class="text-2xl font-bold text-gray-900">
                            <?= number_format($userStats['total_users'] ?? 0) ?>
                        </p>
                        <p class="text-sm text-green-600">
                            <i class="fas fa-user-check mr-1"></i>
                            <?= number_format($userStats['active_users'] ?? 0) ?> aktif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Downloads -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-download text-orange-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Download</p>
                        <p class="text-2xl font-bold text-gray-900">
                            <?= number_format($bookStats['total_downloads'] ?? 0) ?>
                        </p>
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-chart-line mr-1"></i>
                            Semua file
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Loans -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-clock text-yellow-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Pending</p>
                        <p class="text-2xl font-bold text-gray-900">
                            <?= number_format($loanStats['pending_loans'] ?? 0) ?>
                        </p>
                        <p class="text-sm text-yellow-600">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Butuh persetujuan
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loan Statistics & Activity -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Loan Statistics -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900">
                <i class="fas fa-chart-bar mr-2 text-primary-600"></i>
                Statistik Peminjaman
            </h3>
        </div>

        <!-- Loan Stats Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-2">
                    <i class="fas fa-clock text-yellow-600 text-sm"></i>
                </div>
                <div class="text-2xl font-bold text-yellow-800"><?= number_format($loanStats['pending_loans'] ?? 0) ?></div>
                <div class="text-sm text-yellow-600">Pending</div>
            </div>
            
            <div class="text-center p-4 bg-green-50 rounded-lg border border-green-200">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                    <i class="fas fa-check text-green-600 text-sm"></i>
                </div>
                <div class="text-2xl font-bold text-green-800"><?= number_format($loanStats['approved_loans'] ?? 0) ?></div>
                <div class="text-sm text-green-600">Dipinjam</div>
            </div>
            
            <div class="text-center p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                    <i class="fas fa-undo text-blue-600 text-sm"></i>
                </div>
                <div class="text-2xl font-bold text-blue-800"><?= number_format($loanStats['returned_loans'] ?? 0) ?></div>
                <div class="text-sm text-blue-600">Dikembalikan</div>
            </div>
            
            <div class="text-center p-4 bg-red-50 rounded-lg border border-red-200">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-2">
                    <i class="fas fa-exclamation-triangle text-red-600 text-sm"></i>
                </div>
                <div class="text-2xl font-bold text-red-800"><?= number_format($loanStats['overdue_loans'] ?? 0) ?></div>
                <div class="text-sm text-red-600">Terlambat</div>
            </div>
        </div>

        <!-- Quick Action Buttons -->
        <div class="flex items-center justify-center mt-6 space-x-4">
            <a href="/admin/loans?status=pending" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition duration-200 text-sm">
                <i class="fas fa-clock mr-2"></i>Lihat Pending
            </a>
            <a href="/admin/loans" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition duration-200 text-sm">
                <i class="fas fa-list mr-2"></i>Semua Peminjaman
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">
            <i class="fas fa-history mr-2 text-primary-600"></i>
            Aktivitas Terbaru
        </h3>
        
        <div class="space-y-4">
            <!-- Recent Loans -->
            <?php if (!empty($recentLoans)): ?>
                <?php foreach (array_slice($recentLoans, 0, 3) as $loan): ?>
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 <?= $loan['status'] === 'pending' ? 'bg-yellow-600' : ($loan['status'] === 'approved' ? 'bg-green-600' : 'bg-blue-600') ?> rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas <?= $loan['status'] === 'pending' ? 'fa-clock' : ($loan['status'] === 'approved' ? 'fa-check' : 'fa-undo') ?> text-white text-xs"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900"><?= esc($loan['user_name']) ?></p>
                        <p class="text-sm text-gray-500">
                            <?php if ($loan['status'] === 'pending'): ?>
                                Mengajukan peminjaman
                            <?php elseif ($loan['status'] === 'approved'): ?>
                                Peminjaman disetujui
                            <?php else: ?>
                                Mengembalikan buku
                            <?php endif; ?>
                            - <?= esc($loan['book_title']) ?>
                        </p>
                        <div class="flex items-center mt-1">
                            <span class="text-xs text-gray-400">
                                <?= date('d M, H:i', strtotime($loan['created_at'])) ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- Recent Users -->
            <?php if (!empty($recentUsers)): ?>
                <?php foreach (array_slice($recentUsers, 0, 2) as $user): ?>
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white text-xs font-medium">
                            <?= strtoupper(substr($user['name'], 0, 1)) ?>
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900"><?= esc($user['name']) ?></p>
                        <p class="text-sm text-gray-500">Pengguna baru terdaftar</p>
                        <div class="flex items-center mt-1">
                            <span class="text-xs text-gray-400">
                                <?= date('d M, H:i', strtotime($user['created_at'])) ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- Recent Books -->
            <?php if (!empty($recentBooks)): ?>
                <?php foreach (array_slice($recentBooks, 0, 1) as $book): ?>
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-book text-white text-xs"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Buku baru ditambahkan</p>
                        <p class="text-sm text-gray-500"><?= esc($book['title']) ?></p>
                        <div class="flex items-center mt-1">
                            <span class="text-xs text-gray-400">
                                <?= date('d M, H:i', strtotime($book['created_at'])) ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- View All Activities -->
        <div class="mt-6 text-center">
            <a href="/admin/loans" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                Lihat semua aktivitas <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
</div>

<!-- Popular Books & Quick Actions -->
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-semibold text-gray-900">
            <i class="fas fa-fire mr-2 text-orange-600"></i>
            Buku Populer
        </h3>
        <a href="/admin/books" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
            Lihat semua <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>

    <div class="space-y-4">
        <?php if (!empty($popularBooks)): ?>
            <?php foreach (array_slice($popularBooks, 0, 5) as $index => $book): ?>
            <!-- Book Item -->
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">#<?= $index + 1 ?></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-medium text-gray-900 truncate"><?= esc($book['title']) ?></h4>
                        <div class="flex items-center mt-1 space-x-4">
                            <span class="text-xs text-gray-500">
                                <i class="fas fa-user mr-1"></i><?= esc($book['author']) ?>
                            </span>
                            <span class="text-xs text-gray-500">
                                <i class="fas fa-download mr-1"></i><?= number_format($book['download_count']) ?> downloads
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <?php if ($book['status'] === 'available'): ?>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check mr-1"></i>Tersedia
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-clock mr-1"></i>Dipinjam
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center py-8">
                <i class="fas fa-book text-gray-300 text-4xl mb-4"></i>
                <p class="text-gray-500">Belum ada data buku populer</p>
                <a href="/admin/books/new" class="text-primary-600 hover:text-primary-700 text-sm font-medium mt-2 inline-block">
                    Tambah buku pertama <i class="fas fa-plus ml-1"></i>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Quick Actions -->
    <div class="mt-6 border-t border-gray-200 pt-6">
        <h4 class="text-sm font-medium text-gray-900 mb-4">Aksi Cepat</h4>
        <div class="grid grid-cols-2 gap-3">
            <a href="/admin/books/new" class="flex items-center justify-center px-4 py-3 bg-primary-50 border border-primary-200 rounded-lg hover:bg-primary-100 transition duration-200">
                <i class="fas fa-plus text-primary-600 mr-2"></i>
                <span class="text-sm font-medium text-primary-700">Tambah Buku</span>
            </a>
            <a href="/admin/users/new" class="flex items-center justify-center px-4 py-3 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition duration-200">
                <i class="fas fa-user-plus text-green-600 mr-2"></i>
                <span class="text-sm font-medium text-green-700">Tambah User</span>
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto refresh notifications if there are pending loans
    <?php if (($loanStats['pending_loans'] ?? 0) > 0): ?>
    console.log('Ada <?= $loanStats['pending_loans'] ?> peminjaman yang pending persetujuan');
    <?php endif; ?>
    
    // Add tooltips for statistics
    const statCards = document.querySelectorAll('[data-tooltip]');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            // Show tooltip logic if needed
        });
    });
});
</script>
<?= $this->endSection() ?> 