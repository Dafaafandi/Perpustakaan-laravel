<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        </div>

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

    <!-- Approve Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">Setujui Peminjaman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menyetujui peminjaman ini?</p>
                    <div class="form-group">
                        <label for="approve-notes">Catatan Admin (Opsional):</label>
                        <textarea class="form-control" id="approve-notes" rows="3" placeholder="Masukkan catatan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" id="confirm-approve">Ya, Setujui</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Tolak Peminjaman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menolak peminjaman ini?</p>
                    <div class="form-group">
                        <label for="reject-notes">Alasan Penolakan:</label>
                        <textarea class="form-control" id="reject-notes" rows="3" placeholder="Masukkan alasan penolakan..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirm-reject">Ya, Tolak</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Return Modal -->
    <div class="modal fade" id="returnModal" tabindex="-1" role="dialog" aria-labelledby="returnModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="returnModalLabel">Kembalikan Buku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Konfirmasi pengembalian buku ini?</p>
                    <div class="form-group">
                        <label for="return-notes">Catatan (Opsional):</label>
                        <textarea class="form-control" id="return-notes" rows="3" placeholder="Kondisi buku, denda, dll..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="confirm-return">Ya, Kembalikan</button>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

    @push('scripts')
        <!-- Select2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
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

                // Initialize DataTable
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

                loadStatistics();

                // Add search event listener for debugging
                $('#borrowingTable_filter input').on('keyup', function() {
                    console.log('Search input changed to:', this.value);
                });

                $('#apply-filters').click(function() {
                    console.log('Apply filters clicked');
                    table.draw();
                });

                $('#reset-filters').click(function() {
                    console.log('Reset filters clicked');
                    $('#member-search').val(null).trigger('change');
                    table.draw();
                });

                // Approve button click
                $(document).on('click', '.approve-btn', function() {
                    var id = $(this).data('id');
                    $('#approveModal').data('id', id).modal('show');
                });

                // Reject button click
                $(document).on('click', '.reject-btn', function() {
                    var id = $(this).data('id');
                    $('#rejectModal').data('id', id).modal('show');
                });

                // Return button click
                $(document).on('click', '.return-btn', function() {
                    var id = $(this).data('id');
                    $('#returnModal').data('id', id).modal('show');
                });

                // Confirm approve
                $('#confirm-approve').click(function() {
                    var id = $('#approveModal').data('id');
                    var notes = $('#approve-notes').val();

                    $.ajax({
                        url: '/admin/borrowing/' + id + '/approve',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            admin_notes: notes
                        },
                        success: function(response) {
                            $('#approveModal').modal('hide');
                            if (response.success) {
                                Swal.fire('Berhasil!', response.message, 'success');
                                table.draw();
                                loadStatistics();
                            }
                        },
                        error: function(xhr) {
                            var response = JSON.parse(xhr.responseText);
                            Swal.fire('Error!', response.message, 'error');
                        }
                    });
                });

                // Confirm reject
                $('#confirm-reject').click(function() {
                    var id = $('#rejectModal').data('id');
                    var notes = $('#reject-notes').val();

                    if (!notes) {
                        Swal.fire('Error!', 'Alasan penolakan harus diisi.', 'error');
                        return;
                    }

                    $.ajax({
                        url: '/admin/borrowing/' + id + '/reject',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            admin_notes: notes
                        },
                        success: function(response) {
                            $('#rejectModal').modal('hide');
                            if (response.success) {
                                Swal.fire('Berhasil!', response.message, 'success');
                                table.draw();
                                loadStatistics();
                            }
                        },
                        error: function(xhr) {
                            var response = JSON.parse(xhr.responseText);
                            Swal.fire('Error!', response.message, 'error');
                        }
                    });
                });

                // Confirm return
                $('#confirm-return').click(function() {
                    var id = $('#returnModal').data('id');
                    var notes = $('#return-notes').val();

                    $.ajax({
                        url: '/admin/borrowing/' + id + '/return',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            admin_notes: notes
                        },
                        success: function(response) {
                            $('#returnModal').modal('hide');
                            if (response.success) {
                                Swal.fire('Berhasil!', response.message, 'success');
                                table.draw();
                                loadStatistics();
                            }
                        },
                        error: function(xhr) {
                            var response = JSON.parse(xhr.responseText);
                            Swal.fire('Error!', response.message, 'error');
                        }
                    });
                });

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
