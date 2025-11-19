<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FinancialTransaction extends Model {
    protected $fillable = ['type','amount','description','user_id','effective_on'];
    protected $casts = ['effective_on' => 'date'];
}
