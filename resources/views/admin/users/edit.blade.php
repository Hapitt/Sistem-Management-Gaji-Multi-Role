<x-layouts.app :title="'Edit User'">

<div class="p-6 space-y-6 text-gray-900">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold flex items-center gap-2">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit User
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Perbarui informasi user dengan mengisi form berikut.
                </p>
            </div>
            <div>
                <a href="{{ route('admin.users.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Error -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg" role="alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <strong class="font-semibold">Terjadi kesalahan!</strong>
            </div>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Edit -->
    <div class="bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden">
        <div class="p-8">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Kolom Kiri - Foto Profil -->
                    <div class="lg:col-span-1">
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Foto Profil</h3>
                            
                            <!-- Preview Foto -->
                            <div class="flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50">
                                <div class="relative">
                                    <img id="foto-preview" 
                                         src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('Logo.png') }}" 
                                         alt="Preview Foto"
                                         class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-10 rounded-full transition-all flex items-center justify-center">
                                        <svg class="w-8 h-8 text-white opacity-0 hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                
                                <div class="mt-4 text-center">
                                    <label for="foto" class="cursor-pointer inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                        </svg>
                                        Ubah Foto
                                    </label>
                                    <input type="file" 
                                           id="foto" 
                                           name="foto" 
                                           accept="image/*"
                                           class="hidden"
                                           onchange="previewImage(this)">
                                    @if($user->foto)
                                    <div class="mt-2">
                                        <button type="button" 
                                                onclick="removeFoto()"
                                                class="inline-flex items-center px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-lg transition-colors">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus Foto
                                        </button>
                                    </div>
                                    @endif
                                    <p class="text-xs text-gray-500 mt-2">
                                        Format: JPG, PNG, JPEG<br>
                                        Maksimal: 2MB
                                    </p>
                                </div>
                            </div>

                            <!-- Info Role -->
                            <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <h4 class="font-semibold text-blue-800 text-sm mb-2">Informasi Role:</h4>
                                <ul class="text-xs text-blue-700 space-y-1">
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 mr-1 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <strong>Admin:</strong> Akses penuh sistem
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <strong>Manager:</strong> Akses terbatas
                                    </li>
                                    <li class="flex items-center">
                                        <svg class="w-3 h-3 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <strong>Karyawan:</strong> Akses dasar
                                    </li>
                                </ul>
                            </div>

                            <!-- Info Karyawan Terkait -->
                            @if($user->karyawan)
                            <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                                <h4 class="font-semibold text-green-800 text-sm mb-2">Karyawan Terkait Saat Ini:</h4>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-green-800">{{ $user->karyawan->nama }}</p>
                                        <p class="text-xs text-green-600">{{ $user->karyawan->divisi }}</p>
                                        @if($user->karyawan->jabatan)
                                            <p class="text-xs text-green-500">{{ $user->karyawan->jabatan->jabatan }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Kolom Kanan - Form Data -->
                    <div class="lg:col-span-2">
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Data User</h3>

                            <!-- Nama -->
                            <div class="space-y-2">
                                <label for="name" class="block text-sm font-semibold text-gray-700">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                       placeholder="Masukkan nama lengkap"
                                       required>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-semibold text-gray-700">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                       placeholder="Masukkan alamat email"
                                       required>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div class="space-y-2">
                                <label for="role" class="block text-sm font-semibold text-gray-700">
                                    Role <span class="text-red-500">*</span>
                                </label>
                                <select id="role" 
                                        name="role"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('role') border-red-500 @enderror"
                                        required
                                        onchange="toggleKaryawanSelect()">
                                    <option value="">-- Pilih Role --</option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                                    <option value="karyawan" {{ old('role', $user->role) == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                                </select>
                                @error('role')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Pilih Karyawan (hanya untuk role karyawan) -->
                            <div id="karyawan-select-container" class="space-y-2 {{ $user->role !== 'karyawan' ? 'hidden' : '' }}">
                                <label for="karyawan_id" class="block text-sm font-semibold text-gray-700">
                                    Pilih Karyawan <span class="text-red-500">*</span>
                                </label>
                                <select id="karyawan_id" 
                                        name="karyawan_id"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('karyawan_id') border-red-500 @enderror"
                                        {{ $user->role === 'karyawan' ? 'required' : '' }}>
                                    <option value="">-- Pilih Karyawan --</option>
                                    @if(isset($karyawanList) && $karyawanList->count() > 0)
                                        @foreach($karyawanList as $karyawan)
                                            <option value="{{ $karyawan->id_karyawan }}" 
                                                {{ old('karyawan_id', $user->karyawan ? $user->karyawan->id_karyawan : '') == $karyawan->id_karyawan ? 'selected' : '' }}>
                                                {{ $karyawan->nama }} - {{ $karyawan->divisi }} 
                                                @if($karyawan->jabatan)
                                                    ({{ $karyawan->jabatan->jabatan }})
                                                @endif
                                                @if($karyawan->user_id && $karyawan->user_id == $user->id)
                                                    - <span class="text-green-600">(Saat ini)</span>
                                                @endif
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <p class="text-xs text-gray-500">
                                    <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Menampilkan karyawan yang belum memiliki akun user atau karyawan yang sedang terkait dengan user ini.
                                </p>
                                @error('karyawan_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror

                                @if(!isset($karyawanList) || $karyawanList->count() == 0)
                                <div class="p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                                    <p class="text-sm text-yellow-700 flex items-start">
                                        <svg class="w-4 h-4 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3l-6.928-12a2 2 0 00-3.464 0L1.357 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                        <span>Tidak ada karyawan yang tersedia untuk dipilih. Semua karyawan sudah memiliki akun user lain atau belum ada data karyawan.</span>
                                    </p>
                                </div>
                                @endif
                            </div>

                            <!-- Password -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label for="password" class="block text-sm font-semibold text-gray-700">
                                        Password Baru
                                    </label>
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                                           placeholder="Kosongkan jika tidak ingin mengubah">
                                    @error('password')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">
                                        Konfirmasi Password Baru
                                    </label>
                                    <input type="password" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Konfirmasi password baru">
                                </div>
                            </div>

                            <!-- Password Info -->
                            <div class="p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-yellow-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div>
                                        <h4 class="font-semibold text-yellow-800 text-sm mb-1">Catatan Password:</h4>
                                        <p class="text-xs text-yellow-700">Kosongkan field password jika tidak ingin mengubah password yang ada.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Password Tips -->
                            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <h4 class="font-semibold text-gray-800 text-sm mb-2">Tips Password yang Aman:</h4>
                                <ul class="text-xs text-gray-600 space-y-1">
                                    <li>• Minimal 8 karakter</li>
                                    <li>• Kombinasi huruf besar dan kecil</li>
                                    <li>• Mengandung angka dan simbol</li>
                                    <li>• Hindari kata yang mudah ditebak</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex flex-col sm:flex-row gap-3 justify-end mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.users.index') }}" 
                       class="inline-flex items-center px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </a>
                    <button type="submit" 
                            class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(input) {
    const preview = document.getElementById('foto-preview');
    const file = input.files[0];
    
    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
        }
        
        reader.readAsDataURL(file);
    } else {
        preview.src = "{{ $user->foto ? asset('storage/' . $user->foto) : asset('Logo.png') }}";
    }
}

function removeFoto() {
    if(confirm('Apakah Anda yakin ingin menghapus foto profil?')) {
        // Set preview ke default
        document.getElementById('foto-preview').src = "{{ asset('Logo.png') }}";
        // Clear file input
        document.getElementById('foto').value = '';
        // You might want to add a hidden input to indicate photo removal
        // For now, this just clears the selection
    }
}

function toggleKaryawanSelect() {
    const roleSelect = document.getElementById('role');
    const karyawanContainer = document.getElementById('karyawan-select-container');
    const karyawanSelect = document.getElementById('karyawan_id');
    
    if (roleSelect.value === 'karyawan') {
        karyawanContainer.classList.remove('hidden');
        karyawanSelect.required = true;
    } else {
        karyawanContainer.classList.add('hidden');
        karyawanSelect.required = false;
        karyawanSelect.value = ''; // Reset selection
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Set initial state based on current role
    toggleKaryawanSelect();
    
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        const role = document.getElementById('role').value;
        const karyawanId = document.getElementById('karyawan_id').value;
        
        // Validasi password match (jika diisi)
        if (password && password !== passwordConfirmation) {
            e.preventDefault();
            alert('Password dan Konfirmasi Password tidak cocok!');
            return;
        }
        
        // Validasi password strength (jika diisi)
        if (password && password.length < 8) {
            e.preventDefault();
            alert('Password harus minimal 8 karakter!');
            return;
        }

        // Validasi jika role karyawan harus memilih karyawan
        if (role === 'karyawan' && !karyawanId) {
            e.preventDefault();
            alert('Untuk role Karyawan, wajib memilih karyawan yang terkait!');
            return;
        }
    });
    
    // Live password strength indicator (hanya jika password diisi)
    const passwordInput = document.getElementById('password');
    passwordInput.addEventListener('input', function(e) {
        const password = e.target.value;
        
        // Only show indicator if password is being entered
        if (password.length > 0) {
            let strengthIndicator = document.getElementById('password-strength');
            
            if (!strengthIndicator) {
                strengthIndicator = document.createElement('div');
                strengthIndicator.id = 'password-strength';
                strengthIndicator.className = 'mt-2 text-sm';
                passwordInput.parentNode.appendChild(strengthIndicator);
            }
            
            const strength = checkPasswordStrength(password);
            updateStrengthIndicator(strength);
        } else {
            // Remove indicator if password is empty
            const strengthIndicator = document.getElementById('password-strength');
            if (strengthIndicator) {
                strengthIndicator.remove();
            }
        }
    });
});

function checkPasswordStrength(password) {
    let strength = 0;
    
    if (password.length >= 8) strength++;
    if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
    if (password.match(/\d/)) strength++;
    if (password.match(/[^a-zA-Z\d]/)) strength++;
    
    return strength;
}

function updateStrengthIndicator(strength) {
    const indicator = document.getElementById('password-strength');
    const messages = [
        'Sangat Lemah',
        'Lemah', 
        'Cukup',
        'Kuat',
        'Sangat Kuat'
    ];
    const colors = [
        'text-red-600',
        'text-orange-600',
        'text-yellow-600',
        'text-blue-600',
        'text-green-600'
    ];
    
    if (indicator) {
        indicator.textContent = `Kekuatan Password: ${messages[strength]}`;
        indicator.className = `mt-2 text-sm font-medium ${colors[strength]}`;
    }
}
</script>

</x-layouts.app>