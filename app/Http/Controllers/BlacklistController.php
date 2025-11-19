<?php
namespace App\Http\Controllers;
use App\Models\BlacklistEntry;
use Illuminate\Http\Request;

class BlacklistController extends Controller {
    public function index(){ return BlacklistEntry::with('guest')->paginate(); }
    public function store(Request $r){ return BlacklistEntry::create($r->only('guest_id','reason','strikes')); }
    public function destroy(BlacklistEntry $blacklist){ $blacklist->delete(); return response()->noContent(); }
}
