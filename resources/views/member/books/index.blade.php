<x-layout>
    <x-slot:title>Daftar Buku - Perpustakaan</x-slot:title>

    <div class="bg-white">
        <div class="mx-auto max-w-7xl py-8 px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-2">
                    Katalog Buku
                </h1>
                <p class="text-gray-600">Jelajahi koleksi buku perpustakaan dan lakukan peminjaman</p>
            </div>

            <!-- Search and Filters -->
            <div class="mb-6 space-y-4">
                <form method="GET" action="{{ route('member.books.index') }}" class="space-y-4">
                    <!-- Search Bar -->
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari judul buku, penulis, atau kategori..."
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <!-- Filters Row -->
                    <div class="flex flex-wrap gap-4 items-end">
                        <!-- Category Filter -->
                        <div class="min-w-0 flex-1">
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select name="category" id="category"
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sort By -->
                        <div class="min-w-0 flex-1">
                            <label for="sort_by" class="block text-sm font-medium text-gray-700 mb-1">Urutkan</label>
                            <select name="sort_by" id="sort_by"
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="title" {{ request('sort_by', 'title') == 'title' ? 'selected' : '' }}>
                                    Judul</option>
                                <option value="author" {{ request('sort_by') == 'author' ? 'selected' : '' }}>Penulis
                                </option>
                                <option value="publication_year"
                                    {{ request('sort_by') == 'publication_year' ? 'selected' : '' }}>Tahun Terbit
                                </option>
                                <option value="available_stock"
                                    {{ request('sort_by') == 'available_stock' ? 'selected' : '' }}>Stok Tersedia
                                </option>
                            </select>
                        </div>

                        <!-- Sort Order -->
                        <div class="min-w-0 flex-1">
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                            <select name="sort_order" id="sort_order"
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="asc" {{ request('sort_order', 'asc') == 'asc' ? 'selected' : '' }}>A-Z
                                    / Terlama</option>
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Z-A /
                                    Terbaru</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="flex space-x-2">
                            <button type="submit"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                Filter
                            </button>
                            <a href="{{ route('member.books.index') }}"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Results Info -->
            <div class="mb-4 text-sm text-gray-600">
                Menampilkan {{ $books->firstItem() ?? 0 }} - {{ $books->lastItem() ?? 0 }} dari {{ $books->total() }}
                buku
            </div>

            <!-- Books Grid -->
            @if ($books->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                    @foreach ($books as $book)
                        <div
                            class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                            <!-- Book Image -->
                            <div class="aspect-w-3 aspect-h-4 bg-gray-200">
                                @if ($book->image)
                                    <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                                        class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 flex items-center justify-center bg-gray-100">
                                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Book Info -->
                            <div class="p-4">
                                <div class="mb-2">
                                    <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">
                                        {{ $book->category->name }}
                                    </span>
                                </div>

                                <h3 class="font-semibold text-lg text-gray-900 mb-1 line-clamp-2">
                                    {{ $book->title }}
                                </h3>

                                <p class="text-gray-600 text-sm mb-2">
                                    oleh {{ $book->author }}
                                </p>

                                <p class="text-gray-500 text-xs mb-3">
                                    Tahun {{ $book->publication_year }}
                                </p>

                                <!-- Stock Status -->
                                <div class="mb-3">
                                    <span
                                        class="inline-flex items-center text-xs font-medium
                                        @if ($book->available_stock > 2) text-green-800 bg-green-100
                                        @elseif($book->available_stock > 0) text-yellow-800 bg-yellow-100
                                        @else text-red-800 bg-red-100 @endif
                                        px-2 py-1 rounded-full">
                                        <span
                                            class="w-1.5 h-1.5 mr-1.5 rounded-full
                                            @if ($book->available_stock > 2) bg-green-400
                                            @elseif($book->available_stock > 0) bg-yellow-400
                                            @else bg-red-400 @endif">
                                        </span>
                                        {{ $book->stock_status }} ({{ $book->available_stock }})
                                    </span>
                                </div>

                                <!-- Action Button -->
                                <div class="flex space-x-2">
                                    <a href="{{ route('member.books.show', $book) }}"
                                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white text-center py-2 px-3 rounded text-sm font-medium transition-colors">
                                        Lihat Detail
                                    </a>

                                    @if ($book->isAvailable())
                                        <a href="{{ route('member.borrowings.create', $book) }}"
                                            class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center py-2 px-3 rounded text-sm font-medium transition-colors">
                                            Pinjam
                                        </a>
                                    @else
                                        <span
                                            class="flex-1 bg-gray-300 text-gray-500 text-center py-2 px-3 rounded text-sm font-medium cursor-not-allowed">
                                            Tidak Tersedia
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $books->links() }}
                </div>
            @else
                <!-- No Books Found -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada buku ditemukan</h3>
                    <p class="mt-1 text-sm text-gray-500">Coba ubah kriteria pencarian atau filter Anda.</p>
                </div>
            @endif
        </div>
    </div>

    @push('styles')
        <style>
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
        </style>
    @endpush
</x-layout>
