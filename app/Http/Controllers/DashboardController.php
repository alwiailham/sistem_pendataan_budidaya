<?php
namespace App\Http\Controllers;

use App\Models\Rumah;
use App\Models\Budidaya;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function warga()
    {
        $user = Auth::user();
        $rumah = Rumah::where('user_id', $user->id)->first();
        
        $budidayas = [];
        if ($rumah) {
            $budidayas = Budidaya::where('rumah_id', $rumah->id)
                        ->with('kategori')
                        ->get();
        }
        
        return view('warga.dashboard', compact('rumah', 'budidayas'));
    }
}