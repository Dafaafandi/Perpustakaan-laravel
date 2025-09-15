<x-layout>

    @push('styles')
        <style>
            .badge {
                font-size: 0.875rem;
            }

            .select2-container {
                width: 100% !important;
            }

            .text-danger {
                color: #e74a3b !important;
            }

            .border-left-primary {
                border-left: .25rem solid #4e73df !important;
            }

            .border-left-warning {
                border-left: .25rem solid #f6c23e !important;
            }

            .border-left-success {
                border-left: .25rem solid #1cc88a !important;
            }

            .border-left-danger {
                border-left: .25rem solid #e74a3b !important;
            }

            .border-left-info {
                border-left: .25rem solid #36b9cc !important;
            }

            .border-left-dark {
                border-left: .25rem solid #5a5c69 !important;
            }
        </style>
    @endpush

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="container-fluid">
        <!-- Header -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="stat-total">0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-book fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Dipinjam</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="stat-dipinjam">0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-book-open fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Dikembalikan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="stat-dikembalikan">0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-undo fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-3">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Terlambat</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="stat-terlambat">0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-0 font-weight-bold text-primary">Filter & Search</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="member-search">Cari Member:</label>
                        <select class="form-control select2" id="member-search" style="width: 100%;">
                            <option value="">Pilih Member...</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>&nbsp;</label>
                        <div class="d-block">
                            <button type="button" class="btn btn-primary" id="apply-filters">
                                <i class="fas fa-search"></i> Terapkan Filter
                            </button>
                            <button type="button" class="btn btn-secondary" id="reset-filters">
                                <i class="fas fa-refresh"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Peminjaman Buku</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="borrowingTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Member</th>
                                <th>Email</th>
                                <th>Judul Buku</th>
                                <th>Pengarang</th>
                                <th>Kategori</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Tgl Dikembalikan</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                console.log('Document ready - jQuery version:', $.fn.jquery);
                console.log('DataTables version:', $.fn.DataTable ? $.fn.DataTable.version : 'Not available');

                // Global error handler untuk menangkap JavaScript errors
                window.onerror = function(message, source, lineno, colno, error) {
                    console.error('Global JavaScript Error:', {
                        message: message,
                        source: source,
                        line: lineno,
                        column: colno,
                        error: error
                    });
                    return false;
                };

                // Validation
                console.log('Table DOM element exists:', document.getElementById('borrowingTable') !== null);
                console.log('DataTables constructor available:', typeof $.fn.DataTable !== 'undefined');

                // Initialize Select2 for member search
                $('#member-search').select2({
                    ajax: {
                        url: '{{ route('admin.borrowing.search-members') }}',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term
                            };
                        },
                        processResults: function(data) {
                            console.log('Select2 search results:', data);
                            return {
                                results: data
                            };
                        },
                        cache: true
                    },
                    placeholder: 'Cari member...',
                    minimumInputLength: 2,
                    allowClear: true
                });

                // Kembali ke server-side processing yang sudah diperbaiki
                console.log('Initializing server-side DataTable...');

                var table = $('#borrowingTable').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: true,
                    ajax: {
                        url: '{{ route('admin.borrowing.index') }}',
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        data: function(d) {
                            d.member_id = $('#member-search').val();
                            console.log('Server-side request data:', d);
                            console.log('Search value:', d.search.value);
                            return d;
                        },
                        error: function(xhr, error, code) {
                            console.error('Server-side AJAX Error:', error);
                            console.error('Response:', xhr.responseText);
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'member',
                            name: 'user.name'
                        },
                        {
                            data: 'member_email',
                            name: 'user.email'
                        },
                        {
                            data: 'book_title',
                            name: 'book.title'
                        },
                        {
                            data: 'book_author',
                            name: 'book.author'
                        },
                        {
                            data: 'category',
                            name: 'book.category.name'
                        },
                        {
                            data: 'borrow_date',
                            name: 'borrowed_date'
                        },
                        {
                            data: 'due_date',
                            name: 'due_date'
                        },
                        {
                            data: 'return_date',
                            name: 'returned_date'
                        }
                    ],
                    order: [
                        [6, 'desc']
                    ],
                    pageLength: 25,
                    lengthMenu: [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data per halaman",
                        zeroRecords: "Data tidak ditemukan",
                        info: "Menampilkan halaman _PAGE_ dari _PAGES_",
                        infoEmpty: "Tidak ada data yang tersedia",
                        infoFiltered: "(difilter dari _MAX_ total data)",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Selanjutnya",
                            previous: "Sebelumnya"
                        },
                        processing: "Memproses..."
                    },
                    drawCallback: function(settings) {
                        console.log('=== SERVER-SIDE DRAW CALLBACK ===');
                        console.log('Rows rendered:', this.api().rows().count());
                        console.log('Total records:', settings.json ? settings.json.recordsTotal :
                            'unknown');
                        console.log('Filtered records:', settings.json ? settings.json.recordsFiltered :
                            'unknown');
                    }
                });

                console.log('DataTable initialization complete');
                console.log('Table DOM element exists:', $('#borrowingTable').length > 0);

                // Load statistics
                loadStatistics();

                // Add search event listener for debugging
                $('#borrowingTable_filter input').on('keyup', function() {
                    console.log('Search input changed to:', this.value);
                });

                // Apply filters
                $('#apply-filters').click(function() {
                    console.log('Apply filters clicked');
                    table.draw();
                });

                // Reset filters
                $('#reset-filters').click(function() {
                    console.log('Reset filters clicked');
                    $('#member-search').val(null).trigger('change');
                    table.draw();
                });

                // Load statistics
                function loadStatistics() {
                    $.get('{{ route('admin.borrowing.statistics') }}', function(data) {
                        $('#stat-total').text(data.total);
                        $('#stat-dipinjam').text(data.dipinjam);
                        $('#stat-dikembalikan').text(data.dikembalikan);
                        $('#stat-terlambat').text(data.terlambat);
                    });
                }
            });
        </script>
    @endpush
</x-layout>
