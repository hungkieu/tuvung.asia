<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TrainingPlan;
use App\User;

class TrainingPlanController extends Controller
{
    //
  public function create(Request $request) {
    $plan = TrainingPlan::firstOrNew(['user_id' => $request->user_id]);
    $plan->user_id = $request->user_id;
    $plan->weekday = json_encode($request->weekday);
    $plan->time = $request->time;

    $plan->save();
    return $plan;
  }

  public function show($id) {
    $plan = TrainingPlan::where('user_id', $id)->first();
    if($plan) return $plan;
    return array("weekday" => json_encode(array()),"time" => "21:00", "user_id" => $id);
  }

}
