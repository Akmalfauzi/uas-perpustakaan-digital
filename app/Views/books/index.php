<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="page-title text-3xl lg:text-4xl font-bold text-primary-600">
            <i class="fas fa-books mr-2"></i>
            Koleksi Buku Digital
        </h1>
    </div>

    <!-- Search and Filter Section -->
    <div class="mb-8">
        <div class="search-filter-card bg-white p-6 lg:p-8 rounded-2xl shadow-lg border border-secondary-200">
            <form method="GET" action="/books" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-6">
                    <label for="search" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-search mr-2 text-primary-600"></i>
                        Cari Buku
                    </label>
                    <input 
                        type="text" 
                        class="w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 bg-cream" 
                        id="search" 
                        name="search" 
                        placeholder="Cari berdasarkan judul, penulis, atau deskripsi..."
                        value="<?= esc($search ?? '') ?>"
                    >
                </div>
                <div class="md:col-span-4">
                    <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-filter mr-2 text-primary-600"></i>
                        Kategori
                    </label>
                    <select class="w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 bg-cream" id="category" name="category">
                        <option value="">Semua Kategori</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= esc($cat) ?>" <?= ($category ?? '') === $cat ? 'selected' : '' ?>>
                                <?= esc($cat) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">&nbsp;</label>
                    <button type="submit" class="w-full bg-primary-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-primary-700 transition duration-200">
                        <i class="fas fa-search mr-1"></i>
                        Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Summary -->
    <?php if ($search || $category): ?>
    <div class="mb-6">
        <div class="results-summary p-4 bg-secondary-100 rounded-lg border-l-4 border-secondary-500">
            <span class="text-gray-600">
                <i class="fas fa-info-circle mr-2"></i>
                Menampilkan hasil untuk:
                <?php if ($search): ?>
                    <strong>"<?= esc($search) ?>"</strong>
                <?php endif; ?>
                <?php if ($category): ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary-500 text-white ml-2"><?= esc($category) ?></span>
                <?php endif; ?>
            </span>
            <a href="/books" class="ml-4 text-sm border border-gray-300 text-gray-700 px-3 py-1 rounded-md hover:bg-gray-50 transition duration-200 inline-flex items-center">
                <i class="fas fa-times mr-1"></i>
                Hapus Filter
            </a>
        </div>
    </div>
    <?php endif; ?>

    <!-- Books Grid -->
    <?php if (!empty($books) && is_array($books)): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php foreach ($books as $book): ?>
        <div class="book-card bg-white rounded-2xl shadow-lg overflow-hidden hover:transform hover:-translate-y-2 hover:shadow-xl transition-all duration-300 relative">
            <div class="book-cover relative h-64 overflow-hidden group">
                <?php if ($book['cover_image']): ?>
                    <img src="/<?= esc($book['cover_image']) ?>" alt="<?= esc($book['title']) ?>" class="w-full h-full object-cover">
                <?php else: ?>
                    <div class="book-placeholder h-full flex items-center justify-center bg-gradient-to-br from-secondary-200 to-cream text-secondary-500">
                        <i class="fas fa-book text-5xl"></i>
                    </div>
                <?php endif; ?>
                
                <div class="book-overlay absolute inset-0 bg-primary-600/90 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="book-actions w-4/5 space-y-2">
                        <a href="/books/<?= $book['id'] ?>" class="block w-full bg-white text-primary-600 py-2 px-4 rounded-lg font-semibold hover:bg-gray-100 transition duration-200 text-center">
                            <i class="fas fa-eye mr-2"></i>Lihat Detail
                        </a>
                        <?php if (session()->get('userId') && $book['file_path']): ?>
                            <a href="/books/<?= $book['id'] ?>/download" 
                               class="block w-full bg-green-500 text-white py-2 px-4 rounded-lg font-semibold hover:bg-green-600 transition duration-200 text-center"
                               onclick="return confirm('Download buku ini?')">
                                <i class="fas fa-download mr-2"></i>Download
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Status Badge -->
                <div class="book-status absolute top-2 right-2 z-10">
                    <?php if ($book['status'] === 'available'): ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Tersedia</span>
                    <?php elseif ($book['status'] === 'borrowed'): ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Dipinjam</span>
                    <?php else: ?>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Maintenance</span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="book-info p-4">
                <h6 class="book-title font-semibold text-primary-600 mb-2 text-sm leading-tight line-clamp-2" title="<?= esc($book['title']) ?>">
                    <?= esc($book['title']) ?>
                </h6>
                <p class="book-author text-secondary-500 text-xs mb-2 font-medium">
                    <i class="fas fa-user mr-1"></i>
                    <?= esc($book['author']) ?>
                </p>
                <p class="book-category text-secondary-500 text-xs mb-3 font-medium">
                    <i class="fas fa-tag mr-1"></i>
                    <?= esc($book['category']) ?>
                </p>
                
                <div class="book-meta pt-3 border-t border-secondary-200">
                    <div class="flex justify-between items-center">
                        <small class="text-gray-500">
                            <i class="fas fa-download mr-1"></i>
                            <?= number_format($book['download_count']) ?>
                        </small>
                        <?php if ($book['rating'] > 0): ?>
                        <small class="text-yellow-500">
                            <i class="fas fa-star mr-1"></i>
                            <?= number_format($book['rating'], 1) ?>
                        </small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <?php if (isset($pager)): ?>
    <div class="mt-12">
        <?= $pager->links('default', 'custom_full') ?>
    </div>
    <?php endif; ?>

    <?php else: ?>
    <!-- Empty State -->
    <div class="empty-state text-center py-16 bg-white rounded-2xl border-2 border-dashed border-secondary-300 my-8">
        <i class="fas fa-book-open text-6xl text-gray-400 mb-6"></i>
        <h3 class="text-xl font-semibold text-gray-600 mb-4">Tidak ada buku ditemukan</h3>
        <p class="text-gray-500 mb-8 max-w-md mx-auto">
            <?php if ($search || $category): ?>
                Coba ubah kata kunci pencarian atau filter kategori.
            <?php else: ?>
                Belum ada buku dalam koleksi saat ini.
            <?php endif; ?>
        </p>
        <a href="/" class="border border-gray-300 text-gray-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-50 transition duration-200 inline-flex items-center">
            <i class="fas fa-home mr-2"></i>
            Kembali ke Beranda
        </a>
    </div>
    <?php endif; ?>
</div>


<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form on category change
    const categorySelect = document.getElementById('category');
    if (categorySelect) {
        categorySelect.addEventListener('change', function() {
            this.form.submit();
        });
    }
    
    // Search input enhancement
    const searchInput = document.getElementById('search');
    if (searchInput) {
        let timeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                if (this.value.length > 2 || this.value.length === 0) {
                    // Could implement real-time search here
                }
            }, 500);
        });
    }
});
</script>
<?= $this->endSection() ?> 