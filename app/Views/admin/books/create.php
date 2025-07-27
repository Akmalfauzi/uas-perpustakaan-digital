<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center">
        <a href="/admin/books" class="text-gray-500 hover:text-gray-700 mr-4">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Tambah Buku Baru</h2>
            <p class="text-gray-600 mt-1">Add a new book to the digital library</p>
        </div>
    </div>
</div>

<!-- Create Form -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
    <!-- Validation Errors -->
    <?php if (isset($validation)): ?>
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <div class="flex items-start">
                <i class="fas fa-exclamation-triangle text-red-600 mr-2 mt-0.5"></i>
                <div>
                    <h4 class="text-red-800 font-medium">Terjadi kesalahan:</h4>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        <?php foreach ($validation->getErrors() as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif ?>

    <form action="/admin/books/create" method="post" enctype="multipart/form-data" class="space-y-6">
        <?= csrf_field() ?>
        
        <!-- Basic Information -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Dasar</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-book mr-2 text-primary-600"></i>Judul Buku
                    </label>
                    <input 
                        type="text" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                        id="title" 
                        name="title" 
                        value="<?= esc(old('title')) ?>"
                        placeholder="Masukkan judul buku"
                        required
                    >
                </div>

                <!-- Author -->
                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user-edit mr-2 text-primary-600"></i>Penulis
                    </label>
                    <input 
                        type="text" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                        id="author" 
                        name="author" 
                        value="<?= esc(old('author')) ?>"
                        placeholder="Nama penulis"
                        required
                    >
                </div>

                <!-- ISBN -->
                <div>
                    <label for="isbn" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-barcode mr-2 text-primary-600"></i>ISBN
                    </label>
                    <input 
                        type="text" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                        id="isbn" 
                        name="isbn" 
                        value="<?= esc(old('isbn')) ?>"
                        placeholder="978-xxx-xxx-xxx-x"
                    >
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-tag mr-2 text-primary-600"></i>Kategori
                    </label>
                    <input 
                        type="text" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                        id="category" 
                        name="category" 
                        value="<?= esc(old('category')) ?>"
                        placeholder="Contoh: Fiction, Science, History"
                        required
                    >
                </div>

                <!-- Publisher -->
                <div>
                    <label for="publisher" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-building mr-2 text-primary-600"></i>Penerbit
                    </label>
                    <input 
                        type="text" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                        id="publisher" 
                        name="publisher" 
                        value="<?= esc(old('publisher')) ?>"
                        placeholder="Nama penerbit"
                    >
                </div>

                <!-- Publication Year -->
                <div>
                    <label for="publication_year" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar mr-2 text-primary-600"></i>Tahun Terbit
                    </label>
                    <input 
                        type="number" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                        id="publication_year" 
                        name="publication_year" 
                        value="<?= esc(old('publication_year')) ?>"
                        min="1800"
                        max="2030"
                        placeholder="<?= date('Y') ?>"
                    >
                </div>

                <!-- Total Pages -->
                <div>
                    <label for="total_pages" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-file-alt mr-2 text-primary-600"></i>Jumlah Halaman
                    </label>
                    <input 
                        type="number" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                        id="total_pages" 
                        name="total_pages" 
                        value="<?= esc(old('total_pages')) ?>"
                        min="1"
                        placeholder="Jumlah halaman"
                    >
                </div>

                <!-- Language -->
                <div>
                    <label for="language" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-language mr-2 text-primary-600"></i>Bahasa
                    </label>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" id="language" name="language">
                        <option value="Indonesian" <?= old('language') === 'Indonesian' ? 'selected' : '' ?>>Bahasa Indonesia</option>
                        <option value="English" <?= old('language') === 'English' ? 'selected' : '' ?>>English</option>
                        <option value="Other" <?= old('language') === 'Other' ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-align-left mr-2 text-primary-600"></i>Deskripsi
            </label>
            <textarea 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                id="description" 
                name="description" 
                rows="4"
                placeholder="Deskripsi singkat tentang buku..."
            ><?= esc(old('description')) ?></textarea>
        </div>

        <!-- Status -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Buku</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-flag mr-2 text-primary-600"></i>Status
                    </label>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" id="status" name="status">
                        <option value="available" <?= old('status') === 'available' ? 'selected' : '' ?>>Tersedia</option>
                        <option value="borrowed" <?= old('status') === 'borrowed' ? 'selected' : '' ?>>Dipinjam</option>
                        <option value="maintenance" <?= old('status') === 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Files -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">File Buku</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Cover Image -->
                <div>
                    <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-image mr-2 text-primary-600"></i>Cover Buku
                    </label>
                    <input 
                        type="file" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                        id="cover_image" 
                        name="cover_image" 
                        accept="image/*"
                    >
                    <p class="mt-2 text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Format: JPG, PNG, maksimal 5MB
                    </p>
                </div>

                <!-- Book File -->
                <div>
                    <label for="file_path" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-file-pdf mr-2 text-primary-600"></i>File Buku (PDF)
                    </label>
                    <input 
                        type="file" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                        id="file_path" 
                        name="file_path" 
                        accept=".pdf"
                    >
                    <p class="mt-2 text-sm text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Format: PDF, maksimal 50MB
                    </p>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <i class="fas fa-lightbulb text-blue-600 mr-2 mt-0.5"></i>
                <div>
                    <h4 class="text-blue-800 font-medium">Tips untuk menambah buku:</h4>
                    <ul class="mt-2 text-sm text-blue-700 list-disc list-inside">
                        <li>Pastikan cover buku jelas dan menarik</li>
                        <li>Gunakan kategori yang konsisten untuk memudahkan pencarian</li>
                        <li>File PDF harus readable dan tidak terproteksi password</li>
                        <li>Isi deskripsi yang informatif untuk menarik pembaca</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="/admin/books" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition duration-200">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
            <button type="submit" class="px-6 py-3 bg-primary-600 text-white rounded-lg font-semibold hover:bg-primary-700 transition duration-200">
                <i class="fas fa-plus mr-2"></i>Tambah Buku
            </button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // File upload preview and validation
    const coverInput = document.getElementById('cover_image');
    const fileInput = document.getElementById('file_path');
    
    coverInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file size (5MB = 5 * 1024 * 1024 bytes)
            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file cover terlalu besar. Maksimal 5MB.');
                this.value = '';
                return;
            }
            
            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('File harus berupa gambar (JPG, PNG, dll).');
                this.value = '';
                return;
            }
            
            console.log('Cover selected:', file.name, (file.size / 1024 / 1024).toFixed(2) + ' MB');
        }
    });
    
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file size (50MB = 50 * 1024 * 1024 bytes)
            if (file.size > 50 * 1024 * 1024) {
                alert('Ukuran file PDF terlalu besar. Maksimal 50MB.');
                this.value = '';
                return;
            }
            
            // Validate file type
            if (file.type !== 'application/pdf') {
                alert('File harus berupa PDF.');
                this.value = '';
                return;
            }
            
            console.log('PDF selected:', file.name, (file.size / 1024 / 1024).toFixed(2) + ' MB');
        }
    });

    // Auto-generate category suggestions
    const categoryInput = document.getElementById('category');
    const categories = ['Fiction', 'Non-Fiction', 'Science', 'Technology', 'History', 'Biography', 'Education', 'Religion', 'Art', 'Health'];
    
    // You could implement autocomplete here if needed
});
</script>
<?= $this->endSection() ?> 