<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $storeA = Store::create(['store_name' => 'Store A']);
        //$storeB = Store::create(['store_name' => 'Store B']);

        $storeA->parts()->createMany([
            ['part_no' => '77613-KK030',    'pac_qty' => 60],
            ['part_no' => '48837-0K010-B',  'pac_qty' => 50],
            ['part_no' => '46359-KK010',    'pac_qty' => 50],
            ['part_no' => '46359-KK020',    'pac_qty' => 50],
            ['part_no' => '48836-0K010-B',  'pac_qty' => 50],
            ['part_no' => '48651-0K010',    'pac_qty' => 12],
            ['part_no' => '82715-BZJ80',    'pac_qty' => 100],
            ['part_no' => '48628-KK010',    'pac_qty' => 25],
            ['part_no' => '48514-0K010-A',  'pac_qty' => 30],
            ['part_no' => '48651-0K020',    'pac_qty' => 12],
            ['part_no' => '33524-BZ070',    'pac_qty' => 50],
            ['part_no' => '48629-KK010',    'pac_qty' => 25],
            ['part_no' => '48515-0K010-A',  'pac_qty' => 30],
            ['part_no' => '77612-KK030',    'pac_qty' => 20],
            ['part_no' => '46451-0K030',    'pac_qty' => 200],
            ['part_no' => '86212-BZ550',    'pac_qty' => 100],
            ['part_no' => '71121-X1V21',    'pac_qty' => 60],
            ['part_no' => '55721-KK020',    'pac_qty' => 400],
        ]);

        // $storeB->parts()->createMany([
        //     ['part_no' => '55748-KK010'],
        //     ['part_no' => '52175-0K020'],
        //     ['part_no' => '52183-0K030'],
        //     ['part_no' => '52176-0K030'],
        //     ['part_no' => '55149-BZ210'],
        //     ['part_no' => '55719-KK020'],
        //     ['part_no' => '52183-0K010'],
        //     ['part_no' => '55748-KK020'],
        //     ['part_no' => '72883-X1B06-A'],
        //     ['part_no' => '71294-X1B06-A'],
        //     ['part_no' => '72883-X1B07-A'],
        //     ['part_no' => '61419-BZ100'],
        //     ['part_no' => '51905-KK030'],
        //     ['part_no' => '61418-BZ100'],
        //     ['part_no' => '52183-0K080-A'],
        //     ['part_no' => '51986-02110'],
        //     ['part_no' => '52184-0K030'],
        //     ['part_no' => '71334-BZ020'],
        // ]);
    }
}
