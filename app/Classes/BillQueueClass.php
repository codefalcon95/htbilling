<?php
namespace App\Classes;
use App\BillingQueue;
use App\Classes\Bill;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
class BillQueueClass {

    public static function processQueues()
    {
        // running asynchronously and batch
        try{
            BillingQueue::where('processed',false)->chunkById( config('billing_configs.data_chunk'),function($queues){
                // dd($queues);
                Bill::billUser($queues);
           });  
        }catch(Exception $e){
            return ["status" => "error","message" => "Error in processing some of the data","error" => $e];

        }
        return ["status" => "success","message" => "Queue run successfully","count"=> Bill::$numberOfProcessed ] ;
       
        
    }
    
    public static function processQueuesSync()
    {
        try{

            BillingQueue::where('processed',false)->chunkById( config('billing_configs.data_chunk'),function($queues){
                // dd($queues);
                    $count = 0;
                    foreach ($billQueueRepo as $queue) {
                        //running synchronously
                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL,config('billing_configs.bill_endpoint'));
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS,
                                    "username=$queue->username");
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($ch);
                        curl_close ($ch);
                        $queue->update(['processed' => 1]);
                        $count++;
                    }
             });  
        
            return ["status" => "success","message" => "Queue run successfully","count"=> $count ] ;
        }catch(Exception $e) {
             return ["status" => "error","message" => "Error in processing some of the data","error" => $e];
        }
       

    }

    public static function processSingleQueue()
    {
        $queue = (new BillingQueue)->newQuery()->first();
            //running synchronously
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,config('billing_configs.bill_endpoint'));
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,
                        "username=$queue->username");

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);

            curl_close ($ch);
           
          return $response;

    }
    
}