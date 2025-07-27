<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="d-flex align-items-center mb-4">
                <a href="/books" class="btn btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left me-1"></i>
                    Kembali
                </a>
                <h1 class="page-title mb-0">
                    <i class="fas fa-plus-circle me-2" style="color: var(--primary-color);"></i>
                    Tambah Buku Baru
                </h1>
            </div>

            <!-- Form Card -->
            <div class="form-card">
                <!-- Validation Errors -->
                <?php if (isset($validation) && $validation): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach ($validation as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>

                <form action="/books/create" method="post" enctype="multipart/form-data" id="bookForm">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-8">
                            <!-- Basic Information -->
                            <div class="form-section">
                                <h5 class="section-title">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Informasi Dasar
                                </h5>
                                
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="title" class="form-label required">
                                            <i class="fas fa-book me-1"></i>
                                            Judul Buku
                                        </label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="title" 
                                            name="title" 
                                            placeholder="Masukkan judul buku"
                                            value="<?= old('title') ?>"
                                            required
                                        >
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="author" class="form-label required">
                                            <i class="fas fa-user me-1"></i>
                                            Penulis
                                        </label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="author" 
                                            name="author" 
                                            placeholder="Nama penulis"
                                            value="<?= old('author') ?>"
                                            required
                                        >
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="category" class="form-label required">
                                            <i class="fas fa-tag me-1"></i>
                                            Kategori
                                        </label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="category" 
                                            name="category" 
                                            placeholder="Contoh: Fiksi, Sains, Teknologi"
                                            value="<?= old('category') ?>"
                                            required
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- Publication Details -->
                            <div class="form-section">
                                <h5 class="section-title">
                                    <i class="fas fa-building me-2"></i>
                                    Detail Publikasi
                                </h5>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="publisher" class="form-label">
                                            <i class="fas fa-industry me-1"></i>
                                            Penerbit
                                        </label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="publisher" 
                                            name="publisher" 
                                            placeholder="Nama penerbit"
                                            value="<?= old('publisher') ?>"
                                        >
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="publication_year" class="form-label">
                                            <i class="fas fa-calendar me-1"></i>
                                            Tahun Terbit
                                        </label>
                                        <input 
                                            type="number" 
                                            class="form-control" 
                                            id="publication_year" 
                                            name="publication_year" 
                                            placeholder="<?= date('Y') ?>"
                                            min="1800"
                                            max="<?= date('Y') ?>"
                                            value="<?= old('publication_year') ?>"
                                        >
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="isbn" class="form-label">
                                            <i class="fas fa-barcode me-1"></i>
                                            ISBN
                                        </label>
                                        <input 
                                            type="text" 
                                            class="form-control" 
                                            id="isbn" 
                                            name="isbn" 
                                            placeholder="978-3-16-148410-0"
                                            value="<?= old('isbn') ?>"
                                        >
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="total_pages" class="form-label">
                                            <i class="fas fa-file-alt me-1"></i>
                                            Jumlah Halaman
                                        </label>
                                        <input 
                                            type="number" 
                                            class="form-control" 
                                            id="total_pages" 
                                            name="total_pages" 
                                            placeholder="0"
                                            min="1"
                                            value="<?= old('total_pages') ?>"
                                        >
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="form-section">
                                <h5 class="section-title">
                                    <i class="fas fa-cogs me-2"></i>
                                    Informasi Tambahan
                                </h5>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="language" class="form-label">
                                            <i class="fas fa-language me-1"></i>
                                            Bahasa
                                        </label>
                                        <select class="form-select" id="language" name="language">
                                            <option value="Indonesian" <?= old('language') === 'Indonesian' ? 'selected' : '' ?>>Indonesia</option>
                                            <option value="English" <?= old('language') === 'English' ? 'selected' : '' ?>>English</option>
                                            <option value="Other" <?= old('language') === 'Other' ? 'selected' : '' ?>>Lainnya</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Status
                                        </label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="available" <?= old('status') === 'available' ? 'selected' : '' ?>>Tersedia</option>
                                            <option value="borrowed" <?= old('status') === 'borrowed' ? 'selected' : '' ?>>Dipinjam</option>
                                            <option value="maintenance" <?= old('status') === 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">
                                        <i class="fas fa-align-left me-1"></i>
                                        Deskripsi
                                    </label>
                                    <textarea 
                                        class="form-control" 
                                        id="description" 
                                        name="description" 
                                        rows="4"
                                        placeholder="Tulis deskripsi singkat tentang buku ini..."
                                    ><?= old('description') ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-4">
                            <!-- File Uploads -->
                            <div class="form-section">
                                <h5 class="section-title">
                                    <i class="fas fa-upload me-2"></i>
                                    File Upload
                                </h5>
                                
                                <!-- Cover Image -->
                                <div class="mb-4">
                                    <label for="cover_image" class="form-label">
                                        <i class="fas fa-image me-1"></i>
                                        Cover Buku
                                    </label>
                                    <div class="upload-area" id="coverUploadArea">
                                        <input 
                                            type="file" 
                                            class="form-control d-none" 
                                            id="cover_image" 
                                            name="cover_image" 
                                            accept="image/*"
                                        >
                                        <div class="upload-placeholder">
                                            <i class="fas fa-image fa-3x mb-3"></i>
                                            <p class="mb-2"><strong>Klik untuk upload cover</strong></p>
                                            <small class="text-muted">JPG, PNG maksimal 5MB</small>
                                        </div>
                                        <div class="upload-preview d-none">
                                            <img id="coverPreview" src="" alt="Cover Preview" class="img-fluid">
                                            <button type="button" class="btn btn-sm btn-danger upload-remove">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Book File -->
                                <div class="mb-3">
                                    <label for="file_path" class="form-label">
                                        <i class="fas fa-file-pdf me-1"></i>
                                        File Buku
                                    </label>
                                    <div class="upload-area" id="fileUploadArea">
                                        <input 
                                            type="file" 
                                            class="form-control d-none" 
                                            id="file_path" 
                                            name="file_path" 
                                            accept=".pdf,.epub,.mobi"
                                        >
                                        <div class="upload-placeholder">
                                            <i class="fas fa-file-pdf fa-3x mb-3"></i>
                                            <p class="mb-2"><strong>Klik untuk upload file buku</strong></p>
                                            <small class="text-muted">PDF, EPUB, MOBI maksimal 50MB</small>
                                        </div>
                                        <div class="upload-info d-none">
                                            <div class="text-center">
                                                <i class="fas fa-file-alt fa-2x mb-2"></i>
                                                <p class="mb-1" id="fileName"></p>
                                                <small class="text-muted" id="fileSize"></small>
                                                <button type="button" class="btn btn-sm btn-danger d-block mx-auto mt-2 upload-remove">
                                                    <i class="fas fa-times me-1"></i>Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <hr class="my-4">
                        <div class="d-flex justify-content-between">
                            <a href="/books" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-save me-1"></i>
                                Simpan Buku
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .page-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .form-card {
        background: white;
        padding: 2.5rem;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--light-accent);
    }
    
    .form-section {
        margin-bottom: 2.5rem;
    }
    
    .section-title {
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--light-accent);
    }
    
    .form-label.required::after {
        content: ' *';
        color: var(--danger-color);
    }
    
    .upload-area {
        border: 2px dashed var(--light-accent);
        border-radius: 10px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }
    
    .upload-area:hover {
        border-color: var(--secondary-color);
        background: rgba(220, 208, 168, 0.1);
    }
    
    .upload-placeholder {
        color: var(--secondary-color);
    }
    
    .upload-preview {
        position: relative;
    }
    
    .upload-preview img {
        max-height: 200px;
        border-radius: 8px;
    }
    
    .upload-remove {
        position: absolute;
        top: -10px;
        right: -10px;
        border-radius: 50%;
    }
    
    .upload-info {
        color: var(--secondary-color);
    }
    
    .form-actions {
        background: rgba(220, 208, 168, 0.1);
        margin: 0 -2.5rem -2.5rem;
        padding: 1.5rem 2.5rem;
        border-radius: 0 0 15px 15px;
    }
    
    @media (max-width: 768px) {
        .form-card {
            padding: 1.5rem;
            margin: 0 -15px;
        }
        
        .form-actions {
            margin: 0 -1.5rem -1.5rem;
            padding: 1rem 1.5rem;
        }
        
        .upload-area {
            padding: 1.5rem;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Cover image upload
    const coverInput = document.getElementById('cover_image');
    const coverArea = document.getElementById('coverUploadArea');
    const coverPreview = document.getElementById('coverPreview');
    
    coverArea.addEventListener('click', () => coverInput.click());
    
    coverInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file cover maksimal 5MB');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                coverPreview.src = e.target.result;
                coverArea.querySelector('.upload-placeholder').classList.add('d-none');
                coverArea.querySelector('.upload-preview').classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Book file upload
    const fileInput = document.getElementById('file_path');
    const fileArea = document.getElementById('fileUploadArea');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    
    fileArea.addEventListener('click', () => fileInput.click());
    
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 50 * 1024 * 1024) {
                alert('Ukuran file buku maksimal 50MB');
                return;
            }
            
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            fileArea.querySelector('.upload-placeholder').classList.add('d-none');
            fileArea.querySelector('.upload-info').classList.remove('d-none');
        }
    });
    
    // Remove upload handlers
    document.querySelectorAll('.upload-remove').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            
            const uploadArea = this.closest('.upload-area');
            const input = uploadArea.querySelector('input[type="file"]');
            
            input.value = '';
            uploadArea.querySelector('.upload-placeholder').classList.remove('d-none');
            uploadArea.querySelector('.upload-preview, .upload-info').forEach(el => {
                if (el) el.classList.add('d-none');
            });
        });
    });
    
    // Form submission
    document.getElementById('bookForm').addEventListener('submit', function() {
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';
    });
    
    // Auto-suggest categories (could be enhanced with AJAX)
    const categoryInput = document.getElementById('category');
    const commonCategories = [
        'Fiksi', 'Non-Fiksi', 'Sains', 'Teknologi', 'Sejarah', 
        'Biografi', 'Pendidikan', 'Bisnis', 'Kesehatan', 'Agama'
    ];
    
    // Helper function
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
});
</script>
<?= $this->endSection() ?> 