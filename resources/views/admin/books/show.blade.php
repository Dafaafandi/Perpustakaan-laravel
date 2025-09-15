<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center mb-4">
                                @if ($book->image)
                                    <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->title }}"
                                        class="img-fluid rounded shadow-sm mx-auto d-block" style="max-height: 300px;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center mx-auto"
                                        style="height: 200px; width: 100%;">
                                        <span class="text-muted">Tidak ada gambar</span>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-8">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="30%">Judul</th>
                                        <td>{{ $book->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Pengarang</th>
                                        <td>{{ $book->author }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kategori</th>
                                        <td>{{ $book->category->name ?? 'Tidak ada kategori' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tahun Terbit</th>
                                        <td>{{ $book->publication_year }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dibuat pada</th>
                                        <td>{{ $book->created_at->format('d M Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Diperbarui pada</th>
                                        <td>{{ $book->updated_at->format('d M Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('buku.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            @can('update', $book)
                                <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
