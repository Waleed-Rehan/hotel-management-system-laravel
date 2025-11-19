<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class StaffPenalty extends Model {
    protected $fillable = ['user_id','amount','reason','effective_on'];
    protected $casts = ['effective_on' => 'date'];
}
