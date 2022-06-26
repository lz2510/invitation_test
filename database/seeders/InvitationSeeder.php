<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvitationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [];
        $data[] = ["user_id"=>1,"email"=>"user3@sample.com","invitation_code"=>"test1","invitation_content"=>"invite you","status"=>"created"];

        DB::table('invitation')->insert($data);
    }
}
