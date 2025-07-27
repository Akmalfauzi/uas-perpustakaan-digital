<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <!-- Header -->
            <div class="text-center mb-6">
                <div class="mb-4">
                    <i class="fas fa-book-reader text-4xl text-primary-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Masuk ke Akun</h2>
                <p class="text-gray-600 mt-2">Silakan masuk untuk mengakses Perpustakaan Digital</p>
            </div>

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

            <!-- Login Form -->
            <form action="/login/authenticate" method="post" id="loginForm" class="space-y-6">
                <?= csrf_field() ?>
                
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-primary-600"></i>Email
                    </label>
                    <input 
                        type="email" 
                        class="w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 <?= isset($validation) && $validation->hasError('email') ? 'border-red-500 bg-red-50' : 'bg-cream' ?>" 
                        id="email" 
                        name="email" 
                        placeholder="Masukkan Email Anda"
                        value="<?= old('email') ?>"
                        required
                    >
                    <?php if (isset($validation) && $validation->hasError('email')): ?>
                        <p class="mt-2 text-sm text-red-600">
                            <?= $validation->getError('email') ?>
                        </p>
                    <?php endif ?>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-primary-600"></i>Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            class="w-full px-4 py-3 pr-12 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 <?= isset($validation) && $validation->hasError('password') ? 'border-red-500 bg-red-50' : 'bg-cream' ?>" 
                            id="password" 
                            name="password" 
                            placeholder="Masukkan password Anda"
                            required
                        >
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-primary-600">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <?php if (isset($validation) && $validation->hasError('password')): ?>
                        <p class="mt-2 text-sm text-red-600">
                            <?= $validation->getError('password') ?>
                        </p>
                    <?php endif ?>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        Ingat saya
                    </label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full bg-primary-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition duration-200" id="loginBtn">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Masuk
                    </button>
                </div>
            </form>

            <!-- Additional Links -->
            <div class="text-center mt-6">

                <?php if (isset($allowRegistration) && $allowRegistration): ?>
                <div class="border-t border-gray-200 pt-4">
                    <p class="text-gray-600 text-sm">
                        Belum punya akun? 
                        <a href="/register" class="text-primary-500 hover:text-primary-600 font-semibold ml-1">
                            Daftar sekarang
                        </a>
                    </p>
                </div>
                <?php endif; ?>
            </div>
        </div>


    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    
    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        const icon = this.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });

    // Form submission loading state
    const form = document.querySelector('#loginForm');
    const submitBtn = document.querySelector('#loginBtn');
    
    form.addEventListener('submit', function() {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
    });

    // Auto focus on first input
    const firstInput = document.querySelector('#email');
    if (firstInput) {
        firstInput.focus();
    }
});
</script>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    body {
        background: linear-gradient(135deg, #4A9782 0%, #004030 50%, #DCD0A8 100%);
        min-height: 100vh;
    }
    
    main {
        background: transparent;
    }
</style>
<?= $this->endSection() ?> 