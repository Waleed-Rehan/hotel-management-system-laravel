<?php
namespace App\Http\Controllers;
use App\Models\FinancialTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FinancialController extends Controller {
    public function store(Request $r){ return FinancialTransaction::create($r->only('type','amount','description','effective_on') + ['user_id'=>$r->user()->id ?? null]); }
    public function update(Request $r, FinancialTransaction $txn){ $txn->update($r->only('type','amount','description','effective_on')); return $txn; }

    public function cashboxSummary(Request $r){
        $date = new Carbon($r->get('date', Carbon::today()->toDateString()));
        $in = FinancialTransaction::where('type','in')->whereDate('effective_on',$date)->sum('amount');
        $out = FinancialTransaction::where('type','out')->whereDate('effective_on',$date)->sum('amount');
        return ['in'=>$in,'out'=>$out,'net'=>$in-$out];
    }
}
