<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <!-- Header -->
            <div class="text-center mb-6">
                <div class="mb-4">
                    <i class="fas fa-user-plus text-4xl text-primary-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Daftar Akun Baru</h2>
                <p class="text-gray-600 mt-2">Bergabunglah dengan Perpustakaan Digital</p>
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

            <!-- Registration Form -->
            <form action="/register/create" method="post" id="registerForm" class="space-y-6">
                <?= csrf_field() ?>
                
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-primary-600"></i>Nama Lengkap
                    </label>
                    <input 
                        type="text" 
                        class="w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 <?= isset($validation) && $validation->hasError('name') ? 'border-red-500 bg-red-50' : 'bg-cream' ?>" 
                        id="name" 
                        name="name" 
                        placeholder="Masukkan nama lengkap Anda"
                        value="<?= old('name') ?>"
                        required
                    >
                    <?php if (isset($validation) && $validation->hasError('name')): ?>
                        <p class="mt-2 text-sm text-red-600">
                            <?= $validation->getError('name') ?>
                        </p>
                    <?php endif ?>
                </div>

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
                        placeholder="masukkan@email.anda"
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
                            placeholder="Masukkan password (minimal <?= isset($minPasswordLength) ? $minPasswordLength : 6 ?> karakter)"
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

                <!-- Confirm Password Field -->
                <div>
                    <label for="password_confirm" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-primary-600"></i>Konfirmasi Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            class="w-full px-4 py-3 pr-12 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 <?= isset($validation) && $validation->hasError('password_confirm') ? 'border-red-500 bg-red-50' : 'bg-cream' ?>" 
                            id="password_confirm" 
                            name="password_confirm" 
                            placeholder="Ulangi password Anda"
                            required
                        >
                        <button type="button" id="togglePasswordConfirm" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-primary-600">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <?php if (isset($validation) && $validation->hasError('password_confirm')): ?>
                        <p class="mt-2 text-sm text-red-600">
                            <?= $validation->getError('password_confirm') ?>
                        </p>
                    <?php endif ?>
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-center">
                    <input type="checkbox" id="terms" name="terms" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" required>
                    <label for="terms" class="ml-2 block text-sm text-gray-700">
                        Saya setuju dengan <a href="#" class="text-primary-500 hover:text-primary-600 font-medium">syarat dan ketentuan</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full bg-primary-600 text-white py-3 px-4 rounded-lg font-semibold hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition duration-200" id="registerBtn">
                        <i class="fas fa-user-plus mr-2"></i>
                        Daftar Sekarang
                    </button>
                </div>
            </form>

            <!-- Login Link -->
            <div class="text-center mt-6">
                <div class="border-t border-gray-200 pt-4">
                    <p class="text-gray-600 text-sm">
                        Sudah punya akun? 
                        <a href="/login" class="text-primary-500 hover:text-primary-600 font-semibold ml-1">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="bg-secondary-200 rounded-lg p-4 mt-6">
            <div class="text-center">
                <p class="text-sm text-gray-700">
                    <i class="fas fa-info-circle mr-2 text-primary-500"></i>
                    <span class="font-semibold">Gratis!</span> Nikmati akses ke ribuan koleksi buku digital
                </p>
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

    // Toggle confirm password visibility
    const togglePasswordConfirm = document.querySelector('#togglePasswordConfirm');
    const passwordConfirm = document.querySelector('#password_confirm');
    
    togglePasswordConfirm.addEventListener('click', function() {
        const type = passwordConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirm.setAttribute('type', type);
        
        const icon = this.querySelector('i');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });

    // Form submission loading state
    const form = document.querySelector('#registerForm');
    const submitBtn = document.querySelector('#registerBtn');
    
    form.addEventListener('submit', function(e) {
        const termsCheckbox = document.getElementById('terms');
        if (!termsCheckbox.checked) {
            e.preventDefault();
            alert('Silakan setujui syarat dan ketentuan terlebih dahulu.');
            return;
        }
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mendaftar...';
    });

    // Password strength indicator and real-time validation
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirm');
    
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        
        // Visual feedback for password strength
        this.classList.remove('border-green-500', 'bg-green-50', 'border-red-500', 'bg-red-50');
        const minLength = <?= isset($minPasswordLength) ? $minPasswordLength : 6 ?>;
        if (password.length >= minLength) {
            this.classList.add('border-green-500', 'bg-green-50');
        } else if (password.length > 0) {
            this.classList.add('border-red-500', 'bg-red-50');
        }
        
        // Check confirm password match when main password changes
        if (confirmInput.value.length > 0) {
            validatePasswordMatch();
        }
    });

    // Real-time password confirmation check
    confirmInput.addEventListener('input', validatePasswordMatch);
    
    function validatePasswordMatch() {
        const password = passwordInput.value;
        const confirm = confirmInput.value;
        
        confirmInput.classList.remove('border-green-500', 'bg-green-50', 'border-red-500', 'bg-red-50');
        if (confirm.length > 0) {
            const minLength = <?= isset($minPasswordLength) ? $minPasswordLength : 6 ?>;
        if (password === confirm && password.length >= minLength) {
                confirmInput.classList.add('border-green-500', 'bg-green-50');
            } else {
                confirmInput.classList.add('border-red-500', 'bg-red-50');
            }
        }
    }

    // Auto focus on first input
    const firstInput = document.querySelector('#name');
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