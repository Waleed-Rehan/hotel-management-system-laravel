<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ReportWebController extends Controller
{
    public function index()     
       {
         return view('admin.reports.index'); 
        }
    public function profitLoss() 
      { 
        return view('admin.reports.profit-loss');
     }
    public function annualLedger() 
    { 
        return view('admin.reports.annual-ledger');
     }
    public function cashbox()   
       { 
        return view('admin.reports.cashbox');
     }
}
