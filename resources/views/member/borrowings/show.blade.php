<x-layout>
    <x-slot:title>Detail Peminjaman - {{ $borrowing->book->title }}</x-slot:title>

    <div class="bg-white">
        <div class="mx-auto max-w-4xl py-8 px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('member.borrowings.index') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
                            Riwayat Peminjaman
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Detail Peminjaman</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-2">
                    Detail Peminjaman
                </h1>
                <p class="text-gray-600">ID Peminjaman: #{{ $borrowing->id }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Book Information -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Informasi Buku</h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-start space-x-4">
                                <!-- Book Image -->
                                <div class="flex-shrink-0 w-24 h-32 bg-gray-200 rounded overflow-hidden">
                                    @if ($borrowing->book->image)
                                        <img src="{{ asset('storage/' . $borrowing->book->image) }}"
                                            alt="{{ $borrowing->book->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Book Details -->
                                <div class="flex-1">
                                    <h4 class="text-xl font-semibold text-gray-900 mb-2">{{ $borrowing->book->title }}
                                    </h4>
                                    <div class="space-y-1 text-sm text-gray-600">
                                        <p><span class="font-medium">Penulis:</span> {{ $borrowing->book->author }}</p>
                                        <p><span class="font-medium">Kategori:</span>
                                            {{ $borrowing->book->category->name }}</p>
                                        <p><span class="font-medium">Tahun Terbit:</span>
                                            {{ $borrowing->book->publication_year }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Borrowing Timeline -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Timeline Peminjaman</h3>
                        </div>
                        <div class="p-6">
                            <div class="flow-root">
                                <ul class="-mb-8">
                                    <!-- Request Submitted -->
                                    <li>
                                        <div class="relative pb-8">
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                                                aria-hidden="true"></span>
                                            <div class="relative flex space-x-3">
                                                <div
                                                    class="h-8 w-8 bg-blue-500 rounded-full flex items-center justify-center ring-8 ring-white">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                    </svg>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5">
                                                    <p class="text-sm text-gray-500">Peminjaman diajukan pada <time
                                                            class="font-medium text-gray-900">{{ $borrowing->created_at->format('d/m/Y H:i') }}</time>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>

                                    @if (in_array($borrowing->status, ['approved', 'returned', 'overdue']))
                                        <!-- Approved -->
                                        <li>
                                            <div class="relative pb-8">
                                                @if ($borrowing->status == 'returned')
                                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                                                        aria-hidden="true"></span>
                                                @endif
                                                <div class="relative flex space-x-3">
                                                    <div
                                                        class="h-8 w-8 bg-green-500 rounded-full flex items-center justify-center ring-8 ring-white">
                                                        <svg class="w-4 h-4 text-white" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="min-w-0 flex-1 pt-1.5">
                                                        <p class="text-sm text-gray-500">Peminjaman disetujui pada
                                                            <time class="font-medium text-gray-900">
                                                                {{ $borrowing->approved_at ? $borrowing->approved_at->format('d/m/Y H:i') : '-' }}
                                                            </time>
                                                        </p>
                                                        @if ($borrowing->borrowed_date)
                                                            <p class="text-sm text-gray-500">Buku dipinjam pada
                                                                <time class="font-medium text-gray-900">
                                                                    {{ \Carbon\Carbon::parse($borrowing->borrowed_date)->format('d/m/Y') }}
                                                                </time>
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif

                                    @if ($borrowing->status == 'returned')
                                        <!-- Returned -->
                                        <li>
                                            <div class="relative">
                                                <div class="relative flex space-x-3">
                                                    <div
                                                        class="h-8 w-8 bg-gray-500 rounded-full flex items-center justify-center ring-8 ring-white">
                                                        <svg class="w-4 h-4 text-white" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <div class="min-w-0 flex-1 pt-1.5">
                                                        <p class="text-sm text-gray-500">Buku dikembalikan pada
                                                            <time class="font-medium text-gray-900">
                                                                {{ $borrowing->returned_date ? \Carbon\Carbon::parse($borrowing->returned_date)->format('d/m/Y H:i') : '-' }}
                                                            </time>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif

                                    @if ($borrowing->status == 'rejected')
                                        <!-- Rejected -->
                                        <li>
                                            <div class="relative">
                                                <div class="relative flex space-x-3">
                                                    <div
                                                        class="h-8 w-8 bg-red-500 rounded-full flex items-center justify-center ring-8 ring-white">
                                                        <svg class="w-4 h-4 text-white" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="min-w-0 flex-1 pt-1.5">
                                                        <p class="text-sm text-gray-500">Peminjaman ditolak</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if ($borrowing->notes || $borrowing->admin_notes)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Catatan</h3>
                            </div>
                            <div class="p-6 space-y-4">
                                @if ($borrowing->notes)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900 mb-1">Catatan Anda:</h4>
                                        <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded">
                                            {{ $borrowing->notes }}</p>
                                    </div>
                                @endif

                                @if ($borrowing->admin_notes)
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900 mb-1">Catatan Admin:</h4>
                                        <p class="text-sm text-gray-600 bg-blue-50 p-3 rounded">
                                            {{ $borrowing->admin_notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Status Card -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Status</h3>
                        </div>
                        <div class="p-6">
                            <div class="text-center">
                                <span
                                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                                    @if ($borrowing->status == 'approved') bg-green-100 text-green-800
                                    @elseif($borrowing->status == 'returned') bg-gray-100 text-gray-800
                                    @elseif($borrowing->status == 'overdue') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $borrowing->status_text }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Important Dates -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Tanggal Penting</h3>
                        </div>
                        <div class="p-6 space-y-3">
                            @if ($borrowing->borrowed_date)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Tanggal Pinjam:</span>
                                    <span
                                        class="font-medium">{{ \Carbon\Carbon::parse($borrowing->borrowed_date)->format('d/m/Y') }}</span>
                                </div>
                            @endif

                            @if ($borrowing->due_date)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Batas Kembali:</span>
                                    <span class="font-medium {{ $borrowing->isOverdue() ? 'text-red-600' : '' }}">
                                        {{ \Carbon\Carbon::parse($borrowing->due_date)->format('d/m/Y') }}
                                    </span>
                                </div>
                                @if ($borrowing->status == 'approved')
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Sisa Waktu:</span>
                                        <span
                                            class="font-medium {{ $borrowing->isOverdue() ? 'text-red-600' : 'text-green-600' }}">
                                            @if ($borrowing->isOverdue())
                                                Terlambat
                                                {{ \Carbon\Carbon::parse($borrowing->due_date)->diffInDays(now()) }}
                                                hari
                                            @else
                                                {{ \Carbon\Carbon::parse($borrowing->due_date)->diffInDays(now()) }}
                                                hari lagi
                                            @endif
                                        </span>
                                    </div>
                                @endif
                            @endif

                            @if ($borrowing->returned_date && $borrowing->status == 'returned')
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Tanggal Kembali:</span>
                                    <span
                                        class="font-medium">{{ \Carbon\Carbon::parse($borrowing->returned_date)->format('d/m/Y') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Fine Information -->
                    @if ($borrowing->fine_amount && $borrowing->fine_amount > 0)
                        <div class="bg-white border border-red-200 rounded-lg shadow-sm">
                            <div class="px-6 py-4 border-b border-red-200">
                                <h3 class="text-lg font-medium text-red-900">Denda</h3>
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Aksi</h3>
                        </div>
                        <div class="p-6 space-y-3">
                            {{-- Action button removed since pending status no longer exists --}}

                            @if (in_array($borrowing->status, ['approved', 'overdue']))
                                <form action="{{ route('member.borrowings.request-return', $borrowing) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit"
                                        onclick="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?')"
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md font-medium transition-colors">
                                        Kembalikan Buku
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('member.borrowings.index') }}"
                                class="w-full block text-center bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-md font-medium transition-colors">
                                Kembali ke Riwayat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
