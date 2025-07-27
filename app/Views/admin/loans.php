<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Manajemen Peminjaman</h2>
            <p class="text-gray-600 mt-1">Kelola permintaan peminjaman dan status buku</p>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100">
                <i class="fas fa-list text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total</p>
                <p class="text-2xl font-bold text-gray-900"><?= number_format($loanStats['total_loans']) ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Pending</p>
                <p class="text-2xl font-bold text-gray-900"><?= number_format($loanStats['pending_loans']) ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Dipinjam</p>
                <p class="text-2xl font-bold text-gray-900"><?= number_format($loanStats['approved_loans']) ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Terlambat</p>
                <p class="text-2xl font-bold text-gray-900"><?= number_format($loanStats['overdue_loans']) ?></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-gray-100">
                <i class="fas fa-check text-gray-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Dikembalikan</p>
                <p class="text-2xl font-bold text-gray-900"><?= number_format($loanStats['returned_loans']) ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Filter Tabs -->
<div class="mb-6">
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8">
            <a href="/admin/loans" class="<?= !$currentStatus ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?> whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                Semua Status
            </a>
            <a href="/admin/loans?status=pending" class="<?= $currentStatus === 'pending' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?> whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                <i class="fas fa-clock mr-1"></i>
                Pending (<?= number_format($loanStats['pending_loans']) ?>)
            </a>
            <a href="/admin/loans?status=approved" class="<?= $currentStatus === 'approved' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?> whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                <i class="fas fa-check-circle mr-1"></i>
                Dipinjam (<?= number_format($loanStats['approved_loans']) ?>)
            </a>
            <a href="/admin/loans?status=rejected" class="<?= $currentStatus === 'rejected' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?> whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                <i class="fas fa-times-circle mr-1"></i>
                Ditolak
            </a>
            <a href="/admin/loans?status=returned" class="<?= $currentStatus === 'returned' ? 'border-gray-500 text-gray-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?> whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
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

                        <!-- Loan Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        <?= esc($loan['book_title']) ?>
                                    </h3>
                                    <p class="text-sm text-gray-600 mt-1">
                                        <i class="fas fa-user mr-1"></i>
                                        <?= esc($loan['book_author']) ?>
                                    </p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Peminjam: <span class="font-medium"><?= esc($loan['user_name']) ?></span>
                                        (<?= esc($loan['user_email']) ?>)
                                    </p>
                                </div>

                                <!-- Status & Actions -->
                                <div class="flex items-center space-x-3">
                                    <!-- Status Badge -->
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

                                    <!-- Action Buttons -->
                                    <?php if ($loan['status'] === 'pending'): ?>
                                        <button onclick="openLoanModal(<?= $loan['id'] ?>, 'approve', '<?= esc($loan['book_title']) ?>', '<?= esc($loan['user_name']) ?>')" 
                                                class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 transition duration-200">
                                            <i class="fas fa-check mr-1"></i>
                                            Setujui
                                        </button>
                                        <button onclick="openLoanModal(<?= $loan['id'] ?>, 'reject', '<?= esc($loan['book_title']) ?>', '<?= esc($loan['user_name']) ?>')" 
                                                class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition duration-200">
                                            <i class="fas fa-times mr-1"></i>
                                            Tolak
                                        </button>
                                    <?php elseif ($loan['status'] === 'approved'): ?>
                                        <button onclick="openLoanModal(<?= $loan['id'] ?>, 'return', '<?= esc($loan['book_title']) ?>', '<?= esc($loan['user_name']) ?>')" 
                                                class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition duration-200">
                                            <i class="fas fa-undo mr-1"></i>
                                            Kembalikan
                                        </button>
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

                                <?php if ($loan['approved_by_name']): ?>
                                <div>
                                    <span class="text-gray-500">Disetujui oleh:</span>
                                    <p class="font-medium text-gray-900">
                                        <?= esc($loan['approved_by_name']) ?>
                                    </p>
                                </div>
                                <?php endif; ?>
                            </div>

                            <!-- Notes -->
                            <?php if ($loan['notes']): ?>
                            <div class="mt-4">
                                <span class="text-gray-500 text-sm">Catatan Peminjam:</span>
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
                                            Silakan hubungi peminjam atau proses pengembalian.
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
        <i class="fas fa-search text-gray-400 text-5xl mb-4"></i>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">
            <?php if ($currentStatus): ?>
                Tidak ada peminjaman dengan status "<?= ucfirst($currentStatus) ?>"
            <?php else: ?>
                Belum Ada Data Peminjaman
            <?php endif; ?>
        </h3>
        <p class="text-gray-500 mb-6">
            <?php if ($currentStatus): ?>
                Coba lihat status lain atau tunggu permintaan peminjaman baru.
            <?php else: ?>
                Belum ada user yang mengajukan peminjaman buku.
            <?php endif; ?>
        </p>
        
        <?php if ($currentStatus): ?>
            <a href="/admin/loans" class="bg-primary-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-primary-700 transition duration-200 inline-flex items-center">
                <i class="fas fa-list mr-2"></i>
                Lihat Semua Status
            </a>
        <?php endif; ?>
    </div>
<?php endif; ?>

<!-- Loan Action Modal -->
<div x-data="{ open: false, action: '', loanId: '', bookTitle: '', userName: '' }" 
     x-show="open" 
     x-on:open-loan-action-modal.window="open = true; action = $event.detail.action; loanId = $event.detail.loanId; bookTitle = $event.detail.bookTitle; userName = $event.detail.userName;" 
     class="fixed inset-0 z-50 overflow-y-auto" 
     style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="open = false"></div>

        <!-- Modal panel -->
        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
            <div class="flex items-center mb-4">
                <div class="flex items-center justify-center w-12 h-12 mx-auto rounded-full" 
                     :class="action === 'approve' ? 'bg-green-100' : action === 'reject' ? 'bg-red-100' : 'bg-blue-100'">
                    <i class="text-xl" 
                       :class="action === 'approve' ? 'fas fa-check text-green-600' : action === 'reject' ? 'fas fa-times text-red-600' : 'fas fa-undo text-blue-600'"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900" x-text="action === 'approve' ? 'Setujui Peminjaman' : action === 'reject' ? 'Tolak Peminjaman' : 'Kembalikan Buku'"></h3>
                </div>
            </div>
            
            <div class="mb-4">
                <p class="text-gray-600 mb-2">
                    <strong>Buku:</strong> <span x-text="bookTitle"></span>
                </p>
                <p class="text-gray-600">
                    <strong>Peminjam:</strong> <span x-text="userName"></span>
                </p>
            </div>
            
            <form :action="'/admin/loans/' + loanId + '/' + action" method="POST" class="space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label for="adminNotes" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan Admin (Opsional)
                    </label>
                    <textarea 
                        id="adminNotes" 
                        name="admin_notes" 
                        rows="3" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                        :placeholder="action === 'approve' ? 'Catatan persetujuan...' : action === 'reject' ? 'Alasan penolakan...' : 'Catatan pengembalian...'"
                    ></textarea>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" @click="open = false" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition duration-200">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2 text-white rounded-lg transition duration-200"
                            :class="action === 'approve' ? 'bg-green-600 hover:bg-green-700' : action === 'reject' ? 'bg-red-600 hover:bg-red-700' : 'bg-blue-600 hover:bg-blue-700'">
                        <i class="mr-2" 
                           :class="action === 'approve' ? 'fas fa-check' : action === 'reject' ? 'fas fa-times' : 'fas fa-undo'"></i>
                        <span x-text="action === 'approve' ? 'Setujui' : action === 'reject' ? 'Tolak' : 'Kembalikan'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function openLoanModal(loanId, action, bookTitle, userName) {
    window.dispatchEvent(new CustomEvent('open-loan-action-modal', {
        detail: { loanId, action, bookTitle, userName }
    }));
}

document.addEventListener('DOMContentLoaded', function() {
    // Auto refresh pending loans every 30 seconds
    if (window.location.search.includes('status=pending') || !window.location.search) {
        setInterval(function() {
            location.reload();
        }, 30000);
    }
});
</script>
<?= $this->endSection() ?> 