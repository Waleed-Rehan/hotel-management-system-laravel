<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\FinancialTransaction;
use Carbon\Carbon;

class ReportController extends Controller {
    public function profitLoss(){
        $day = request('day'); $fromMonth = request('from_month');
        if($day){
            $date = new Carbon($day);
            $in = FinancialTransaction::where('type','in')->whereDate('effective_on',$date)->sum('amount');
            $out = FinancialTransaction::where('type','out')->whereDate('effective_on',$date)->sum('amount');
            return ['period'=>'day','date'=>$date->toDateString(),'profit'=>$in-$out,'in'=>$in,'out'=>$out];
        }
        if($fromMonth){
            $date = Carbon::parse($fromMonth . '-01');
            $start = $date->copy()->startOfMonth(); $end = $date->copy()->endOfMonth();
            $in = FinancialTransaction::where('type','in')->whereBetween('effective_on',[$start,$end])->sum('amount');
            $out = FinancialTransaction::where('type','out')->whereBetween('effective_on',[$start,$end])->sum('amount');
            return ['period'=>'month','from'=>$start->toDateString(),'to'=>$end->toDateString(),'profit'=>$in-$out,'in'=>$in,'out'=>$out];
        }
        return response()->json(['message'=>'Provide day=YYYY-MM-DD or from_month=YYYY-MM'], 422);
    }

    public function annualLedger(){
        $year = (int)request('year', Carbon::today()->year);
        $rows = [];
        for($m=1;$m<=12;$m++){
            $start = Carbon::create($year,$m,1)->startOfMonth();
            $end = $start->copy()->endOfMonth();
            $in = FinancialTransaction::where('type','in')->whereBetween('effective_on',[$start,$end])->sum('amount');
            $out = FinancialTransaction::where('type','out')->whereBetween('effective_on',[$start,$end])->sum('amount');
            $rows[] = ['month'=>$m,'in'=>$in,'out'=>$out,'net'=>$in-$out];
        }
        return $rows;
    }
}
