<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<!-- Dashboard Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-gray-900">Hello, <?= esc($userName) ?>!</h2>
            <p class="text-gray-600 mt-1">Kelola peminjaman buku Anda dengan mudah melalui dashboard ini.</p>
        </div>
        <div class="text-right">
            <div class="text-sm text-gray-500"><?= date('d M, Y') ?></div>
        </div>
    </div>
</div>

<!-- Metrics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total Peminjaman -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-book text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Peminjaman</p>
                        <p class="text-2xl font-bold text-gray-900"><?= number_format($loanStats['total']) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending -->
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
                            <?= number_format($loanStats['pending']) ?>
                            <?php if ($loanStats['pending'] > 0): ?>
                                <span class="text-sm font-normal text-yellow-600 ml-2">
                                    <i class="fas fa-exclamation-circle"></i> Menunggu persetujuan
                                </span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dipinjam -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Dipinjam</p>
                        <p class="text-2xl font-bold text-gray-900">
                            <?= number_format($loanStats['approved']) ?>
                            <?php if ($loanStats['overdue'] > 0): ?>
                                <span class="text-sm font-normal text-red-600 ml-2">
                                    <i class="fas fa-exclamation-triangle"></i> <?= $loanStats['overdue'] ?> terlambat
                                </span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dikembalikan -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-archive text-gray-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Dikembalikan</p>
                        <p class="text-2xl font-bold text-gray-900"><?= number_format($loanStats['returned']) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Activity -->
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Aktivitas Terbaru</h3>
        
        <div class="space-y-4">
            <?php if (!empty($recentLoans)): ?>
                <?php foreach (array_slice($recentLoans, 0, 5) as $loan): ?>
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 <?= $loan['status'] == 'approved' ? 'bg-green-600' : ($loan['status'] == 'pending' ? 'bg-yellow-600' : ($loan['status'] == 'returned' ? 'bg-gray-600' : 'bg-red-600')) ?> rounded-full flex items-center justify-center flex-shrink-0">
                        <i class="fas <?= $loan['status'] == 'approved' ? 'fa-check' : ($loan['status'] == 'pending' ? 'fa-clock' : ($loan['status'] == 'returned' ? 'fa-archive' : 'fa-times')) ?> text-white text-xs"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900"><?= esc($loan['book_title']) ?></p>
                        <p class="text-sm text-gray-500">
                            <?php
                            switch($loan['status']) {
                                case 'approved':
                                    echo 'Peminjaman disetujui';
                                    break;
                                case 'pending':
                                    echo 'Menunggu persetujuan';
                                    break;
                                case 'returned':
                                    echo 'Buku dikembalikan';
                                    break;
                                case 'rejected':
                                    echo 'Peminjaman ditolak';
                                    break;
                            }
                            ?>
                        </p>
                        <div class="flex items-center mt-1">
                            <span class="text-xs text-gray-400">
                                <?= date('d M Y H:i', strtotime($loan['created_at'])) ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center py-8">
                    <i class="fas fa-book text-gray-300 text-4xl mb-4"></i>
                    <p class="text-gray-500">Belum ada aktivitas peminjaman</p>
                    <a href="/books" class="text-primary-600 hover:text-primary-700 text-sm font-medium mt-2 inline-block">
                        Jelajahi buku sekarang <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if (!empty($recentLoans) && count($recentLoans) > 5): ?>
        <div class="mt-6 text-center">
            <a href="/dashboard/loans" class="inline-flex items-center text-sm font-medium text-primary-600 hover:text-primary-700">
                Lihat semua aktivitas
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        <?php endif; ?>
    </div>

    <!-- Quick Actions & Overdue Alerts -->
    <div class="space-y-6">
        <!-- Overdue Alert -->
        <?php if ($loanStats['overdue'] > 0): ?>
        <div class="bg-red-50 border border-red-200 rounded-xl p-6">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <div>
                    <h4 class="text-lg font-medium text-red-900">Buku Terlambat</h4>
                    <p class="text-sm text-red-700 mt-1">
                        Anda memiliki <?= $loanStats['overdue'] ?> buku yang terlambat dikembalikan
                    </p>
                </div>
            </div>
            <div class="mt-4">
                <a href="/dashboard/loans?status=overdue" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700">
                    Lihat Detail
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
        <?php endif; ?>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <h4 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h4>
            
            <div class="space-y-3">
                <a href="/books" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-search text-blue-600"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Jelajahi Buku</p>
                        <p class="text-sm text-gray-500">Cari dan pinjam buku baru</p>
                    </div>
                </a>
                
                <a href="/dashboard/loans" class="flex items-center p-3 rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-list text-green-600"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Riwayat Peminjaman</p>
                        <p class="text-sm text-gray-500">Lihat semua peminjaman Anda</p>
                    </div>
                </a>
                
                <?php if ($loanStats['pending'] > 0): ?>
                <a href="/dashboard/loans?status=pending" class="flex items-center p-3 rounded-lg border border-yellow-200 bg-yellow-50 hover:bg-yellow-100 transition-colors">
                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-clock text-yellow-600"></i>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Pending Approval</p>
                        <p class="text-sm text-gray-500"><?= $loanStats['pending'] ?> permintaan menunggu</p>
                    </div>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Auto refresh untuk update status real-time
    setTimeout(function() {
        location.reload();
    }, 300000); // Refresh setiap 5 menit
</script>
<?= $this->endSection() ?> 