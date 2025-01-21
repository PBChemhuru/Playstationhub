<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateGenresToJson extends Command
{
    protected $signature = 'update:genres-json';
    protected $description = 'Convert non-JSON genres to JSON format in the products table';

    public function handle()
    {
        $products = DB::table('products')->get();

        foreach ($products as $product) {
            // Skip valid JSON data
            if (is_array(json_decode($product->genre, true))) {
                continue;
            }

            // Convert non-JSON genres to JSON array
            $genreArray = $product->genre ? explode(',', $product->genre) : [];

            // Update the database
            DB::table('products')
                ->where('id', $product->id)
                ->update([
                    'genre' => json_encode($genreArray),
                ]);

            $this->info("Updated product ID {$product->id}");
        }

        $this->info('All genres have been updated to JSON format successfully!');
    }
}
