<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    @push('styles')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

        <style>
            body {
                background-color: #ffffff !important;
            }

            .min-h-full {
                background-color: #ffffff !important;
            }

            main {
                background-color: #ffffff !important;
            }

            .book-image-container {
                width: 60px !important;
                height: 80px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                background-color: #f8f9fa !important;
                border-radius: 6px !important;
                overflow: hidden !important;
                border: 1px solid #dee2e6 !important;
            }

            .book-image {
                max-width: 100% !important;
                max-height: 100% !important;
                object-fit: contain !important;
                border-radius: 4px !important;
            }

            .no-image-placeholder {
                width: 60px !important;
                height: 80px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                background-color: #e9ecef !important;
                border-radius: 6px !important;
                border: 1px solid #dee2e6 !important;
            }

            .data-table td:nth-child(2) {
                width: 80px !important;
                text-align: center !important;
                vertical-align: middle !important;
            }

            .book-preview-container {
                width: 150px !important;
                height: 200px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                background-color: #f8f9fa !important;
                border-radius: 8px !important;
                overflow: hidden !important;
                border: 1px solid #dee2e6 !important;
            }

            .book-preview-image {
                max-width: 100% !important;
                max-height: 100% !important;
                object-fit: contain !important;
                border-radius: 6px !important;
            }

            .delete-btn:disabled {
                opacity: 0.6;
                cursor: not-allowed;
            }

            .alert {
                animation: slideInDown 0.3s ease-in-out;
            }

            @keyframes slideInDown {
                from {
                    transform: translate3d(0, -100%, 0);
                    visibility: visible;
                }

                to {
                    transform: translate3d(0, 0, 0);
                }
            }

            .dataTables_wrapper {
                background-color: #ffffff !important;
            }

            .table {
                background-color: #ffffff !important;
            }

            .container {
                background-color: #ffffff !important;
                border-radius: 0.5rem;
                padding: 1.5rem;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            }
        </style>
    @endpush

    <div class="container">

        @if (isset($book))
            <h2>Edit Buku</h2>
            <form action="{{ route('admin.books.update', $book->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @if ($book->image)
                    <div class="form-group mb-3">
                        <label>Gambar Saat Ini</label>
                        <div class="mt-2">
                            <div class="book-preview-container">
                                <img src="{{ asset('storage/' . $book->image) }}" alt="Book Image"
                                    class="book-preview-image">
                            </div>
                        </div>
                    </div>
                @endif

                <div class="form-group mb-3">
                    <label>Upload Gambar Buku</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="form-text text-muted">Upload gambar buku (JPG, PNG, GIF - Max: 2MB). Kosongkan jika
                        tidak ingin mengubah gambar.</small>
                </div>

                <div class="form-group mb-3">
                    <label>Judul</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $book->title) }}"
                        required>
                </div>
                <div class="form-group mb-3">
                    <label>Penulis</label>
                    <input type="text" name="author" class="form-control" value="{{ old('author', $book->author) }}"
                        required>
                </div>
                <div class="form-group mb-3">
                    <label>Kategori</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label>Tahun Terbit</label>
                    <input type="number" name="publication_year" class="form-control"
                        value="{{ old('publication_year', $book->publication_year) }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        @elseif (isset($categories))
            <h2>Tambah Buku Baru</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label>Upload Gambar Buku</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    <small class="form-text text-muted">Upload gambar buku (JPG, PNG, GIF - Max: 2MB)</small>
                </div>

                <div class="form-group mb-3">
                    <label>Judul</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>
                <div class="form-group mb-3">
                    <label>Penulis</label>
                    <input type="text" name="author" class="form-control" value="{{ old('author') }}" required>
                </div>
                <div class="form-group mb-3">
                    <label>Kategori</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label>Tahun Terbit</label>
                    <input type="number" name="publication_year" class="form-control"
                        value="{{ old('publication_year') }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        @else
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error saat import:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-3">
                <a href="{{ route('admin.books.create') }}" class="btn btn-primary">Tambah Buku</a>
                <a href="{{ route('admin.books.export.excel') }}" class="btn btn-success">Export Excel</a>
                <a href="{{ route('admin.books.export.pdf') }}" class="btn btn-danger">Export PDF</a>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Import Data Buku dari Excel</h5>
                            <p class="text-muted">Download template terlebih dahulu, isi data, lalu upload file Excel.
                            </p>

                            <div class="alert alert-info">
                                <h6><i class="fas fa-info-circle"></i> Kategori yang Tersedia:</h6>
                                <div class="row">
                                    @forelse(App\Models\Category::orderBy('id')->get() as $category)
                                        <div class="col-md-6">
                                            <small><strong>{{ $category->id }}</strong> =
                                                {{ $category->name }}</small>
                                        </div>
                                        @if ($loop->iteration % 2 == 0)
                                </div>
                                <div class="row">
        @endif
    @empty
        <div class="col-12">
            <small class="text-warning">Belum ada kategori. Silakan tambah kategori terlebih dahulu.</small>
        </div>
        @endforelse
    </div>
    </div>

    <a href="{{ route('admin.books.template.download') }}" class="btn btn-outline-primary mb-3">
        <i class="fas fa-download"></i> Download
    </a>
    </div>
    <div class="col-md-6">
        <form action="{{ route('admin.books.import.excel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="file">Pilih File Excel untuk Import</label>
                <input type="file" name="file" class="form-control" accept=".xlsx,.xls" required>
                <small class="form-text text-muted">Format yang didukung: .xlsx, .xls</small>
            </div>
            <button type="submit" class="btn btn-info">
                <i class="fas fa-upload"></i> Import Data
            </button>
        </form>
    </div>
    </div>
    </div>
    </div>

    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Kategori</th>
                <th>Tahun</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    @endif
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

        @if (!isset($book) && !isset($categories))
            <script type="text/javascript">
                $(function() {
                    var table = $('.data-table').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('buku.index') }}",
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'image',
                                name: 'image',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'title',
                                name: 'title'
                            },
                            {
                                data: 'author',
                                name: 'author'
                            },
                            {
                                data: 'category',
                                name: 'category.name'
                            },
                            {
                                data: 'publication_year',
                                name: 'publication_year'
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            },
                        ]
                    });

                    $(document).on('click', '.delete-btn', function(e) {
                        e.preventDefault();

                        const deleteUrl = $(this).data('url');
                        const bookTitle = $(this).data('title');

                        if (confirm(`Yakin ingin menghapus buku "${bookTitle}"?`)) {
                            $(this).prop('disabled', true).html(
                                '<i class="fas fa-spinner fa-spin"></i> Deleting...');

                            $.ajax({
                                url: deleteUrl,
                                type: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    if (response.success) {
                                        showAlert('success', response.message);

                                        table.ajax.reload(null, false);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    showAlert('danger', 'Gagal menghapus buku: ' + error);

                                    $(this).prop('disabled', false).html(
                                        '<i class="fas fa-trash"></i> Delete');
                                }
                            });
                        }
                    });

                    function showAlert(type, message) {
                        const alertHtml = `
                            <div class="alert alert-${type} alert-dismissible fade show" role="alert" id="ajax-alert">
                                <strong>${type === 'success' ? 'Berhasil!' : 'Error!'}</strong> ${message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `;

                        $('#ajax-alert').remove();

                        $('.container').prepend(alertHtml);

                        setTimeout(function() {
                            $('#ajax-alert').fadeOut('slow', function() {
                                $(this).remove();
                            });
                        }, 5000);
                    }
                });
            </script>
        @endif
    @endpush
</x-layout>
