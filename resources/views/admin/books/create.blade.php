<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    @push('styles')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <style>
            .container {
                background-color: #ffffff;
                border-radius: 0.5rem;
                padding: 1.5rem;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            }
        </style>
    @endpush

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Tambah Buku Baru</h2>
            <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="title" class="form-label">Judul Buku <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="title" id="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="author" class="form-label">Penulis <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="author" id="author"
                                    class="form-control @error('author') is-invalid @enderror"
                                    value="{{ old('author') }}" required>
                                @error('author')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="category_id" class="form-label">Kategori <span
                                        class="text-danger">*</span></label>
                                <select name="category_id" id="category_id"
                                    class="form-control @error('category_id') is-invalid @enderror" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="publication_year" class="form-label">Tahun Terbit <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="publication_year" id="publication_year"
                                    class="form-control @error('publication_year') is-invalid @enderror"
                                    value="{{ old('publication_year') }}" min="1990" max="{{ date('Y') }}"
                                    required>
                                @error('publication_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="stock" class="form-label">Jumlah Stok <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="stock" id="stock"
                                    class="form-control @error('stock') is-invalid @enderror"
                                    value="{{ old('stock', 1) }}" min="1" max="100" required>
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Jumlah buku yang tersedia</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="status" class="form-label">Status Buku <span
                                        class="text-danger">*</span></label>
                                <select name="status" id="status"
                                    class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="">Pilih Status</option>
                                    <option value="available"
                                        {{ old('status', 'available') == 'available' ? 'selected' : '' }}>
                                        Tersedia
                                    </option>
                                    <option value="unavailable" {{ old('status') == 'unavailable' ? 'selected' : '' }}>
                                        Tidak Tersedia
                                    </option>
                                    <option value="special" {{ old('status') == 'special' ? 'selected' : '' }}>
                                        Khusus (Butuh Persetujuan Admin)
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Status buku untuk sistem peminjaman</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="image" class="form-label">Gambar Buku</label>
                        <input type="file" name="image" id="image"
                            class="form-control @error('image') is-invalid @enderror" accept="image/*">
                        <small class="form-text text-muted">Upload gambar buku (JPG, PNG, GIF - Max: 2MB)</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-4">
                        <button type="button" onclick="window.location='{{ route('admin.books.index') }}'"
                            class="btn btn-lg"
                            style="background-color: #ff9f9f; color: rgb(0, 0, 0); border: 1px solid #cc0000; min-width: 150px;">
                            <i class="fas fa-times me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-lg"
                            style="background-color: #d1fec8; color: #000; border: 1px solid #24d800; min-width: 150px;">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
