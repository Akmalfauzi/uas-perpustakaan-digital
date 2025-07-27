<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<!-- Page Header -->
<div class="mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Kelola Pengguna</h2>
            <p class="text-gray-600 mt-1">Manage all users in the system</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="/admin/users/new" class="bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition duration-200 inline-flex items-center">
                <i class="fas fa-user-plus mr-2"></i>
                Tambah Pengguna
            </a>
        </div>
    </div>
</div>

<!-- Search and Filters -->
<div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 mb-6">
    <form method="GET" action="/admin/users" class="grid grid-cols-1 md:grid-cols-12 gap-4">
        <div class="md:col-span-6">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-search mr-1"></i>Cari Pengguna
            </label>
            <input 
                type="text" 
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                id="search" 
                name="search" 
                placeholder="Cari berdasarkan nama atau email..."
                value="<?= esc($search ?? '') ?>"
            >
        </div>
        <div class="md:col-span-3">
            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-user-tag mr-1"></i>Role
            </label>
            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" id="role" name="role">
                <option value="">Semua Role</option>
                <option value="admin" <?= ($role ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="user" <?= ($role ?? '') === 'user' ? 'selected' : '' ?>>User</option>
            </select>
        </div>
        <div class="md:col-span-3">
            <label class="block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
            <button type="submit" class="w-full bg-primary-600 text-white px-4 py-3 rounded-lg font-semibold hover:bg-primary-700 transition duration-200">
                <i class="fas fa-search mr-1"></i>Cari
            </button>
        </div>
    </form>
</div>

<!-- Results Summary -->
<?php if ($search || $role): ?>
<div class="mb-6">
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-center justify-between">
            <span class="text-blue-800">
                <i class="fas fa-info-circle mr-2"></i>
                Filter aktif:
                <?php if ($search): ?>
                    <strong>"<?= esc($search) ?>"</strong>
                <?php endif; ?>
                <?php if ($role): ?>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 ml-2"><?= esc($role) ?></span>
                <?php endif; ?>
            </span>
            <a href="/admin/users" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                <i class="fas fa-times mr-1"></i>Hapus Filter
            </a>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Users Table -->
<?php if (!empty($users) && is_array($users)): ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Pengguna
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Role
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Login Terakhir
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Bergabung
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($users as $user): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 bg-primary-600 rounded-full flex items-center justify-center">
                                    <span class="text-white font-medium text-sm">
                                        <?= strtoupper(substr($user['name'], 0, 1)) ?>
                                    </span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    <?= esc($user['name']) ?>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-envelope mr-1"></i><?= esc($user['email']) ?>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php if ($user['role'] === 'admin'): ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                <i class="fas fa-crown mr-1"></i>Admin
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <i class="fas fa-user mr-1"></i>User
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <?php if ($user['is_active']): ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>Aktif
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times-circle mr-1"></i>Nonaktif
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <?php if ($user['last_login']): ?>
                            <i class="fas fa-clock mr-1"></i>
                            <?= date('d M Y, H:i', strtotime($user['last_login'])) ?>
                        <?php else: ?>
                            <span class="text-gray-400">Belum pernah login</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <i class="fas fa-calendar mr-1"></i>
                        <?= date('d M Y', strtotime($user['created_at'])) ?>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="/admin/users/<?= $user['id'] ?>/edit" class="text-blue-600 hover:text-blue-900" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <?php if ($user['id'] != session()->get('userId')): ?>
                            <button onclick="toggleUserStatus(<?= $user['id'] ?>, '<?= esc($user['name']) ?>', <?= $user['is_active'] ? 'false' : 'true' ?>)" 
                                    class="<?= $user['is_active'] ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' ?>" 
                                    title="<?= $user['is_active'] ? 'Nonaktifkan' : 'Aktifkan' ?>">
                                <i class="fas fa-<?= $user['is_active'] ? 'user-slash' : 'user-check' ?>"></i>
                            </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<?php if (isset($pager)): ?>
<div class="mt-6">
    <?= $pager->links('default', 'custom_full') ?>
</div>
<?php endif; ?>

<?php else: ?>
<!-- Empty State -->
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
    <i class="fas fa-users text-4xl text-gray-400 mb-4"></i>
    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada pengguna ditemukan</h3>
    <p class="text-gray-500 mb-6">
        <?php if ($search || $role): ?>
            Coba ubah filter pencarian Anda.
        <?php else: ?>
            Belum ada pengguna terdaftar dalam sistem.
        <?php endif; ?>
    </p>
    <a href="/admin/users/new" class="bg-primary-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-700 transition duration-200 inline-flex items-center">
        <i class="fas fa-user-plus mr-2"></i>
        Tambah Pengguna
    </a>
</div>
<?php endif; ?>

<!-- Toggle Status Modal -->
<div class="fixed inset-0 z-50 hidden" id="statusModal" aria-hidden="true">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-black opacity-50" onclick="closeStatusModal()"></div>
        <div class="relative bg-white rounded-xl shadow-xl max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h5 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-user-cog text-blue-500 mr-2"></i>
                    Ubah Status Pengguna
                </h5>
                <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeStatusModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mb-6">
                <p class="text-gray-700">Apakah Anda yakin ingin <span id="statusAction"></span> pengguna <strong id="userName"></strong>?</p>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" class="px-4 py-2 text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50" onclick="closeStatusModal()">Batal</button>
                <form id="statusForm" method="POST" class="inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700">
                        <i class="fas fa-user-check mr-2"></i>
                        Ubah Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function toggleUserStatus(userId, userName, willActivate) {
    document.getElementById('userName').textContent = userName;
    document.getElementById('statusAction').textContent = willActivate ? 'mengaktifkan' : 'menonaktifkan';
    document.getElementById('statusForm').action = '/admin/users/' + userId + '/toggle-status';
    
    const modal = document.getElementById('statusModal');
    modal.classList.remove('hidden');
}

function closeStatusModal() {
    const modal = document.getElementById('statusModal');
    modal.classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form on filter change
    const roleSelect = document.getElementById('role');
    
    if (roleSelect) {
        roleSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeStatusModal();
        }
    });
});
</script>
<?= $this->endSection() ?> 