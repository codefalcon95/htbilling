<?php

use Illuminate\Database\Seeder;

class BillQueueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(App\BillingQueue::class, 10000)->create();
    }
}
