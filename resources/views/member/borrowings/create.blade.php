<x-layout>
    <x-slot:title>Form Peminjaman - {{ $book->title }}</x-slot:title>

    <div class="bg-white">
        <div class="mx-auto max-w-3xl py-8 px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('member.books.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
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
                            <a href="{{ route('member.books.show', $book) }}"
                                class="ml-1 text-sm font-medium text-gray-700 hover:text-indigo-600 md:ml-2">
                                {{ Str::limit($book->title, 30) }}
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Form Peminjaman</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Header -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-2">
                    Form Peminjaman Buku
                </h1>
                <p class="text-gray-600">Lengkapi informasi berikut untuk mengajukan peminjaman buku</p>
            </div>

            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- Book Summary -->
                <div class="bg-gray-50 px-6 py-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Buku yang akan dipinjam:</h3>
                    <div class="flex items-center space-x-4">
                        <!-- Book Image -->
                        <div class="flex-shrink-0 w-20 h-24 bg-gray-200 rounded overflow-hidden">
                            @if ($book->image)
                                <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Book Details -->
                        <div>
                            <h4 class="text-xl font-semibold text-gray-900">{{ $book->title }}</h4>
                            <p class="text-gray-600">oleh {{ $book->author }}</p>
                            <p class="text-sm text-gray-500">Kategori: {{ $book->category->name }}</p>
                            <p class="text-sm text-gray-500">Tahun: {{ $book->publication_year }}</p>
                            <div class="mt-2">
                                <span
                                    class="inline-flex items-center text-sm font-medium text-green-800 bg-green-100 px-2 py-1 rounded-full">
                                    <span class="w-2 h-2 mr-1.5 bg-green-400 rounded-full"></span>
                                    Tersedia ({{ $book->available_stock }} eksemplar)
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('member.borrowings.store', $book) }}" method="POST" class="p-6">
                    @csrf

                    <!-- Borrowing Rules -->
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h4 class="text-sm font-medium text-blue-900 mb-2">Ketentuan Peminjaman:</h4>
                        <ul class="text-sm text-blue-800 space-y-1">
                            <li>• Maksimal peminjaman 3 buku per anggota</li>
                            <li>• Lama peminjaman 14 hari dari tanggal persetujuan</li>
                            <li>• Buku harus dikembalikan dalam kondisi baik</li>
                        </ul>
                    </div>

                    <!-- User Information -->
                    <div class="mb-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Informasi Peminjam</h4>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ auth()->user()->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mb-6">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan Tambahan (Opsional)
                        </label>
                        <textarea name="notes" id="notes" rows="3"
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Tulis catatan atau keperluan peminjaman buku ini...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Agreement -->
                    <div class="mb-6">
                        <div class="flex items-start">
                            <input type="checkbox" id="agreement" name="agreement" required
                                class="flex-shrink-0 mt-0.5 h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="agreement" class="ml-3 text-sm text-gray-700">
                                Saya menyetujui ketentuan peminjaman di atas dan berkomitmen untuk mengembalikan buku
                                tepat waktu dalam kondisi baik.
                                <span class="text-red-600">*</span>
                            </label>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex flex-col sm:flex-row sm:justify-end sm:space-x-3 space-y-3 sm:space-y-0">
                        <a href="{{ route('member.books.show', $book) }}"
                            class="w-full sm:w-auto bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-center py-2 px-4 rounded-md font-medium transition-colors duration-200">
                            Batal
                        </a>
                        <button type="submit"
                            class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-6 rounded-md font-medium transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Ajukan Peminjaman
                        </button>
                    </div>
                </form>
            </div>

            <!-- Additional Info -->
            <div class="mt-8 text-center text-sm text-gray-600">
                <p>Setelah mengajukan peminjaman, Anda akan menerima notifikasi ketika admin menyetujui atau menolak
                    permintaan Anda.</p>
                <p class="mt-1">Silakan bawa kartu identitas saat mengambil buku di perpustakaan.</p>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Auto-resize textarea
            const textarea = document.getElementById('notes');
            if (textarea) {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = (this.scrollHeight) + 'px';
                });
            }
        </script>
    @endpush
</x-layout>
