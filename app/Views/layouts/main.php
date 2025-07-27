<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : '' ?><?= isset($siteName) ? $siteName : 'Perpustakaan Digital' ?></title>
    <meta name="description" content="<?= isset($siteDescription) ? $siteDescription : 'Sistem Perpustakaan Digital - Akses koleksi buku digital dengan mudah' ?>">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0fdf9',
                            100: '#cbfdf3',
                            200: '#9df9e8',
                            300: '#65f1d9',
                            400: '#32dfc6',
                            500: '#4A9782',
                            600: '#004030',
                            700: '#003028',
                            800: '#002820',
                            900: '#001a18',
                        },
                        secondary: {
                            50: '#fefefe',
                            100: '#fdfdfd',
                            200: '#fafafa',
                            300: '#f7f7f7',
                            400: '#f0f0f0',
                            500: '#DCD0A8',
                            600: '#c4b896',
                            700: '#a69d7e',
                            800: '#888266',
                            900: '#6b6852',
                        },
                        cream: '#FFF9E5'
                    },
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    
    <?= $this->renderSection('styles') ?>
</head>
<body class="font-inter bg-cream text-gray-800">
        <!-- Navigation -->
    <nav class="bg-primary-600 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-white font-bold text-xl">
                        <i class="fas fa-book-open mr-2"></i>
                        <?= isset($siteName) ? $siteName : 'Perpustakaan Digital' ?>
                    </a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-white hover:text-primary-200 px-3 py-2 rounded-md text-sm font-medium transition duration-150">
                        <i class="fas fa-bars mr-1"></i>Beranda
                    </a>
                    <a href="/books" class="text-white hover:text-primary-200 px-3 py-2 rounded-md text-sm font-medium transition duration-150">
                        <i class="fas fa-book mr-1"></i>Buku
                    </a>
                    
                    <?php if (session()->get('isLoggedIn')): ?>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="text-white hover:text-primary-200 px-3 py-2 rounded-md text-sm font-medium focus:outline-none transition duration-150">
                                <i class="fas fa-user mr-1"></i>
                                <?= esc(session()->get('userName')) ?>
                                <i class="fas fa-chevron-down ml-1 text-xs"></i>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50" x-transition>
                                <?php if (session()->get('userRole') === 'admin'): ?>
                                    <a href="/admin/dashboard" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-tachometer-alt mr-2"></i>Admin Panel
                                    </a>
                                    <hr class="my-1">
                                <?php else: ?>
                                    <a href="/dashboard" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user-circle mr-2"></i>Dashboard Saya
                                    </a>
                                    <hr class="my-1">
                                <?php endif; ?>
                                <a href="/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="/login" class="text-white hover:text-primary-200 px-3 py-2 rounded-md text-sm font-medium transition duration-150">
                            <i class="fas fa-sign-in-alt mr-1"></i>Login
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button type="button" x-data="{ mobileOpen: false }" @click="mobileOpen = !mobileOpen" class="text-white hover:text-primary-200 focus:outline-none focus:text-primary-200 p-2">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    
                    <!-- Mobile Menu -->
                    <div class="absolute top-16 left-0 right-0 md:hidden" x-show="mobileOpen" @click.away="mobileOpen = false" x-transition>
                        <div class="px-2 pt-2 pb-3 space-y-1 bg-primary-700 shadow-lg">
                            <a href="/" class="text-white hover:bg-primary-800 block px-3 py-2 rounded-md text-base font-medium">
                                <i class="fas fa-bars mr-2"></i>Beranda
                            </a>
                            <a href="/books" class="text-white hover:bg-primary-800 block px-3 py-2 rounded-md text-base font-medium">
                                <i class="fas fa-book mr-2"></i>Buku
                            </a>
                            
                            <?php if (session()->get('isLoggedIn')): ?>
                                <?php if (session()->get('userRole') === 'admin'): ?>
                                    <a href="/books/new" class="text-white hover:bg-primary-800 block px-3 py-2 rounded-md text-base font-medium">
                                        <i class="fas fa-plus mr-2"></i>Tambah Buku
                                    </a>
                                <?php endif; ?>
                                <a href="/logout" class="text-white hover:bg-primary-800 block px-3 py-2 rounded-md text-base font-medium">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </a>
                            <?php else: ?>
                                <a href="/login" class="text-white hover:bg-primary-800 block px-3 py-2 rounded-md text-base font-medium">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Login
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div x-data="{ show: true }" x-show="show" x-transition class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2 text-green-600"></i>
                        <span><?= session()->getFlashdata('success') ?></span>
                    </div>
                    <button @click="show = false" class="text-green-600 hover:text-green-800 focus:outline-none">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div x-data="{ show: true }" x-show="show" x-transition class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2 text-red-600"></i>
                        <span><?= session()->getFlashdata('error') ?></span>
                    </div>
                    <button @click="show = false" class="text-red-600 hover:text-red-800 focus:outline-none">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('info')): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div x-data="{ show: true }" x-show="show" x-transition class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg shadow-sm">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                        <span><?= session()->getFlashdata('info') ?></span>
                    </div>
                    <button @click="show = false" class="text-blue-600 hover:text-blue-800 focus:outline-none">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="min-h-screen bg-cream">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-primary-600 to-primary-500 text-cream py-8 mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h5 class="text-xl font-semibold mb-2">
                        <i class="fas fa-book-open mr-2 text-secondary-500"></i>
                        <?= isset($siteName) ? $siteName : 'Perpustakaan Digital' ?>
                    </h5>
                    <p class="text-cream/90"><?= isset($siteDescription) ? $siteDescription : 'Akses koleksi buku digital dengan mudah dan praktis.' ?></p>
                </div>
                <div class="md:text-right">
                    <p class="text-cream/80">&copy; <?= date('Y') ?> <?= isset($siteName) ? $siteName : 'Perpustakaan Digital' ?>. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html> 