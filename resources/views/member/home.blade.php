<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="bg-white">
        <div class="mx-auto max-w-7xl py-12 px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">
                    Selamat Datang di Perpustakaan Lamongan
                </h1>
                <p class="mt-4 text-xl text-gray-600">
                    Portal Anggota Perpustakaan
                </p>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <div class="group relative">
                    <div
                        class="block rounded-lg bg-white shadow-md hover:shadow-lg transition-shadow duration-300 cursor-not-allowed opacity-75">
                        <div class="p-6 text-center">
                            <div
                                class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-green-100 mb-4">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Buku</h3>
                            <p class="mt-2 text-sm text-gray-500">Jelajahi koleksi buku perpustakaan</p>
                        </div>
                    </div>
                </div>

                <!-- My Borrowings Card -->
                <div class="group relative">
                    <div
                        class="block rounded-lg bg-white shadow-md hover:shadow-lg transition-shadow duration-300 cursor-not-allowed opacity-75">
                        <div class="p-6 text-center">
                            <div
                                class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-yellow-100 mb-4">
                                <svg class="h-8 w-8 text-yellow-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Peminjaman Saya</h3>
                            <p class="mt-2 text-sm text-gray-500">Lihat status buku yang sedang dipinjam</p>
                        </div>
                    </div>
                </div>

                <!-- Profile Card -->
                <div class="group relative">
                    <a href="{{ route('profile.edit') }}"
                        class="block rounded-lg bg-white shadow-md hover:shadow-lg transition-shadow duration-300">
                        <div class="p-6 text-center">
                            <div
                                class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-blue-100 mb-4">
                                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Profil Saya</h3>
                            <p class="mt-2 text-sm text-gray-500">Kelola informasi akun Anda</p>
                        </div>
                    </a>
                </div>
            </div>


        </div>
    </div>
</x-layout>
