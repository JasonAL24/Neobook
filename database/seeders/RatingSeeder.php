<?php

namespace Database\Seeders;

use App\Models\Rating;
use Illuminate\Database\Seeder;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Path to your CSV file
        $csvPath = storage_path('/app/csv/rating.csv');

        // Open the CSV file for reading
        $file = fopen($csvPath, 'r');

        // Skip the header row
        fgetcsv($file);

        // Set the delimiter to semicolon
        $delimiter = ';';

        // Read each line from the CSV file
        while (($data = fgetcsv($file, 0, $delimiter)) !== false) {
            // Create a new Book model instance and populate it with data from the CSV
            $rating = new Rating();
            $rating->member_id = $data[0];
            $rating->book_id = $data[1];
            $rating->rating = $data[2];
            $rating->review = $data[3];
            $rating->save();
        }

        // Close the file
        fclose($file);
    }
}
