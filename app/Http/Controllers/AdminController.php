<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rumah;
use App\Models\Budidaya;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalWarga = User::where('role', 'warga')->count();
        $totalRumah = Rumah::count();
        $totalBudidaya = Budidaya::count();
        
        $wargaDenganBudidaya = Rumah::has('budidayas')->count();
        
        $budidayaPerKategori = Kategori::withCount('budidayas')->get();
        
        return view('admin.dashboard', compact(
            'totalWarga', 
            'totalRumah', 
            'totalBudidaya', 
            'wargaDenganBudidaya',
            'budidayaPerKategori'
        ));
    }

    public function warga()
    {
        $wargas = User::where('role', 'warga')
                 ->with('rumah.budidayas')
                 ->get();
        
        return view('admin.warga', compact('wargas'));
    }

    public function rumah()
    {
        $rumahs = Rumah::with('user', 'budidayas')->get();
        
        return view('admin.rumah', compact('rumahs'));
    }

    public function budidaya()
    {
        $budidayas = Budidaya::with('rumah.user', 'kategori')->get();
        
        return view('admin.budidaya', compact('budidayas'));
    }

    public function destroyWarga($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'warga') {
            $user->delete();
            return redirect()->back()->with('success', 'Data warga berhasil dihapus');
        }
        
        return redirect()->back()->with('error', 'Tidak dapat menghapus admin');
    }

    public function destroyRumah($id)
    {
        $rumah = Rumah::findOrFail($id);
        $rumah->delete();
        
        return redirect()->back()->with('success', 'Data rumah berhasil dihapus');
    }

    public function destroyBudidaya($id)
    {
        $budidaya = Budidaya::findOrFail($id);
        $budidaya->delete();
        
        return redirect()->back()->with('success', 'Data budidaya berhasil dihapus');
    }

    public function statistik()
{
    return view('admin.statistik');
}
}