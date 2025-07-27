<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- Hero Section -->
<section class="hero-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center min-h-[75vh] py-20">
            <div class="lg:w-1/2 w-full">
                <div class="hero-content">
                    <h1 class="text-4xl lg:text-6xl font-bold mb-6 text-primary-600">
                        Selamat Datang di<br>
                        <span class="text-secondary-500">Perpustakaan Digital</span>
                    </h1>
                    <p class="text-xl mb-8 text-gray-600 leading-relaxed">
                        Jelajahi ribuan koleksi buku digital dengan mudah. Temukan pengetahuan baru, 
                        perluas wawasan, dan nikmati kemudahan membaca di era digital.
                    </p>
                    <div class="hero-buttons flex flex-col sm:flex-row gap-4">
                        <a href="/books" class="bg-primary-600 text-white px-8 py-4 rounded-lg font-semibold hover:bg-primary-700 transition duration-200 text-center">
                            <i class="fas fa-book-open mr-2"></i>
                            Jelajahi Koleksi
                        </a>
                        <a href="/login" class="border border-gray-300 text-gray-700 px-8 py-4 rounded-lg font-semibold hover:bg-gray-50 transition duration-200 text-center">
                            <i class="fas fa-user mr-2"></i>
                            Masuk
                        </a>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/2 w-full mt-12 lg:mt-0">
                <div class="hero-image text-center">
                    <i class="fas fa-book-reader hero-icon text-[15rem] text-secondary-600 opacity-80"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="stats-section py-20 bg-gradient-to-br from-secondary-200 to-cream">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="stat-card text-center p-8 bg-white/80 rounded-2xl shadow-lg hover:transform hover:-translate-y-2 transition-all duration-300">
                <div class="stat-icon mb-4">
                    <i class="fas fa-book text-3xl text-primary-600"></i>
                </div>
                <h3 class="stat-number text-4xl font-bold text-primary-600 mb-2"><?= number_format($statistics['total_books']) ?></h3>
                <p class="stat-label text-gray-600 font-medium">Total Buku</p>
            </div>
            <div class="stat-card text-center p-8 bg-white/80 rounded-2xl shadow-lg hover:transform hover:-translate-y-2 transition-all duration-300">
                <div class="stat-icon mb-4">
                    <i class="fas fa-check-circle text-3xl text-secondary-500"></i>
                </div>
                <h3 class="stat-number text-4xl font-bold text-primary-600 mb-2"><?= number_format($statistics['available_books']) ?></h3>
                <p class="stat-label text-gray-600 font-medium">Buku Tersedia</p>
            </div>
            <div class="stat-card text-center p-8 bg-white/80 rounded-2xl shadow-lg hover:transform hover:-translate-y-2 transition-all duration-300">
                <div class="stat-icon mb-4">
                    <i class="fas fa-tags text-3xl text-primary-600"></i>
                </div>
                <h3 class="stat-number text-4xl font-bold text-primary-600 mb-2"><?= number_format($statistics['total_categories']) ?></h3>
                <p class="stat-label text-gray-600 font-medium">Kategori</p>
            </div>
            <div class="stat-card text-center p-8 bg-white/80 rounded-2xl shadow-lg hover:transform hover:-translate-y-2 transition-all duration-300">
                <div class="stat-icon mb-4">
                    <i class="fas fa-download text-3xl text-secondary-500"></i>
                </div>
                <h3 class="stat-number text-4xl font-bold text-primary-600 mb-2"><?= number_format($statistics['total_downloads']) ?></h3>
                <p class="stat-label text-gray-600 font-medium">Download</p>
            </div>
        </div>
    </div>
</section>

<!-- Popular Books Section -->
<?php if (!empty($popularBooks)): ?>
<section class="popular-books py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="section-title text-4xl font-bold text-primary-600 mb-4">
                <i class="fas fa-fire mr-2 text-secondary-500"></i>
                Buku Populer
            </h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach ($popularBooks as $book): ?>
            <div class="book-card h-full bg-white rounded-2xl shadow-lg overflow-hidden hover:transform hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
                <div class="book-cover relative h-48 overflow-hidden group">
                    <?php if ($book['cover_image']): ?>
                        <img src="/<?= esc($book['cover_image']) ?>" alt="<?= esc($book['title']) ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="book-placeholder h-full flex items-center justify-center bg-gradient-to-br from-secondary-200 to-cream text-secondary-500">
                            <i class="fas fa-book text-5xl"></i>
                        </div>
                    <?php endif; ?>
                    <div class="book-overlay absolute inset-0 bg-primary-600/80 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="space-y-2">
                            <a href="/books/<?= $book['id'] ?>" class="block bg-white text-primary-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition duration-200 text-center">
                                <i class="fas fa-eye mr-1"></i>Lihat
                            </a>
                            <?php if (session()->get('userId') && $book['file_path']): ?>
                                <a href="/books/<?= $book['id'] ?>/download" 
                                   class="block bg-green-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-600 transition duration-200 text-center"
                                   onclick="return confirm('Download buku ini?')">
                                    <i class="fas fa-download mr-1"></i>Download
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="book-info p-4">
                    <h6 class="book-title font-semibold text-primary-600 mb-2 text-sm leading-tight line-clamp-2"><?= esc($book['title']) ?></h6>
                    <p class="book-author text-secondary-500 text-xs mb-2 font-medium"><?= esc($book['author']) ?></p>
                    <div class="book-stats">
                        <small class="text-gray-500">
                            <i class="fas fa-download mr-1"></i>
                            <?= number_format($book['download_count']) ?>
                        </small>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-12">
            <a href="/books" class="border border-primary-600 text-primary-600 px-8 py-3 rounded-lg font-semibold hover:bg-primary-600 hover:text-white transition duration-200">
                <i class="fas fa-arrow-right mr-2"></i>
                Lihat Semua Buku
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Recent Books Section -->
<?php if (!empty($recentBooks)): ?>
<section class="recent-books py-20 bg-secondary-100/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="section-title text-4xl font-bold text-primary-600 mb-4">
                <i class="fas fa-clock mr-2 text-primary-600"></i>
                Buku Terbaru
            </h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach ($recentBooks as $book): ?>
            <div class="book-card h-full bg-white rounded-2xl shadow-lg overflow-hidden hover:transform hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
                <div class="book-cover relative h-48 overflow-hidden group">
                    <?php if ($book['cover_image']): ?>
                        <img src="/<?= esc($book['cover_image']) ?>" alt="<?= esc($book['title']) ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="book-placeholder h-full flex items-center justify-center bg-gradient-to-br from-secondary-200 to-cream text-secondary-500">
                            <i class="fas fa-book text-5xl"></i>
                        </div>
                    <?php endif; ?>
                    <div class="book-overlay absolute inset-0 bg-primary-600/80 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="space-y-2">
                            <a href="/books/<?= $book['id'] ?>" class="block bg-white text-primary-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition duration-200 text-center">
                                <i class="fas fa-eye mr-1"></i>Lihat
                            </a>
                            <?php if (session()->get('userId') && $book['file_path']): ?>
                                <a href="/books/<?= $book['id'] ?>/download" 
                                   class="block bg-green-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-600 transition duration-200 text-center"
                                   onclick="return confirm('Download buku ini?')">
                                    <i class="fas fa-download mr-1"></i>Download
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="book-info p-4">
                    <h6 class="book-title font-semibold text-primary-600 mb-2 text-sm leading-tight line-clamp-2"><?= esc($book['title']) ?></h6>
                    <p class="book-author text-secondary-500 text-xs mb-2 font-medium"><?= esc($book['author']) ?></p>
                    <div class="book-meta">
                        <small class="text-gray-500">
                            <i class="fas fa-calendar mr-1"></i>
                            <?= date('d M Y', strtotime($book['created_at'])) ?>
                        </small>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Categories Section -->
<?php if (!empty($categories)): ?>
<section class="categories-section py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="section-title text-4xl font-bold text-primary-600 mb-4">
                <i class="fas fa-list mr-2 text-secondary-500"></i>
                Jelajahi Kategori
            </h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php foreach (array_slice($categories, 0, 8) as $category): ?>
            <a href="/books?category=<?= urlencode($category) ?>" class="category-card flex items-center p-4 bg-white rounded-xl shadow-md hover:shadow-lg text-primary-600 hover:text-secondary-500 hover:transform hover:-translate-y-1 transition-all duration-300 no-underline">
                <div class="category-icon mr-3 text-xl">
                    <i class="fas fa-folder-open"></i>
                </div>
                <span class="category-name font-medium"><?= esc($category) ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA Section -->
<section class="cta-section py-20 bg-gradient-to-r from-primary-600 to-secondary-500 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center text-white">
            <h2 class="text-4xl font-bold mb-6">Mulai Petualangan Membaca Anda</h2>
            <p class="text-xl mb-8 opacity-90 max-w-2xl mx-auto">
                Bergabunglah dengan ribuan pembaca lainnya dan nikmati akses unlimited ke koleksi buku digital kami.
            </p>
            <a href="/books" class="bg-white text-primary-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition duration-200 inline-flex items-center">
                <i class="fas fa-rocket mr-2"></i>
                Mulai Sekarang
            </a>
        </div>
    </div>
    <div class="absolute inset-0 bg-gradient-pattern opacity-10"></div>
</section>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .hero-section {
        padding: 2rem 0;
        background: linear-gradient(135deg, #FFF9E5 0%, rgba(220, 208, 168, 0.3) 100%);
    }
    
    .hero-icon {
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .bg-gradient-pattern {
        background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scrolling for anchor links
    const links = document.querySelectorAll('a[href^="#"]');
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Add animation to stats on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.stat-card').forEach(card => {
        observer.observe(card);
    });
});
</script>
<?= $this->endSection() ?> 