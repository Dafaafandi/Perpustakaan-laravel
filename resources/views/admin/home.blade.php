<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    @push('styles')
        <style>
            .group a {
                text-decoration: none !important;
            }

            .group a:hover {
                text-decoration: none !important;
            }

            .group h3 {
                text-decoration: none !important;
            }

            .group p {
                text-decoration: none !important;
            }
        </style>
    @endpush

    <div class="bg-white">
        <div class="mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl">
                    Selamat Datang di Perpustakaan Lamongan
                </h1>
                <p class="mt-4 text-xl text-gray-600">
                    Sistem Manajemen Perpustakaan Digital
                </p>
            </div>

            <!-- Navigation Cards -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Category Card -->
                <div class="group relative">
                    <a href="/kategori"
                        class="block rounded-lg bg-white shadow-md hover:shadow-lg transition-shadow duration-300">
                        <div class="p-6 text-center">
                            <div
                                class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-blue-100 mb-4">
                                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14-7H5m14 14H5"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Kategori</h3>
                            <p class="mt-2 text-sm text-gray-500">Kelola kategori buku</p>
                        </div>
                    </a>
                </div>

                <!-- Books Card -->
                <div class="group relative">
                    <a href="/buku"
                        class="block rounded-lg bg-white shadow-md hover:shadow-lg transition-shadow duration-300">
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
                            <p class="mt-2 text-sm text-gray-500">Daftar koleksi buku</p>
                        </div>
                    </a>
                </div>

                <!-- Borrowing Card -->
                <div class="group relative">
                    <a href="/borrowing"
                        class="block rounded-lg bg-white shadow-md hover:shadow-lg transition-shadow duration-300">
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
                            <h3 class="text-lg font-medium text-gray-900">Peminjaman</h3>
                            <p class="mt-2 text-sm text-gray-500">Kelola peminjaman buku</p>
                        </div>
                    </a>
                </div>

                <!-- Members Card -->
                <div class="group relative">
                    <a href="/members"
                        class="block rounded-lg bg-white shadow-md hover:shadow-lg transition-shadow duration-300">
                        <div class="p-6 text-center">
                            <div
                                class="mx-auto h-16 w-16 flex items-center justify-center rounded-full bg-purple-100 mb-4">
                                <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Daftar Anggota</h3>
                            <p class="mt-2 text-sm text-gray-500">Kelola data anggota</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layout>
