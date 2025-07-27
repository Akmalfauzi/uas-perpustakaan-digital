<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Riwayat Peminjaman</h2>
            <p class="text-gray-600 mt-1">Kelola dan pantau status peminjaman buku Anda</p>
        </div>
        <a href="/books" class="bg-primary-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-primary-700 transition duration-200 flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Pinjam Buku Baru
        </a>
    </div>
</div>

<!-- Filter Tabs -->
<div class="mb-6">
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8">
            <a href="/dashboard/loans" class="<?= !$currentStatus ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?> whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                Semua Status
            </a>
            <a href="/dashboard/loans?status=pending" class="<?= $currentStatus === 'pending' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?> whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                <i class="fas fa-clock mr-1"></i>
                Pending
            </a>
            <a href="/dashboard/loans?status=approved" class="<?= $currentStatus === 'approved' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?> whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                <i class="fas fa-check-circle mr-1"></i>
                Dipinjam
            </a>
            <a href="/dashboard/loans?status=rejected" class="<?= $currentStatus === 'rejected' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?> whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                <i class="fas fa-times-circle mr-1"></i>
                Ditolak
            </a>
            <a href="/dashboard/loans?status=returned" class="<?= $currentStatus === 'returned' ? 'border-gray-500 text-gray-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?> whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                <i class="fas fa-check mr-1"></i>
                Dikembalikan
            </a>
        </nav>
    </div>
</div>

<!-- Loans List -->
<?php if (!empty($loans)): ?>
    <div class="space-y-6">
        <?php foreach ($loans as $loan): ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-start space-x-4">
                        <!-- Book Cover -->
                        <div class="flex-shrink-0">
                            <?php if ($loan['book_cover']): ?>
                                <img src="/<?= esc($loan['book_cover']) ?>" alt="<?= esc($loan['book_title']) ?>" class="h-24 w-18 rounded object-cover shadow-sm">
                            <?php else: ?>
                                <div class="h-24 w-18 bg-gray-200 rounded flex items-center justify-center">
                                    <i class="fas fa-book text-gray-400 text-2xl"></i>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Book Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 truncate">
                                        <?= esc($loan['book_title']) ?>
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        <i class="fas fa-user mr-1"></i>
                                        <?= esc($loan['book_author']) ?>
                                    </p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        <i class="fas fa-tag mr-1"></i>
                                        <?= esc($loan['book_category']) ?>
                                    </p>
                                </div>

                                <!-- Status Badge -->
                                <div class="flex items-center space-x-2">
                                    <?php if ($loan['status'] === 'pending'): ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-2"></i>
                                            Pending
                                        </span>
                                    <?php elseif ($loan['status'] === 'approved'): ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-2"></i>
                                            Dipinjam
                                        </span>
                                    <?php elseif ($loan['status'] === 'rejected'): ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-2"></i>
                                            Ditolak
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                            <i class="fas fa-check mr-2"></i>
                                            Dikembalikan
                                        </span>
                                    <?php endif; ?>

                                    <!-- Action Button -->
                                    <?php if ($loan['status'] === 'pending'): ?>
                                        <form method="POST" action="/dashboard/cancel-loan/<?= $loan['id'] ?>" class="inline" onsubmit="return confirm('Yakin ingin membatalkan permintaan peminjaman ini?')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                <i class="fas fa-times mr-1"></i>
                                                Batalkan
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Loan Details -->
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">Tanggal Permintaan:</span>
                                    <p class="font-medium text-gray-900">
                                        <?= date('d M Y, H:i', strtotime($loan['created_at'])) ?>
                                    </p>
                                </div>

                                <?php if ($loan['requested_start_date']): ?>
                                <div>
                                    <span class="text-gray-500">Dari Tanggal:</span>
                                    <p class="font-medium text-blue-600">
                                        <?= date('d M Y', strtotime($loan['requested_start_date'])) ?>
                                    </p>
                                </div>
                                <?php endif; ?>

                                <?php if ($loan['requested_end_date']): ?>
                                <div>
                                    <span class="text-gray-500">Sampai Tanggal:</span>
                                    <p class="font-medium text-blue-600">
                                        <?= date('d M Y', strtotime($loan['requested_end_date'])) ?>
                                    </p>
                                </div>
                                <?php endif; ?>

                                <?php if ($loan['loan_date']): ?>
                                <div>
                                    <span class="text-gray-500">Tanggal Pinjam:</span>
                                    <p class="font-medium text-gray-900">
                                        <?= date('d M Y', strtotime($loan['loan_date'])) ?>
                                    </p>
                                </div>
                                <?php endif; ?>

                                <?php if ($loan['due_date']): ?>
                                <div>
                                    <span class="text-gray-500">Jatuh Tempo:</span>
                                    <?php
                                    $dueDate = strtotime($loan['due_date']);
                                    $isOverdue = $dueDate < time();
                                    $daysLeft = ceil(($dueDate - time()) / (60 * 60 * 24));
                                    ?>
                                    <p class="font-medium <?= $isOverdue ? 'text-red-600' : 'text-gray-900' ?>">
                                        <?= date('d M Y', $dueDate) ?>
                                        <?php if ($loan['status'] === 'approved'): ?>
                                            <br>
                                            <span class="text-xs <?= $isOverdue ? 'text-red-600' : 'text-gray-500' ?>">
                                                <?= $isOverdue ? 'Terlambat ' . abs($daysLeft) . ' hari' : $daysLeft . ' hari lagi' ?>
                                            </span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <?php endif; ?>

                                <?php if ($loan['return_date']): ?>
                                <div>
                                    <span class="text-gray-500">Tanggal Kembali:</span>
                                    <p class="font-medium text-gray-900">
                                        <?= date('d M Y', strtotime($loan['return_date'])) ?>
                                    </p>
                                </div>
                                <?php endif; ?>
                            </div>

                            <!-- Notes -->
                            <?php if ($loan['notes']): ?>
                            <div class="mt-4">
                                <span class="text-gray-500 text-sm">Catatan Anda:</span>
                                <p class="text-sm text-gray-700 mt-1 bg-gray-50 p-3 rounded-lg">
                                    <?= nl2br(esc($loan['notes'])) ?>
                                </p>
                            </div>
                            <?php endif; ?>

                            <!-- Admin Notes -->
                            <?php if ($loan['admin_notes']): ?>
                            <div class="mt-4">
                                <span class="text-gray-500 text-sm">Catatan Admin:</span>
                                <p class="text-sm text-gray-700 mt-1 bg-blue-50 border-l-4 border-blue-400 p-3 rounded">
                                    <?= nl2br(esc($loan['admin_notes'])) ?>
                                </p>
                            </div>
                            <?php endif; ?>

                            <!-- Overdue Alert -->
                            <?php if ($loan['status'] === 'approved' && $loan['due_date'] && strtotime($loan['due_date']) < time()): ?>
                            <div class="mt-4 bg-red-50 border border-red-200 rounded-lg p-4">
                                <div class="flex items-start">
                                    <i class="fas fa-exclamation-triangle text-red-600 mr-2 mt-0.5"></i>
                                    <div class="text-sm">
                                        <p class="font-medium text-red-800">Buku Terlambat Dikembalikan</p>
                                        <p class="text-red-700 mt-1">
                                            Buku ini sudah melewati batas waktu peminjaman. 
                                            Silakan hubungi admin untuk proses pengembalian.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <!-- Empty State -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
        <?php if ($currentStatus): ?>
            <i class="fas fa-search text-gray-400 text-5xl mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                Tidak ada peminjaman dengan status "<?= ucfirst($currentStatus) ?>"
            </h3>
            <p class="text-gray-500 mb-6">
                Coba lihat status lain atau buat permintaan peminjaman baru.
            </p>
        <?php else: ?>
            <i class="fas fa-book text-gray-400 text-5xl mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">
                Belum Ada Riwayat Peminjaman
            </h3>
            <p class="text-gray-500 mb-6">
                Anda belum pernah meminjam buku. Mulai jelajahi koleksi kami!
            </p>
        <?php endif; ?>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/books" class="bg-primary-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-primary-700 transition duration-200 inline-flex items-center justify-center">
                <i class="fas fa-search mr-2"></i>
                Jelajahi Koleksi Buku
            </a>
            <?php if ($currentStatus): ?>
                <a href="/dashboard/loans" class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-50 transition duration-200 inline-flex items-center justify-center">
                    <i class="fas fa-list mr-2"></i>
                    Lihat Semua Status
                </a>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto refresh page every 30 seconds for pending loans
    if (window.location.search.includes('status=pending')) {
        setInterval(function() {
            location.reload();
        }, 30000);
    }
});
</script>
<?= $this->endSection() ?> 