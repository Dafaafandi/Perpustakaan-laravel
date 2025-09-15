<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <a href="{{ route('admin.borrowing.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Detail Peminjaman</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="font-weight-bold">ID Peminjaman</td>
                                        <td>: #{{ $borrowing->id }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Status</td>
                                        <td>:
                                            <span class="badge badge-{{ $borrowing->status_badge }}">
                                                {{ $borrowing->status_text }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Tanggal Request</td>
                                        <td>: {{ $borrowing->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    @if ($borrowing->borrowed_date)
                                        <tr>
                                            <td class="font-weight-bold">Tanggal Pinjam</td>
                                            <td>: {{ $borrowing->borrowed_date->format('d/m/Y') }}</td>
                                        </tr>
                                    @endif
                                    @if ($borrowing->due_date)
                                        <tr>
                                            <td class="font-weight-bold">Tanggal Kembali</td>
                                            <td>: {{ $borrowing->due_date->format('d/m/Y') }}
                                                @if ($borrowing->isOverdue())
                                                    <span class="text-danger">
                                                        ({{ \Carbon\Carbon::parse($borrowing->due_date)->diffInDays(now()) }}
                                                        hari terlambat)
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($borrowing->returned_date)
                                        <tr>
                                            <td class="font-weight-bold">Tanggal Dikembalikan</td>
                                            <td>: {{ $borrowing->returned_date->format('d/m/Y') }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="font-weight-bold">Denda</td>
                                        <td>:
                                            @if ($borrowing->fine_amount > 0)
                                                <span class="text-danger">
                                                    Rp {{ number_format($borrowing->fine_amount, 0, ',', '.') }}
                                                </span>
                                            @elseif($borrowing->status === 'approved' && $borrowing->isOverdue())
                                                <span class="text-danger">
                                                    Rp {{ number_format($borrowing->calculateFine(), 0, ',', '.') }}
                                                    (estimasi)
                                                </span>
                                            @else
                                                Rp 0
                                            @endif
                                        </td>
                                    </tr>
                                    @if ($borrowing->approvedBy)
                                        <tr>
                                            <td class="font-weight-bold">Disetujui Oleh</td>
                                            <td>: {{ $borrowing->approvedBy->name }}</td>
                                        </tr>
                                    @endif
                                    @if ($borrowing->approved_at)
                                        <tr>
                                            <td class="font-weight-bold">Waktu Persetujuan</td>
                                            <td>: {{ $borrowing->approved_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>

                        @if ($borrowing->notes)
                            <div class="mt-3">
                                <h6 class="font-weight-bold">Catatan Member:</h6>
                                <p class="text-muted">{{ $borrowing->notes }}</p>
                            </div>
                        @endif

                        @if ($borrowing->admin_notes)
                            <div class="mt-3">
                                <h6 class="font-weight-bold">Catatan Admin:</h6>
                                <p class="text-muted">{{ $borrowing->admin_notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Member</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            @if ($borrowing->user->image)
                                <img class="img-profile rounded-circle"
                                    src="{{ asset('storage/' . $borrowing->user->image) }}"
                                    style="width: 80px; height: 80px;">
                            @else
                                <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 80px;">
                                    <i class="fas fa-user fa-2x text-white"></i>
                                </div>
                            @endif
                        </div>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="font-weight-bold">Nama</td>
                                <td>{{ $borrowing->user->name }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Email</td>
                                <td>{{ $borrowing->user->email }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Peminjaman Aktif</td>
                                <td>{{ $borrowing->user->activeBorrowings()->count() }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Total Denda</td>
                                <td>
                                    @php $totalFine = $borrowing->user->getTotalFine(); @endphp
                                    @if ($totalFine > 0)
                                        <span class="text-danger">
                                            Rp {{ number_format($totalFine, 0, ',', '.') }}
                                        </span>
                                    @else
                                        Rp 0
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Informasi Buku</h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            @if ($borrowing->book->image)
                                <img src="{{ asset('storage/' . $borrowing->book->image) }}"
                                    alt="{{ $borrowing->book->title }}" class="img-fluid rounded"
                                    style="max-height: 150px;">
                            @else
                                <div class="bg-light border rounded d-flex align-items-center justify-content-center"
                                    style="height: 150px;">
                                    <i class="fas fa-book fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="font-weight-bold">Judul</td>
                                <td>{{ $borrowing->book->title }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Pengarang</td>
                                <td>{{ $borrowing->book->author }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Kategori</td>
                                <td>{{ $borrowing->book->category->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Tahun Terbit</td>
                                <td>{{ $borrowing->book->publication_year }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">Stok Tersedia</td>
                                <td>{{ $borrowing->book->available_stock }}/{{ $borrowing->book->stock }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        @if ($borrowing->status === 'pending')
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <button type="button" class="btn btn-success btn-lg mr-2" id="approve-btn"
                                data-id="{{ $borrowing->id }}">
                                <i class="fas fa-check"></i> Setujui Peminjaman
                            </button>
                            <button type="button" class="btn btn-danger btn-lg" id="reject-btn"
                                data-id="{{ $borrowing->id }}">
                                <i class="fas fa-times"></i> Tolak Peminjaman
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($borrowing->status === 'approved')
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <button type="button" class="btn btn-primary btn-lg" id="return-btn"
                                data-id="{{ $borrowing->id }}">
                                <i class="fas fa-undo"></i> Kembalikan Buku
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

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

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#approve-btn').click(function() {
                    var id = $(this).data('id');
                    $('#approveModal').data('id', id).modal('show');
                });

                $('#reject-btn').click(function() {
                    var id = $(this).data('id');
                    $('#rejectModal').data('id', id).modal('show');
                });

                $('#return-btn').click(function() {
                    var id = $(this).data('id');
                    $('#returnModal').data('id', id).modal('show');
                });

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
                                Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                    location.reload();
                                });
                            }
                        },
                        error: function(xhr) {
                            var response = JSON.parse(xhr.responseText);
                            Swal.fire('Error!', response.message, 'error');
                        }
                    });
                });

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
                                Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                    location.reload();
                                });
                            }
                        },
                        error: function(xhr) {
                            var response = JSON.parse(xhr.responseText);
                            Swal.fire('Error!', response.message, 'error');
                        }
                    });
                });

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
                                Swal.fire('Berhasil!', response.message, 'success').then(() => {
                                    location.reload();
                                });
                            }
                        },
                        error: function(xhr) {
                            var response = JSON.parse(xhr.responseText);
                            Swal.fire('Error!', response.message, 'error');
                        }
                    });
                });
            });
        </script>
    @endpush
</x-layout>
