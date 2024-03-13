<?php

namespace Database\Seeders;

use App\Models\Data\TravelMoods;
use App\Models\Travel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TravelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the path to the JSON file
        $jsonFile = base_path('docs/samples/travels.json');

        // Check if the file exists
        if (File::exists($jsonFile)) {
            // Read the JSON file
            $jsonContent = File::get($jsonFile);

            // Decode JSON content
            $travels = json_decode($jsonContent, true);

            // Create tours from the JSON data
            foreach ($travels as $travel) {
                Travel::create([
                    'id' => $travel['id'],
                    'slug' => $travel['slug'],
                    'name' => $travel['name'],
                    'description' => $travel['description'],
                    'numberOfDays' => $travel['numberOfDays'],
                    'moods' => new TravelMoods(
                        $travel['moods']['nature'],
                        $travel['moods']['relax'],
                        $travel['moods']['history'],
                        $travel['moods']['culture'],
                        $travel['moods']['party']
                    ),
                    'public' => true,
                ]);
            }
        } else {
            $this->command->error('The JSON file does not exist: '.$jsonFile);
        }
    }
}
