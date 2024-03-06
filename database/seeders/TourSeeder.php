<?php

namespace Database\Seeders;

use App\Models\Tour;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the path to the JSON file
        $jsonFile = base_path('docs/samples/tours.json');

        // Check if the file exists
        if (File::exists($jsonFile)) {
            // Read the JSON file
            $jsonContent = File::get($jsonFile);

            // Decode JSON content
            $tours = json_decode($jsonContent, true);

            // Create tours from the JSON data
            foreach ($tours as $tour) {
                Tour::create([
                    'id' => $tour['id'],
                    'travelId' => $tour['travelId'],
                    'name' => $tour['name'],
                    'startingDate' => $tour['startingDate'],
                    'endingDate' => $tour['endingDate'],
                    'price' => $tour['price'],
                ]);
            }
        } else {
            $this->command->error('The JSON file does not exist: '.$jsonFile);
        }
    }
}
