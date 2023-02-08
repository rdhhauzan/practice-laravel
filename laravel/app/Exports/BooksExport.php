<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class BooksExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DB::table('books')->join('genre', 'books.genreId', '=', 'genre.id')->select('books.id AS bookId', 'books.name AS bookName', 'books.price', 'books.description', 'genre.name AS genreName')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Price',
            'Description',
            'Genre'
        ];
    }

/**
 */
// 
}