<x-layout>
    <x-slot:title>Profile Page</x-slot:title>

    <div class="bg-gray-50 min-h-screen">
        <div class="mx-auto max-w-4xl py-12 px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Pengaturan Profil</h1>
                <p class="text-gray-600">Kelola informasi akun, keamanan, dan preferensi Anda</p>
            </div>

            <!-- Single Card Container -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <!-- Profile Information Section -->
                <div class="px-8 py-6 border-b border-gray-200">
                    <div class="flex items-center mb-6">
                        <div class="h-12 w-12 flex items-center justify-center rounded-full bg-blue-100 mr-4">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Informasi Profil</h2>
                            <p class="text-gray-600 text-sm">Perbarui informasi profil dan alamat email akun Anda</p>
                        </div>
                    </div>

                    <!-- Profile Form -->
                    <form method="post" action="{{ route('profile.update') }}" class="space-y-6"
                        enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Profile Image -->
                            <div class="md:col-span-2">
                                @if ($user->image)
                                    <div class="mb-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto Profil Saat
                                            Ini</label>
                                        <img src="{{ asset('storage/' . $user->image) }}" alt="Profile Image"
                                            class="w-20 h-20 rounded-full object-cover border-4 border-gray-200">
                                    </div>
                                @endif

                                <div>
                                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Upload
                                        Foto Profil Baru</label>
                                    <input id="image" name="image" type="file"
                                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                        accept="image/*" />
                                    <p class="mt-1 text-sm text-gray-500">JPG, PNG, GIF - Maksimal 2MB</p>
                                    @error('image')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama
                                    Lengkap</label>
                                <input id="name" name="name" type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input id="email" name="email" type="email"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4">
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition-colors duration-200">
                                Simpan Perubahan
                            </button>

                            @if (session('status') === 'profile-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                                    class="text-sm text-green-600 font-medium">Profile berhasil diperbarui!</p>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Password Update Section -->
                <div class="px-8 py-6 border-b border-gray-200">
                    <div class="flex items-center mb-6">
                        <div class="h-12 w-12 flex items-center justify-center rounded-full bg-green-100 mr-4">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Keamanan Akun</h2>
                            <p class="text-gray-600 text-sm">Pastikan akun Anda menggunakan password yang kuat</p>
                        </div>
                    </div>

                    <!-- Password Form -->
                    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                        @csrf
                        @method('put')

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="current_password"
                                    class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini</label>
                                <input id="current_password" name="current_password" type="password"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                @error('current_password', 'updatePassword')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password
                                    Baru</label>
                                <input id="password" name="password" type="password"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                @error('password', 'updatePassword')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                @error('password_confirmation', 'updatePassword')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4">
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md font-medium transition-colors duration-200">
                                Update Password
                            </button>

                            @if (session('status') === 'password-updated')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                                    class="text-sm text-green-600 font-medium">Password berhasil diperbarui!</p>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Delete Account Section -->
                <div class="px-8 py-6 bg-red-50">
                    <div class="flex items-center mb-6">
                        <div class="h-12 w-12 flex items-center justify-center rounded-full bg-red-100 mr-4">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Zona Berbahaya</h2>
                            <p class="text-gray-600 text-sm">Tindakan ini akan menghapus akun Anda secara permanen</p>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-lg border border-red-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Hapus Akun</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen.
                            Silakan unduh data yang ingin Anda simpan sebelum menghapus akun.
                        </p>

                        <button type="button" x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                            class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-md font-medium transition-colors duration-200">
                            Hapus Akun
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 mb-4">
                Apakah Anda yakin ingin menghapus akun ini?
            </h2>

            <p class="text-sm text-gray-600 mb-6">
                Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen.
                Masukkan password Anda untuk mengkonfirmasi penghapusan akun.
            </p>

            <div class="mb-6">
                <label for="password" class="sr-only">Password</label>
                <input id="password" name="password" type="password"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-red-500"
                    placeholder="Masukkan password Anda" />
                @error('password', 'userDeletion')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium transition-colors duration-200">
                    Batal
                </button>
                <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-medium transition-colors duration-200">
                    Hapus Akun
                </button>
            </div>
        </form>
    </x-modal>
</x-layout>
