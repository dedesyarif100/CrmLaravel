<?php

namespace Webkul\Admin\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TermAndConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('term_and_condition')->insert([
            [
                'id' => '1',
                'template' => 'Template 1'
            ],
            [
                'id' => '2',
                'template' => 'Template 2'
            ],
        ]);
    }
}
