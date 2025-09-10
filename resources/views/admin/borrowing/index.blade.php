<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="container-fluid">
        <!-- Header -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-2 col-md-4 mb-3">
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

            <div class="col-xl-2 col-md-4 mb-3">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pending</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="stat-pending">0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 mb-3">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Dipinjam</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="stat-approved">0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 mb-3">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Terlambat</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="stat-overdue">0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 mb-3">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Dikembalikan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="stat-returned">0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-undo fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-4 mb-3">
                <div class="card border-left-dark shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                    Ditolak</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" id="stat-rejected">0</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times fa-2x text-gray-300"></i>
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
                    <div class="col-md-3">
                        <label for="status-filter">Status:</label>
                        <select class="form-control" id="status-filter">
                            <option value="">Semua Status</option>
                            <option value="pending">Pending</option>
                            <option value="approved">Dipinjam</option>
                            <option value="returned">Dikembalikan</option>
                            <option value="overdue">Terlambat</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="member-search">Cari Member:</label>
                        <select class="form-control select2" id="member-search" style="width: 100%;">
                            <option value="">Pilih Member...</option>
                        </select>
                    </div>
                    <div class="col-md-3">
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
                                <th>Status</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Tgl Dikembalikan</th>
                                <th>Denda</th>
                                <th>Disetujui Oleh</th>
                                <th>Aksi</th>
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
                    ajax: {
                        url: '{{ route('admin.borrowing.index') }}',
                        data: function(d) {
                            d.status = $('#status-filter').val();
                            d.member_id = $('#member-search').val();
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
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
                            data: 'status',
                            name: 'status',
                            orderable: false
                        },
                        {
                            data: 'borrowed_date',
                            name: 'borrowed_date'
                        },
                        {
                            data: 'due_date',
                            name: 'due_date'
                        },
                        {
                            data: 'returned_date',
                            name: 'returned_date'
                        },
                        {
                            data: 'fine_amount',
                            name: 'fine_amount',
                            orderable: false
                        },
                        {
                            data: 'approved_by',
                            name: 'approvedBy.name'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    order: [
                        [0, 'desc']
                    ],
                    pageLength: 25,
                    responsive: true
                });

                // Load statistics
                loadStatistics();

                // Apply filters
                $('#apply-filters').click(function() {
                    table.draw();
                });

                // Reset filters
                $('#reset-filters').click(function() {
                    $('#status-filter').val('');
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

                // Load statistics
                function loadStatistics() {
                    $.get('{{ route('admin.borrowing.statistics') }}', function(data) {
                        $('#stat-total').text(data.total);
                        $('#stat-pending').text(data.pending);
                        $('#stat-approved').text(data.approved);
                        $('#stat-overdue').text(data.overdue);
                        $('#stat-returned').text(data.returned);
                        $('#stat-rejected').text(data.rejected);
                    });
                }
            });
        </script>
    @endpush
</x-layout>
