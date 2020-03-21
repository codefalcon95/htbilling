<?php

namespace App\Http\Controllers;
use App\Classes\BillQueueClass;
class BillingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        $billQueue = new BillQueueClass;
    }

    public function BillUsers()
    {
         $resp = BillQueueClass::processQueues();
         return $resp;
    }

    public function BillUser()
    {
         $resp = BillQueueClass::processSingleQueue();
         return $resp;
    }
    public function BillUserSync()
    {
         $resp = BillQueueClass::processQueuesSync();
         return $resp;
    }
   
}
