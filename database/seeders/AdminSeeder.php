<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminRecords = [
            ['id'=>1,'name'=>'admin','email'=>'admin@gmail.com','password'=>'$2y$10$CYPPM0Kizb61OF6I4qlQZeg2Qy5Wtg5/rnl4WfpCkioDi.xCTZhhS'
                
            ],
        ];

        DB::table('admins')->insert($adminRecords);
        /*
        foreach ($adminRecords as $key => $adminRecord) {
            \App\Models\Admin::create($adminRecord);
        }
        */
    }
}
