<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Path to your CSV file
        $csvPath = storage_path('/app/csv/books.csv');

        // Open the CSV file for reading
        $file = fopen($csvPath, 'r');

        // Skip the header row
        fgetcsv($file);

        // Set the delimiter to semicolon
        $delimiter = ';';

        // Read each line from the CSV file
        while (($data = fgetcsv($file, 0, $delimiter)) !== false) {
            // Create a new Book model instance and populate it with data from the CSV
            $book = new Book();
            $book->name = $data[0];
            $book->author = $data[1];
            $book->editor = $data[2];
            $book->language = $data[3];
            $book->publisher = $data[4];
            $book->ISBN = $data[5];
            $book->description = $data[6];
            $book->filename = $data[7];
            $book->type = $data[8];
            $book->category = $data[9];
            $book->last_rating_date = $data[10];
            $book->last_rating_desc = $data[11];
            $book->save();
        }

        // Close the file
        fclose($file);
    }
}
