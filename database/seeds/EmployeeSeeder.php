<?php

use App\Departement;
use App\Employee;
use Illuminate\Database\Seeder;

use Faker\Generator as Faker;

use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $dataDepartements = $this->departementData();
        $runIdNik = 0;

        foreach($dataDepartements as $dataDepartement) {
            $departementInfo = Departement::create($dataDepartement);
            $runIdNik += 1;

            for ($i=0; $i < 5 ; $i++) { 
                
                $randomCode = random_int(100000, 999999);

                Employee::create([
                    'name' => $faker->name(),
                    'email' => $faker->email(),
                    'nik' => $runIdNik.'-'.'00'.$i.'-'.$randomCode,
                    'departement_id' => $departementInfo->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
    public function departementData(): array
    {
        $departements = [

            [
                'code' => 'IT',
                'name' => 'DEPT-IT',
            ],[
                'code' => 'GA',
                'name' => 'DEPT-GA',
            ],[
                'code' => 'ADM',
                'name' => 'DEPT-ADMIN',
            ],[
                'code' => 'OPT',
                'name' => 'DEPT-OPERATIONAL',
            ],[
                'code' => 'PMO',
                'name' => 'DEPT-PMO',
            ],
    ];

        return $departements;
    }
}
