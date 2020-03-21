<?php

namespace App\Classes;
use Clue\React\Block;
use React\EventLoop\Factory;
use Clue\React\Buzz\Browser;
use App\BillingQueue;

set_time_limit(0);

class Bill {

    public static $numberOfProcessed = 0; 

    public static function billUser($queues)
    {
        $loop = Factory::create();

        $browser = new Browser($loop);
        
        $promises = [];
        foreach ($queues as $queue) {
            array_push($promises,$browser->post(config('billing_configs.bill_endpoint'),array('Content-type' => 'application/json'),\json_encode(['username' => $queue->username,'amount_to_bill' => $queue->amount_to_bill])));
        }
        $responses = Block\awaitAll($promises, $loop);
        foreach($responses as $response)
        {   //decode the each response and update it
            $json_resp =  json_decode($response->getBody()->getContents(),true);
            //get response status
            if($json_resp && $json_resp['status'] && $json_resp['status'] === "success")
            {
                $billing_queue =  BillingQueue::where('username',$json_resp['user'])->first();
                //update user status
                $billing_queue->processed = true;
                $billing_queue->save();

                ++self::$numberOfProcessed;
            }
        }
    }
}