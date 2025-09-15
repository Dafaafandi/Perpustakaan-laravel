<x-layout>
    <x-slot:title>{{ $book->title }} - Detail Buku</x-slot:title>

    <div class="bg-white">
        <div class="mx-auto max-w-7xl py-8 px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('member.books.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
                            <svg class="w-3 h-3 mr-2.5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Katalog Buku
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span
                                class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ Str::limit($book->title, 30) }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="lg:grid lg:grid-cols-2 lg:gap-8">
                <!-- Book Image -->
                <div class="mb-8 lg:mb-0">
                    <div class="aspect-w-3 aspect-h-4 bg-gray-200 rounded-lg overflow-hidden">
                        @if ($book->image)
                            <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                <svg class="h-24 w-24 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Book Details -->
                <div>
                    <!-- Category Badge -->
                    <div class="mb-4">
                        <span
                            class="inline-block bg-indigo-100 text-indigo-800 text-sm px-3 py-1 rounded-full font-medium">
                            {{ $book->category->name }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-4">
                        {{ $book->title }}
                    </h1>

                    <!-- Author & Year -->
                    <div class="mb-6 space-y-2">
                        <p class="text-lg text-gray-700">
                            <span class="font-medium">Penulis:</span> {{ $book->author }}
                        </p>
                        <p class="text-lg text-gray-700">
                            <span class="font-medium">Tahun Terbit:</span> {{ $book->publication_year }}
                        </p>
                    </div>

                    <!-- Stock Information -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <h3 class="font-medium text-gray-900 mb-3">Informasi Ketersediaan</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600">Total Stok:</span>
                                <span class="font-medium ml-2">{{ $book->stock }}</span>
                            </div>
                            <div>
                                <span class="text-gray-600">Tersedia:</span>
                                <span class="font-medium ml-2">{{ $book->available_stock }}</span>
                            </div>
                        </div>

                        <div class="mt-3">
                            <span
                                class="inline-flex items-center text-sm font-medium
                                @if ($book->available_stock > 2) text-green-800 bg-green-100
                                @elseif($book->available_stock > 0) text-yellow-800 bg-yellow-100
                                @else text-red-800 bg-red-100 @endif
                                px-3 py-1 rounded-full">
                                <span
                                    class="w-2 h-2 mr-2 rounded-full
                                    @if ($book->available_stock > 2) bg-green-400
                                    @elseif($book->available_stock > 0) bg-yellow-400
                                    @else bg-red-400 @endif">
                                </span>
                                {{ $book->stock_status }}
                            </span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-4">
                        @if (!$userHasActiveBorrowing)
                            <!-- Always show borrow button regardless of stock -->
                            <a href="{{ route('member.borrowings.create', $book) }}"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white text-center py-3 px-4 rounded-lg font-medium text-lg transition-colors duration-200 block">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Pinjam Buku Ini
                            </a>
                        @else
                            <div
                                class="w-full bg-blue-100 text-blue-800 text-center py-3 px-4 rounded-lg font-medium border border-blue-200">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Anda sudah meminjam buku ini
                            </div>
                            <a href="{{ route('member.borrowings.index') }}"
                                class="w-full bg-gray-600 hover:bg-gray-700 text-white text-center py-2 px-4 rounded-lg font-medium transition-colors duration-200 block">
                                Lihat Status Peminjaman
                            </a>
                        @endif

                        <a href="{{ route('member.books.index') }}"
                            class="w-full bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-center py-2 px-4 rounded-lg font-medium transition-colors duration-200 block">
                            Kembali ke Katalog
                        </a>
                    </div>

                    <!-- Information Messages -->
                    @if ($book->available_stock <= 0)
                        <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex">
                                <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                <div>
                                    <h4 class="text-blue-800 font-medium">Peminjaman Tersedia</h4>
                                    <p class="text-blue-700 text-sm mt-1">
                                        Buku ini dapat dipinjam meskipun stok fisik habis. Peminjaman akan diproses
                                        langsung.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @elseif($book->available_stock <= 2 && $book->available_stock > 0)
                        <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex">
                                <svg class="w-5 h-5 text-yellow-400 mt-0.5 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                    </path>
                                </svg>
                                <div>
                                    <h4 class="text-yellow-800 font-medium">Stok Terbatas</h4>
                                    <p class="text-yellow-700 text-sm mt-1">
                                        Hanya tersisa {{ $book->available_stock }} eksemplar fisik buku ini.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Related Books Section (Optional) -->
            <div class="mt-16">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Buku Lainnya dalam Kategori
                    {{ $book->category->name }}</h3>
                <!-- You can implement related books logic here -->
                <div class="text-center py-8 text-gray-500">
                    <p>Fitur rekomendasi buku akan segera hadir.</p>
                    <a href="{{ route('member.books.index', ['category' => $book->category_id]) }}"
                        class="text-indigo-600 hover:text-indigo-500 font-medium">
                        Lihat semua buku dalam kategori ini →
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layout>
