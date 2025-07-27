<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle . ' - ' : '' ?>Dashboard - Perpustakaan Digital</title>
    <meta name="description" content="Dashboard - Sistem Perpustakaan Digital">
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
    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)" class="fixed top-4 right-4 z-50 bg-green-100 border border-green-400 text-green-700 px-6 py-3 rounded-lg shadow-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span><?= session()->getFlashdata('success') ?></span>
                <button @click="show = false" class="ml-4 text-green-600 hover:text-green-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 5000)" class="fixed top-4 right-4 z-50 bg-red-100 border border-red-400 text-red-700 px-6 py-3 rounded-lg shadow-lg">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span><?= session()->getFlashdata('error') ?></span>
                <button @click="show = false" class="ml-4 text-red-600 hover:text-red-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    <?php endif; ?>

    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0" 
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between h-16 px-6 bg-primary-600">
                <div class="flex items-center">
                    <i class="fas fa-book-reader text-white text-xl mr-3"></i>
                    <span class="text-white font-bold text-lg">Dashboard</span>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="mt-6 px-4">
                <div class="space-y-2">
                    <!-- Dashboard -->
                    <a href="/dashboard" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-sidebar-hover <?= uri_string() === 'dashboard' ? 'bg-primary-100 text-primary-700 border-r-2 border-primary-600' : '' ?> transition-colors duration-200">
                        <i class="fas fa-home w-5 h-5 mr-3"></i>
                        Dashboard
                    </a>

                    <!-- Loan History -->
                    <a href="/dashboard/loans" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-sidebar-hover <?= strpos(uri_string(), 'dashboard/loans') !== false ? 'bg-primary-100 text-primary-700 border-r-2 border-primary-600' : '' ?> transition-colors duration-200">
                        <i class="fas fa-list w-5 h-5 mr-3"></i>
                        Riwayat Peminjaman
                    </a>

                    <!-- Browse Books -->
                    <a href="/books" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-sidebar-hover transition-colors duration-200">
                        <i class="fas fa-book w-5 h-5 mr-3"></i>
                        Jelajahi Buku
                    </a>

                    <!-- Divider -->
                    <div class="border-t border-gray-200 my-4"></div>

                    <!-- Logout -->
                    <a href="/logout" class="flex items-center px-4 py-3 text-red-600 rounded-lg hover:bg-red-50 transition-colors duration-200">
                        <i class="fas fa-sign-out-alt w-5 h-5 mr-3"></i>
                        Keluar
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                                <i class="fas fa-bars text-xl"></i>
                            </button>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center text-sm">
                                <span class="text-gray-700 mr-2">Selamat datang,</span>
                                <span class="font-medium text-gray-900"><?= esc(session()->get('userName')) ?></span>
                            </div>
                            <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-medium">
                                    <?= strtoupper(substr(session()->get('userName'), 0, 1)) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                <div class="container mx-auto px-6 py-8">
                    <?= $this->renderSection('content') ?>
                </div>
            </main>
        </div>
    </div>

    <?= $this->renderSection('scripts') ?>
</body>
</html> 