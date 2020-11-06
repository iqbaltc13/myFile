<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\ConfirmationType;

class ConfirmationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ['id' => 1, 'name' => 'Email confirmation'],
            ['id' => 2, 'name' => 'Reset Password confirmation'],
        ];

        foreach ($datas as $data) {
            if (ConfirmationType::where('id',$data['id'])->count()==0) {
                DB::table('confirmation_types')->insert(array_merge($data, [ 
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]));
            }else{
                ConfirmationType::where('id',$data['id'])->update($data);
            }
        }
    }
}
