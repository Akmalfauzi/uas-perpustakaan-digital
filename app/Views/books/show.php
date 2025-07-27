<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-8" aria-label="breadcrumb">
        <div class="bg-white px-6 py-3 rounded-lg shadow-sm border border-gray-200">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="/" class="text-gray-600 hover:text-primary-600 transition duration-200">
                        <i class="fas fa-home mr-1"></i>Beranda
                    </a>
                </li>
                <li class="text-gray-400">
                    <i class="fas fa-chevron-right mx-2"></i>
                </li>
                <li>
                    <a href="/books" class="text-gray-600 hover:text-primary-600 transition duration-200">
                        Koleksi Buku
                    </a>
                </li>
                <li class="text-gray-400">
                    <i class="fas fa-chevron-right mx-2"></i>
                </li>
                <li class="text-primary-600 font-medium">
                    <?= esc($book['title']) ?>
                </li>
            </ol>
        </div>
    </nav>
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Book Cover & Actions -->
        <div class="lg:col-span-4">
            <div class="sticky top-8">
                <!-- Book Cover -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-6">
                    <div class="text-center">
                        <?php if ($book['cover_image']): ?>
                            <img 
                                src="/<?= esc($book['cover_image']) ?>" 
                                alt="<?= esc($book['title']) ?>" 
                                class="mx-auto max-h-96 w-auto rounded-lg shadow-lg"
                            >
                        <?php else: ?>
                            <div class="h-96 flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg">
                                <i class="fas fa-book text-6xl text-gray-400"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="space-y-3">
                    <?php if (session()->get('userId')): ?>
                        <!-- Download Button - Available for all logged in users -->
                        <?php if ($book['file_path']): ?>
                            <a href="/books/<?= $book['id'] ?>/download" 
                               class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-4 rounded-lg font-semibold hover:from-green-600 hover:to-green-700 transition-all duration-200 flex items-center justify-center text-lg shadow-sm group"
                               onclick="return confirm('Apakah Anda yakin ingin mendownload buku ini?')">
                                <i class="fas fa-download mr-3 group-hover:animate-bounce"></i>
                                Download Buku
                            </a>
                        <?php endif; ?>
                        
                        <!-- Loan Status and Actions -->
                        <?php if ($userLoanStatus === 'pending'): ?>
                            <div class="w-full bg-yellow-100 border-2 border-yellow-300 text-yellow-800 px-6 py-4 rounded-lg font-semibold text-center">
                                <i class="fas fa-clock mr-3"></i>
                                Permintaan Peminjaman Pending
                            </div>
                        <?php elseif ($userLoanStatus === 'active'): ?>
                            <div class="w-full bg-green-100 border-2 border-green-300 text-green-800 px-6 py-4 rounded-lg font-semibold text-center">
                                <i class="fas fa-check-circle mr-3"></i>
                                Sedang Anda Pinjam
                            </div>
                        <?php elseif ($book['status'] === 'available'): ?>
                            <button 
                                onclick="openLoanModal()" 
                                class="w-full bg-primary-600 text-white px-6 py-4 rounded-lg font-semibold hover:bg-primary-700 transition duration-200 flex items-center justify-center text-lg shadow-sm"
                            >
                                <i class="fas fa-hand-holding mr-3"></i>
                                Pinjam Buku
                            </button>
                        <?php else: ?>
                            <div class="w-full bg-gray-100 border-2 border-gray-300 text-gray-600 px-6 py-4 rounded-lg font-semibold text-center">
                                <i class="fas fa-times-circle mr-3"></i>
                                Buku Tidak Tersedia
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <a 
                            href="/login" 
                            class="w-full bg-primary-600 text-white px-6 py-4 rounded-lg font-semibold hover:bg-primary-700 transition duration-200 flex items-center justify-center text-lg shadow-sm"
                        >
                            <i class="fas fa-sign-in-alt mr-3"></i>
                            Login untuk Meminjam
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Book Information -->
        <div class="lg:col-span-8">
            <!-- Book Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-4 leading-tight">
                    <?= esc($book['title']) ?>
                </h1>
                
                <p class="text-xl text-gray-600 mb-4">
                    <i class="fas fa-user mr-2 text-primary-600"></i>
                    oleh <span class="font-semibold text-gray-800"><?= esc($book['author']) ?></span>
                </p>
                
                <!-- Status Badge -->
                <div class="mb-6">
                    <?php if ($book['status'] === 'available'): ?>
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <i class="fas fa-check-circle mr-2"></i>
                            Tersedia
                        </span>
                    <?php elseif ($book['status'] === 'borrowed'): ?>
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-clock mr-2"></i>
                            Dipinjam
                        </span>
                    <?php else: ?>
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            <i class="fas fa-tools mr-2"></i>
                            Maintenance
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Book Stats -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-chart-bar mr-2 text-primary-600"></i>
                    Statistik Buku
                </h3>
                
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-download text-blue-600"></i>
                        </div>
                        <div class="text-2xl font-bold text-gray-900"><?= number_format($book['download_count']) ?></div>
                        <div class="text-sm text-gray-600">Download</div>
                    </div>
                    
                    <?php if ($book['rating'] > 0): ?>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-star text-yellow-600"></i>
                        </div>
                        <div class="text-2xl font-bold text-gray-900"><?= number_format($book['rating'], 1) ?></div>
                        <div class="text-sm text-gray-600">Rating</div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($book['total_pages']): ?>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-file-alt text-green-600"></i>
                        </div>
                        <div class="text-2xl font-bold text-gray-900"><?= number_format($book['total_pages']) ?></div>
                        <div class="text-sm text-gray-600">Halaman</div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="text-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-language text-purple-600"></i>
                        </div>
                        <div class="text-lg font-semibold text-gray-900"><?= esc($book['language']) ?></div>
                        <div class="text-sm text-gray-600">Bahasa</div>
                    </div>
                </div>
            </div>
            
            <!-- Book Details -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-info-circle mr-2 text-primary-600"></i>
                    Detail Buku
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-tag mr-3 w-5"></i>
                            <span class="font-medium">Kategori</span>
                        </div>
                        <div>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-800">
                                <?= esc($book['category']) ?>
                            </span>
                        </div>
                    </div>
                    
                    <?php if ($book['publisher']): ?>
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-building mr-3 w-5"></i>
                            <span class="font-medium">Penerbit</span>
                        </div>
                        <div class="text-gray-900 font-medium"><?= esc($book['publisher']) ?></div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($book['publication_year']): ?>
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-calendar mr-3 w-5"></i>
                            <span class="font-medium">Tahun Terbit</span>
                        </div>
                        <div class="text-gray-900 font-medium"><?= esc($book['publication_year']) ?></div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($book['isbn']): ?>
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-barcode mr-3 w-5"></i>
                            <span class="font-medium">ISBN</span>
                        </div>
                        <div class="text-gray-900 font-mono"><?= esc($book['isbn']) ?></div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-plus-circle mr-3 w-5"></i>
                            <span class="font-medium">Ditambahkan</span>
                        </div>
                        <div class="text-gray-900 font-medium"><?= date('d M Y', strtotime($book['created_at'])) ?></div>
                    </div>
                    
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-edit mr-3 w-5"></i>
                            <span class="font-medium">Diperbarui</span>
                        </div>
                        <div class="text-gray-900 font-medium"><?= date('d M Y', strtotime($book['updated_at'])) ?></div>
                    </div>
                </div>
            </div>
            
            <!-- Description -->
            <?php if ($book['description']): ?>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    <i class="fas fa-align-left mr-2 text-primary-600"></i>
                    Deskripsi
                </h3>
                
                <div class="prose prose-gray max-w-none">
                    <p class="text-gray-700 leading-relaxed text-base">
                        <?= nl2br(esc($book['description'])) ?>
                    </p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Loan Request Modal -->
<div x-data="{ open: false }" x-show="open" x-on:open-loan-modal.window="open = true" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="open = false"></div>

        <!-- Modal panel -->
        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
            <div class="flex items-center mb-4">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-primary-100 rounded-full">
                    <i class="fas fa-hand-holding text-primary-600"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-gray-900">Pinjam Buku</h3>
                    <p class="text-sm text-gray-500"><?= esc($book['title']) ?></p>
                </div>
            </div>
            
            <form id="loanRequestForm" class="space-y-4">
                <?= csrf_field() ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="requestedStartDate" class="block text-sm font-medium text-gray-700 mb-2">
                            Dari Tanggal <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="date" 
                            id="requestedStartDate" 
                            name="requested_start_date" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                            required
                        >
                        <p class="text-xs text-gray-500 mt-1">Tanggal mulai peminjaman</p>
                    </div>
                    
                    <div>
                        <label for="requestedEndDate" class="block text-sm font-medium text-gray-700 mb-2">
                            Sampai Tanggal <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="date" 
                            id="requestedEndDate" 
                            name="requested_end_date" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                            required
                        >
                        <p class="text-xs text-gray-500 mt-1">Tanggal akhir peminjaman</p>
                    </div>
                </div>
                
                <div>
                    <label for="loanNotes" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan (Opsional)
                    </label>
                    <textarea 
                        id="loanNotes" 
                        name="notes" 
                        rows="3" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                        placeholder="Tambahkan catatan untuk permintaan peminjaman Anda..."
                    ></textarea>
                </div>
                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-600 mr-2 mt-0.5"></i>
                        <div class="text-sm text-blue-800">
                            <p class="font-medium">Ketentuan Peminjaman:</p>
                            <ul class="mt-2 list-disc list-inside space-y-1">
                                <li>Pilih rentang tanggal peminjaman yang diinginkan</li>
                                <li>Bisa pilih hari yang sama untuk peminjaman singkat</li>
                                <li>Maksimal masa peminjaman: 30 hari</li>
                                <li>Tanggal mulai minimal hari ini</li>
                                <li>Permintaan akan diproses oleh admin sesuai jadwal yang dipilih</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" @click="open = false" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition duration-200">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition duration-200">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim Permintaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
 
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function openLoanModal() {
    window.dispatchEvent(new CustomEvent('open-loan-modal'));
}

document.addEventListener('DOMContentLoaded', function() {
    // Set default and max date for loan request
    const requestedStartDate = document.getElementById('requestedStartDate');
    const requestedEndDate = document.getElementById('requestedEndDate');
    
    if (requestedStartDate && requestedEndDate) {
        const now = new Date();
        
        // Set default start date to today
        const today = new Date();
        const todayString = today.toISOString().slice(0, 10);
        requestedStartDate.value = todayString;
        
        // Set default end date to 7 days after start date
        const defaultEndDate = new Date(today.getTime() + (7 * 24 * 60 * 60 * 1000));
        requestedEndDate.value = defaultEndDate.toISOString().slice(0, 10);
        
        // Set min date to today for start date
        requestedStartDate.min = todayString;
        
        // Update end date min when start date changes
        requestedStartDate.addEventListener('change', function() {
            const startDate = new Date(this.value);
            // Allow same day selection
            requestedEndDate.min = this.value;
            
            // If end date is before start date, update it
            if (requestedEndDate.value && requestedEndDate.value < this.value) {
                requestedEndDate.value = this.value;
            }
        });
    }

    // Loan request form submission
    const loanForm = document.getElementById('loanRequestForm');
    if (loanForm) {
        loanForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate dates
            const startDateInput = this.querySelector('#requestedStartDate');
            const endDateInput = this.querySelector('#requestedEndDate');
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0); // Reset to start of day
            
            // Reset start and end dates to start of day for comparison
            const startDateOnly = new Date(startDate);
            startDateOnly.setHours(0, 0, 0, 0);
            const endDateOnly = new Date(endDate);
            endDateOnly.setHours(0, 0, 0, 0);
            
            if (startDateOnly < today) {
                alert('Tanggal mulai peminjaman tidak boleh di masa lalu.');
                return;
            }
            
            if (endDateOnly < startDateOnly) {
                alert('Tanggal akhir peminjaman tidak boleh sebelum tanggal mulai.');
                return;
            }
            
            // Check maximum loan duration (30 days)
            const daysDiff = Math.ceil((endDateOnly - startDateOnly) / (1000 * 60 * 60 * 24));
            if (daysDiff > 30) {
                alert('Maksimal masa peminjaman adalah 30 hari.');
                return;
            }
            
            const formData = new FormData(this);
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
            submitBtn.disabled = true;
            
            fetch('/books/<?= $book['id'] ?>/request-loan', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal
                    window.dispatchEvent(new CustomEvent('close-loan-modal'));
                    
                    // Show success message and reload page
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            })
            .finally(() => {
                // Restore button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    }
});
</script>
<?= $this->endSection() ?> 