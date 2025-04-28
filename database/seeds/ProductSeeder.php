<?php

use App\Location;
use App\Product;
use App\Unit;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $dataUnits = $this->unitData();
        $dataLocations = $this->locationData();

        $productFaker = [
            'Pensil',
            'Pulpen',
            'Buku Tulis',
            'Penghapus',
            'Spidol',
            'Biskuit',
            'Wafer',
            'Permen',
            'Mie Instan',
            'Susu Bubuk',
            'Kabel USB',
            'Charger HP',
            'Powerbank',
            'Mouse',
            'Headset',
            'Sapu',
            'Ember',
            'Lap Pel',
            'Gayung',
            'Keset',
            'Kaos',
            'Celana Jeans',
            'Jaket',
            'Kemeja',
            'Topi',
        ];

        foreach($dataUnits as $dataUnit) {
            $unitInfo = Unit::create($dataUnit);

            for ($i=0; $i < 5 ; $i++) { 

                foreach($dataLocations as $dataLocation) {
                    $locationInfo = Location::create($dataLocation);

                    for ($i=0; $i < 5 ; $i++) { 
                        $productName = $faker->randomElement($productFaker);
                        Product::create([
                            'code' => strtoupper(substr(str_replace(' ', '', $productName), 0, 3)).$i,
                            'name' => $productName,
                            'unit_id' => $unitInfo->id,
                            'location_id' => $locationInfo->id,
                            'stock' => random_int(100, 999),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }
    public function unitData(): array
    {
        $units = [
            [
                'code' => 'PCS',
                'name' => 'PCS',
            ],[
                'code' => 'Lusin',
                'name' => 'Lusin 12 Pcs',
            ],[
                'code' => 'BOX',
                'name' => 'Box 120 Pcs, 10 Lusin',
            ]
        ];

        return $units;
    }
    public function locationData(): array
    {
        $locations = [
            [
                'code' => 'WRH1',
                'name' => 'Warehouse 1',
            ],[
                'code' => 'WRH2',
                'name' => 'Warehouse 2',
            ],[
                'code' => 'WRH3',
                'name' => 'Warehouse 3',
            ]
        ];

        return $locations;
    }
}
