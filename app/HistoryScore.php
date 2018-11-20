<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryScore extends Model
{
  protected $fillable = [
    'user_id', 'day'
  ];
}
