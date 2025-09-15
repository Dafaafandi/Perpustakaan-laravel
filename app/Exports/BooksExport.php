<?php
namespace App\Exports;
use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BooksExport implements FromCollection, WithHeadings, WithMapping {
    public function collection() {
        return Book::with('category')->get();
    }
    public function headings(): array {
        return ["ID", "Judul", "Penulis", "Kategori", "Tahun Terbit","Stock","Status","Image"];
    }
    public function map($book): array {
        return [
            $book->id,
            $book->title,
            $book->author,
            $book->category->name,
            $book->publication_year,
            $book->stock,
            $book->status,
            $book->image,
        ];
    }
}
