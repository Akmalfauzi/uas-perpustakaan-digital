<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center">
        <a href="/admin/users" class="text-gray-500 hover:text-gray-700 mr-4">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Pengguna</h2>
            <p class="text-gray-600 mt-1">Update user information and settings</p>
        </div>
    </div>
</div>

<!-- Edit Form -->
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

    <form action="/admin/users/<?= $user['id'] ?>/update" method="post" class="space-y-6">
        <?= csrf_field() ?>
        
        <!-- User Info Section -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pengguna</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-primary-600"></i>Nama Lengkap
                    </label>
                    <input 
                        type="text" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                        id="name" 
                        name="name" 
                        value="<?= esc(old('name') ?? $user['name']) ?>"
                        required
                    >
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-primary-600"></i>Email
                    </label>
                    <input 
                        type="email" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                        id="email" 
                        name="email" 
                        value="<?= esc(old('email') ?? $user['email']) ?>"
                        required
                    >
                </div>
            </div>
        </div>

        <!-- Role & Status Section -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Role & Status</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user-tag mr-2 text-primary-600"></i>Role
                    </label>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" id="role" name="role">
                        <option value="user" <?= (old('role') ?? $user['role']) === 'user' ? 'selected' : '' ?>>User</option>
                        <option value="admin" <?= (old('role') ?? $user['role']) === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label for="is_active" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-toggle-on mr-2 text-primary-600"></i>Status
                    </label>
                    <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" id="is_active" name="is_active">
                        <option value="1" <?= (old('is_active') ?? $user['is_active']) == '1' ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= (old('is_active') ?? $user['is_active']) == '0' ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Password Section -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ubah Password (Opsional)</h3>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                <p class="text-sm text-yellow-800">
                    <i class="fas fa-info-circle mr-2"></i>
                    Kosongkan field password jika tidak ingin mengubah password pengguna.
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-primary-600"></i>Password Baru
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                            id="password" 
                            name="password" 
                            placeholder="Masukkan password baru (minimal 6 karakter)"
                        >
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-primary-600">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirm" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-primary-600"></i>Konfirmasi Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                            id="password_confirm" 
                            name="password_confirm" 
                            placeholder="Ulangi password baru"
                        >
                        <button type="button" id="togglePasswordConfirm" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 hover:text-primary-600">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Meta Info -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Akun</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm text-gray-600">Bergabung</div>
                    <div class="text-lg font-semibold text-gray-900">
                        <?= date('d M Y, H:i', strtotime($user['created_at'])) ?>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-sm text-gray-600">Login Terakhir</div>
                    <div class="text-lg font-semibold text-gray-900">
                        <?php if ($user['last_login']): ?>
                            <?= date('d M Y, H:i', strtotime($user['last_login'])) ?>
                        <?php else: ?>
                            <span class="text-gray-500">Belum pernah login</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="/admin/users" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition duration-200">
                <i class="fas fa-times mr-2"></i>Batal
            </a>
            <button type="submit" class="px-6 py-3 bg-primary-600 text-white rounded-lg font-semibold hover:bg-primary-700 transition duration-200">
                <i class="fas fa-save mr-2"></i>Simpan Perubahan
            </button>
        </div>
    </form>
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

    // Password confirmation validation
    passwordConfirm.addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirm = this.value;
        
        this.classList.remove('border-green-500', 'border-red-500');
        if (confirm.length > 0) {
            if (password === confirm) {
                this.classList.add('border-green-500');
            } else {
                this.classList.add('border-red-500');
            }
        }
    });
});
</script>
<?= $this->endSection() ?> 