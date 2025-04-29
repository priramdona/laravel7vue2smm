<?php

use App\Employee;
use App\Product;
use App\RequestProduct;
use App\RequestProductItem;
use App\User;
use Illuminate\Database\Seeder;

class RequestProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userData = User::query()
        ->first();
        
        $employeDatas = Employee::query()
        ->get();

        foreach ($employeDatas as $employeData) {
            
            for ($i=0; $i < 5 ; $i++) { 
                $requestProduct = RequestProduct::create([
                    'code' => 'REQ-'.$employeData->nik.'-0000'.$i,
                    'user_id' => $userData->id,
                    'employee_id' => $employeData->id,
                    'request_date' => now(),
                    'status' => 'approved',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                $productDatas = Product::inRandomOrder()->limit(random_int(1, 10))->get();

                foreach($productDatas as $productData){
                    $requestProductItemData = RequestProductItem::create([
                        'request_product_id' => $requestProduct->id,
                        'product_id' => $productData->id,
                        'qty' => 1,
                        'status' => 'fulfilled',
                        'remarks' => 'Data from Seeder',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    Product::where('id', $requestProductItemData->product_id)->decrement('stock', $requestProductItemData->qty);

                }
            }
        }
    }
}

