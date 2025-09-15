<x-layout>
    <x-slot:title>Riwayat Peminjaman - Perpustakaan</x-slot:title>

    <div class="bg-white">
        <div class="mx-auto max-w-7xl py-8 px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-2">
                    Riwayat Peminjaman Saya
                </h1>
                <p class="text-gray-600">Kelola dan pantau status peminjaman buku Anda</p>
            </div>

            <!-- Filter -->
            <div class="mb-6">
                <form method="GET" action="{{ route('member.borrowings.index') }}"
                    class="flex flex-wrap gap-4 items-end">
                    <div class="min-w-0 flex-1">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Filter Status</label>
                        <select name="status" id="status"
                            class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Semua Status</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Dipinjam
                            </option>
                            <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>
                                Dikembalikan</option>
                            <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Terlambat
                            </option>
                        </select>
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Filter
                        </button>
                        <a href="{{ route('member.borrowings.index') }}"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Borrowings List -->
            @if ($borrowings->count() > 0)
                <div class="space-y-4 mb-8">
                    @foreach ($borrowings as $borrowing)
                        <div
                            class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="p-6">
                                <div class="flex flex-col lg:flex-row lg:items-center justify-between">
                                    <!-- Book Info -->
                                    <div class="flex items-start space-x-4 mb-4 lg:mb-0">
                                        <!-- Book Image -->
                                        <div class="flex-shrink-0 w-16 h-20 bg-gray-200 rounded overflow-hidden">
                                            @if ($borrowing->book->image)
                                                <img src="{{ asset('storage/' . $borrowing->book->image) }}"
                                                    alt="{{ $borrowing->book->title }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Book Details -->
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                                {{ $borrowing->book->title }}
                                            </h3>
                                            <p class="text-sm text-gray-600 mb-1">
                                                oleh {{ $borrowing->book->author }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                Kategori: {{ $borrowing->book->category->name }}
                                            </p>

                                            <!-- Status Badge -->
                                            <div class="mt-2">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    @if ($borrowing->status == 'approved') bg-green-100 text-green-800
                                                    @elseif($borrowing->status == 'returned') bg-gray-100 text-gray-800
                                                    @elseif($borrowing->status == 'overdue') bg-red-100 text-red-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ $borrowing->status_text }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Dates and Actions -->
                                    <div class="lg:text-right space-y-2">
                                        <!-- Dates -->
                                        <div class="text-sm text-gray-600 space-y-1">
                                            <div>
                                                <span class="font-medium">Diajukan:</span>
                                                {{ $borrowing->created_at->format('d/m/Y H:i') }}
                                            </div>
                                            @if ($borrowing->borrowed_date)
                                                <div>
                                                    <span class="font-medium">Dipinjam:</span>
                                                    {{ \Carbon\Carbon::parse($borrowing->borrowed_date)->format('d/m/Y') }}
                                                </div>
                                            @endif
                                            @if ($borrowing->due_date)
                                                <div class="{{ $borrowing->isOverdue() ? 'text-red-600' : '' }}">
                                                    <span class="font-medium">Batas Kembali:</span>
                                                    {{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}
                                                </div>
                                            @endif
                                            @if ($borrowing->returned_date && $borrowing->status == 'returned')
                                                <div>
                                                    <span class="font-medium">Dikembalikan:</span>
                                                    {{ \Carbon\Carbon::parse($borrowing->returned_date)->format('d/m/Y') }}
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex lg:justify-end space-x-2 mt-4">
                                            <a href="{{ route('member.borrowings.show', $borrowing) }}"
                                                class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded text-sm font-medium transition-colors">
                                                Detail
                                            </a>

                                            @if (in_array($borrowing->status, ['approved', 'overdue']))
                                                <form
                                                    action="{{ route('member.borrowings.request-return', $borrowing) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        onclick="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?')"
                                                        class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm font-medium transition-colors">
                                                        Kembalikan
                                                    </button>
                                                </form>
                                            @endif
                                        </div>

                                        <!-- Notes -->
                                        @if ($borrowing->notes)
                                            <div class="text-xs text-gray-500 italic mt-2 lg:max-w-xs">
                                                "{{ $borrowing->notes }}"
                                            </div>
                                        @endif

                                        @if ($borrowing->admin_notes)
                                            <div class="text-xs text-gray-600 mt-2 lg:max-w-xs">
                                                <span class="font-medium">Catatan Admin:</span>
                                                "{{ $borrowing->admin_notes }}"
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $borrowings->links() }}
                </div>
            @else
                <!-- No Borrowings Found -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                        </path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada riwayat peminjaman</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai jelajahi katalog buku dan lakukan peminjaman pertama
                        Anda.</p>
                    <div class="mt-6">
                        <a href="{{ route('member.books.index') }}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Jelajahi Buku
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layout>
