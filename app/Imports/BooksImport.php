<?php
namespace App\Imports;
use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BooksImport implements ToModel, WithHeadingRow {
    public function model(array $row) {
        return new Book([
            'title' => $row['judul'],
            'author' => $row['penulis'],
            'category_id' => $row['id_kategori'],
            'publication_year' => $row['tahun_terbit'],
        ]);
    }
}
