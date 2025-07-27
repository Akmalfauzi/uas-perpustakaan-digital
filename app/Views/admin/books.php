<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Page Header -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Kelola Buku</h2>
            <p class="text-gray-600 mt-1">Manage all books in the digital library</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="/admin/books/new" class="bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition duration-200 inline-flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Tambah Buku Baru
            </a>
        </div>
    </div>
</div>

<!-- Search and Filters -->
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 mb-6">
    <form method="GET" action="/admin/books" class="grid grid-cols-1 md:grid-cols-12 gap-4">
        <div class="md:col-span-5">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-search mr-1"></i>Cari Buku
            </label>
            <input 
                type="text" 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                id="search" 
                name="search" 
                placeholder="Cari berdasarkan judul, penulis, atau deskripsi..."
                value="<?= esc($search ?? '') ?>"
            >
        </div>
        <div class="md:col-span-3">
            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-filter mr-1"></i>Kategori
            </label>
            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" id="category" name="category">
                <option value="">Semua Kategori</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= esc($cat) ?>" <?= ($category ?? '') === $cat ? 'selected' : '' ?>>
                        <?= esc($cat) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="md:col-span-2">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-flag mr-1"></i>Status
            </label>
            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" id="status" name="status">
                <option value="">Semua Status</option>
                <option value="available" <?= ($status ?? '') === 'available' ? 'selected' : '' ?>>Tersedia</option>
                <option value="borrowed" <?= ($status ?? '') === 'borrowed' ? 'selected' : '' ?>>Dipinjam</option>
                <option value="maintenance" <?= ($status ?? '') === 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
            </select>
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
            <button type="submit" class="w-full bg-primary-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-primary-700 transition duration-200">
                <i class="fas fa-search mr-1"></i>Cari
            </button>
        </div>
    </form>
</div>

<!-- Results Summary -->
<?php if ($search || $category || $status): ?>
<div class="mb-6">
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-center justify-between">
            <span class="text-blue-800">
                <i class="fas fa-info-circle mr-2"></i>
                Filter aktif:
                <?php if ($search): ?>
                    <strong>"<?= esc($search) ?>"</strong>
                <?php endif; ?>
                <?php if ($category): ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 ml-2"><?= esc($category) ?></span>
                <?php endif; ?>
                <?php if ($status): ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 ml-2"><?= esc($status) ?></span>
                <?php endif; ?>
            </span>
            <a href="/admin/books" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                <i class="fas fa-times mr-1"></i>Hapus Filter
            </a>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Books Table -->
<?php if (!empty($books) && is_array($books)): ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Buku
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Kategori
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Download
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Dibuat
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($books as $book): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-16 w-12">
                                <?php if ($book['cover_image']): ?>
                                    <img class="h-16 w-12 object-cover rounded" src="/<?= esc($book['cover_image']) ?>" alt="<?= esc($book['title']) ?>">
                                <?php else: ?>
                                    <div class="h-16 w-12 bg-gray-200 rounded flex items-center justify-center">
                                        <i class="fas fa-book text-gray-400"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    <?= esc($book['title']) ?>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-user mr-1"></i><?= esc($book['author']) ?>
                                </div>
                                <?php if ($book['publication_year']): ?>
                                <div class="text-xs text-gray-400">
                                    <i class="fas fa-calendar mr-1"></i><?= esc($book['publication_year']) ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            <i class="fas fa-tag mr-1"></i><?= esc($book['category']) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php if ($book['status'] === 'available'): ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>Tersedia
                            </span>
                        <?php elseif ($book['status'] === 'borrowed'): ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-1"></i>Dipinjam
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <i class="fas fa-wrench mr-1"></i>Maintenance
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        <i class="fas fa-download mr-1 text-gray-400"></i>
                        <?= number_format($book['download_count']) ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?= date('d M Y', strtotime($book['created_at'])) ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="/books/<?= $book['id'] ?>" class="text-blue-600 hover:text-blue-900" title="Lihat">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="/admin/books/<?= $book['id'] ?>/edit" class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="confirmDelete(<?= $book['id'] ?>, '<?= esc($book['title']) ?>')" class="text-red-600 hover:text-red-900" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<?php if (isset($pager)): ?>
<div class="mt-6">
    <?= $pager->links('default', 'custom_full') ?>
</div>
<?php endif; ?>

<?php else: ?>
<!-- Empty State -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
    <i class="fas fa-book-open text-4xl text-gray-400 mb-4"></i>
    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada buku ditemukan</h3>
    <p class="text-gray-500 mb-6">
        <?php if ($search || $category || $status): ?>
            Coba ubah filter pencarian Anda.
        <?php else: ?>
            Belum ada buku dalam sistem. Tambahkan buku pertama!
        <?php endif; ?>
    </p>
    <a href="/admin/books/new" class="bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition duration-200 inline-flex items-center">
        <i class="fas fa-plus mr-2"></i>
        Tambah Buku Baru
    </a>
</div>
<?php endif; ?>

<!-- Delete Confirmation Modal -->
<div class="fixed inset-0 z-50 hidden" id="deleteModal" aria-hidden="true">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black opacity-50" onclick="closeDeleteModal()"></div>
        <div class="relative bg-white rounded-xl shadow-xl max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h5 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeDeleteModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mb-6">
                <p class="text-gray-700">Apakah Anda yakin ingin menghapus buku <strong id="bookTitle"></strong>?</p>
                <p class="text-gray-500 text-sm mt-2">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50" onclick="closeDeleteModal()">Batal</button>
                <form id="deleteForm" method="POST" class="inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700">
                        <i class="fas fa-trash mr-2"></i>
                        Hapus Buku
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function confirmDelete(bookId, bookTitle) {
    if (!bookId || !bookTitle) {
        alert('Error: Data buku tidak valid');
        return;
    }
    
    document.getElementById('bookTitle').textContent = bookTitle;
    document.getElementById('deleteForm').action = '/admin/books/' + bookId + '/delete';
    
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('hidden');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function() {
    // Delete form submission handling for better error feedback
    const deleteForm = document.getElementById('deleteForm');
    if (deleteForm) {
        deleteForm.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menghapus...';
            }
        });
    }

    // Auto-submit form on filter change
    const categorySelect = document.getElementById('category');
    const statusSelect = document.getElementById('status');
    
    if (categorySelect) {
        categorySelect.addEventListener('change', function() {
            this.form.submit();
        });
    }
    
    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDeleteModal();
        }
    });
});
</script>
<?= $this->endSection() ?> 