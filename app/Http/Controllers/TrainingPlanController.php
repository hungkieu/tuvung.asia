<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TrainingPlan;
use App\User;

class TrainingPlanController extends Controller
{
    //
    public function create(Request $request) {
        $plan = new TrainingPlan;
        $plan->user_id = $request->user_id;
        $plan->weekday = implode("," , $request->weekday);
        $plan->time = $request->time;
       
    
        if ($plan->save()) {
            return response('create success', 200);
        } else {
            return response('create failed', 400);
        }
        
      }
}
