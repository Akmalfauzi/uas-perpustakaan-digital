<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : '' ?>Admin Dashboard - Perpustakaan Digital</title>
    <meta name="description" content="Admin Dashboard - Sistem Perpustakaan Digital">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
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
                        cream: '#FFF9E5',
                        sidebar: {
                            bg: '#f8fafc',
                            hover: '#e2e8f0'
                        }
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
<body class="font-inter bg-gray-50 text-gray-800" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0" 
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between h-16 px-6 bg-primary-600">
                <div class="flex items-center">
                    <i class="fas fa-book-open text-white text-xl mr-3"></i>
                    <span class="text-white font-bold text-lg">Admin Panel</span>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="mt-6 px-4">
                <div class="space-y-2">
                    <!-- Dashboard -->
                    <a href="/admin/dashboard" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-sidebar-hover <?= uri_string() === 'admin/dashboard' ? 'bg-primary-100 text-primary-700 border-r-2 border-primary-600' : '' ?> transition-colors duration-200">
                        <i class="fas fa-home w-5 h-5 mr-3"></i>
                        Dashboard
                    </a>

                    <!-- Books Management -->
                    <a href="/admin/books" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-sidebar-hover <?= strpos(uri_string(), 'admin/books') !== false ? 'bg-primary-100 text-primary-700 border-r-2 border-primary-600' : '' ?> transition-colors duration-200">
                        <i class="fas fa-book w-5 h-5 mr-3"></i>
                        Kelola Buku
                    </a>

                    <!-- Users Management -->
                    <a href="/admin/users" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-sidebar-hover <?= strpos(uri_string(), 'admin/users') !== false ? 'bg-primary-100 text-primary-700 border-r-2 border-primary-600' : '' ?> transition-colors duration-200">
                        <i class="fas fa-users w-5 h-5 mr-3"></i>
                        Kelola Pengguna
                    </a>

                    <!-- Loans Management -->
                    <a href="/admin/loans" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-sidebar-hover <?= strpos(uri_string(), 'admin/loans') !== false ? 'bg-primary-100 text-primary-700 border-r-2 border-primary-600' : '' ?> transition-colors duration-200">
                        <i class="fas fa-handshake w-5 h-5 mr-3"></i>
                        Kelola Peminjaman
                    </a>

                    <!-- Settings -->
                    <a href="/admin/settings" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-sidebar-hover <?= uri_string() === 'admin/settings' ? 'bg-primary-100 text-primary-700 border-r-2 border-primary-600' : '' ?> transition-colors duration-200">
                        <i class="fas fa-cog w-5 h-5 mr-3"></i>
                        Pengaturan
                    </a>
                </div>

                <!-- Bottom Section -->
                <div class="mt-8 pt-8 border-t border-gray-200">
                    <a href="/" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-sidebar-hover transition-colors duration-200">
                        <i class="fas fa-globe w-5 h-5 mr-3"></i>
                        Lihat Website
                    </a>
                    <a href="/logout" class="flex items-center px-4 py-3 text-red-600 rounded-lg hover:bg-red-50 transition-colors duration-200">
                        <i class="fas fa-sign-out-alt w-5 h-5 mr-3"></i>
                        Logout
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between h-16 px-6">
                    <!-- Mobile menu button -->
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="lg:hidden text-gray-500 hover:text-gray-700 mr-4">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        
                        <!-- Page Title -->
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900">
                                <?= isset($title) ? $title : 'Admin Dashboard' ?>
                            </h1>
                            <p class="text-sm text-gray-500 mt-1">
                                <?= date('d M Y') ?>
                            </p>
                        </div>
                    </div>

                    <!-- User Profile -->
                    <div class="flex items-center" x-data="{ profileOpen: false }">
                        <div class="relative">
                            <button @click="profileOpen = !profileOpen" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-primary-500">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-white font-medium text-sm">
                                            <?= strtoupper(substr(session()->get('userName') ?? 'A', 0, 1)) ?>
                                        </span>
                                    </div>
                                    <div class="text-left">
                                        <div class="font-medium text-gray-700"><?= esc(session()->get('userName')) ?></div>
                                        <div class="text-xs text-gray-500">@<?= strtolower(str_replace(' ', '', session()->get('userName'))) ?></div>
                                    </div>
                                    <i class="fas fa-chevron-down ml-3 text-gray-400 text-xs"></i>
                                </div>
                            </button>

                            <!-- Dropdown -->
                            <div x-show="profileOpen" @click.away="profileOpen = false" 
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50" 
                                 x-transition>
                                <a href="/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="mx-6 mt-4">
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
                <div class="mx-6 mt-4">
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

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-6">
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <!-- Mobile sidebar backdrop -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false" 
         class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
    </div>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html> 