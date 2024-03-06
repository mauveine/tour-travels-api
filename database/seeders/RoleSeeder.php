<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the path to the JSON file
        $jsonFile = base_path('docs/samples/roles.json');

        // Check if the file exists
        if (File::exists($jsonFile)) {
            // Read the JSON file
            $jsonContent = File::get($jsonFile);

            // Decode JSON content
            $roles = json_decode($jsonContent, true);

            // Create tours from the JSON data
            foreach ($roles as $role) {
                Role::create([
                    'name' => $role['name'],
                    'guard_name' => 'api',
                ]);
            }
        } else {
            $this->command->error('The JSON file does not exist: '.$jsonFile);
        }
    }
}
