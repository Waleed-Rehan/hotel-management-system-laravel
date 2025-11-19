<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class StaffReward extends Model {
    protected $fillable = ['user_id','amount','reason','effective_on'];
    protected $casts = ['effective_on' => 'date'];
}
