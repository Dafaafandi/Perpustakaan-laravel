<x-layout>
    <x-slot:title>Profile Page</x-slot:title>

    <div class="bg-white">
        <div class="mx-auto max-w-7xl py-12 px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-1 max-w-4xl mx-auto">
                <div class="group relative">
                    <div
                        class="block rounded-lg bg-white shadow-md hover:shadow-lg transition-shadow duration-300 border">
                        <div class="p-8">
                            <div class="flex items-center mb-6">
                                <div
                                    class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-blue-100 mb-4 lg:mx-0 lg:mb-0 lg:mr-4">
                                    <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="text-center lg:text-left">
                                    <h3 class="text-2xl font-bold text-gray-900">Informasi Profil</h3>
                                    <p class="mt-2 text-gray-600">Perbarui informasi profil dan alamat email akun Anda
                                    </p>
                                </div>
                            </div>
                            <div class="border-t pt-6">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>
                    </div>
                </div>

                <div class="group relative">
                    <div
                        class="block rounded-lg bg-white shadow-md hover:shadow-lg transition-shadow duration-300 border">
                        <div class="p-8">
                            <div class="flex items-center mb-6">
                                <div
                                    class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-green-100 mb-4 lg:mx-0 lg:mb-0 lg:mr-4">
                                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="text-center lg:text-left">
                                    <h3 class="text-2xl font-bold text-gray-900">Update Password</h3>
                                    <p class="mt-2 text-gray-600">Pastikan akun Anda menggunakan password yang panjang
                                        dan acak untuk tetap aman</p>
                                </div>
                            </div>
                            <div class="border-t pt-6">
                                @include('profile.partials.update-password-form')
                            </div>
                        </div>
                    </div>
                </div>

                <div class="group relative">
                    <div
                        class="block rounded-lg bg-white shadow-md hover:shadow-lg transition-shadow duration-300 border border-red-200">
                        <div class="p-8">
                            <div class="flex items-center mb-6">
                                <div
                                    class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-red-100 mb-4 lg:mx-0 lg:mb-0 lg:mr-4">
                                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </div>
                                <div class="text-center lg:text-left">
                                    <h3 class="text-2xl font-bold text-gray-900">Hapus Akun</h3>
                                    <p class="mt-2 text-gray-600">Setelah akun Anda dihapus, semua sumber daya dan data
                                        akan dihapus secara permanen</p>
                                </div>
                            </div>
                            <div class="border-t pt-6">
                                @include('profile.partials.delete-user-form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
