<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SuppliersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Supplier::create([
            "supplier_code" => "SUPPLIER-001",
            "supplier_name" => "Supplier Baju",
            "supplier_address" => "Bandung",
        ]);
    }
}
