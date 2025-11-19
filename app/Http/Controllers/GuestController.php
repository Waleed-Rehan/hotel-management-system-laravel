<?php
namespace App\Http\Controllers;
use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller {
    public function index(){ return Guest::paginate(); }
    public function store(Request $r){ return Guest::create($r->only('name','nationality','document_type','document_number','group_id')); }
    public function show(Guest $guest){ return $guest; }
    public function update(Request $r, Guest $guest){ $guest->update($r->only('name','nationality','document_type','document_number','group_id')); return $guest; }
    public function destroy(Guest $guest){ $guest->delete(); return response()->noContent(); }
}
