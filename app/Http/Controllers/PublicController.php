<?php
namespace App\Http\Controllers;

use App\Models\Budidaya;
use App\Models\Kategori;
use App\Models\Rumah;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $totalBudidaya = Budidaya::count();
        $totalWarga = \App\Models\User::where('role', 'warga')->count();
        $totalRumah = Rumah::count();
        
        $budidayaPerKategori = Kategori::withCount('budidayas')->get();
        
        $recentBudidaya = Budidaya::with(['rumah.user', 'kategori'])
                            ->latest()
                            ->take(6)
                            ->get();
        
        return view('public.home', compact(
            'totalBudidaya', 
            'totalWarga', 
            'totalRumah', 
            'budidayaPerKategori',
            'recentBudidaya'
        ));
    }

    public function budidaya()
    {
        $kategoris = Kategori::all();
        $budidayas = Budidaya::with(['rumah.user', 'kategori'])
                        ->latest()
                        ->paginate(12);
        
        return view('public.budidaya.index', compact('budidayas', 'kategoris'));
    }

    public function budidayaDetail($id)
    {
        $budidaya = Budidaya::with(['rumah.user', 'kategori'])
                        ->findOrFail($id);
        
        // Ambil budidaya lain dari pemilik yang sama
        $otherBudidaya = Budidaya::where('rumah_id', $budidaya->rumah_id)
                            ->where('id', '!=', $id)
                            ->with('kategori')
                            ->get();
        
        return view('public.budidaya.detail', compact('budidaya', 'otherBudidaya'));
    }

    public function filterByKategori($kategoriId)
    {
        $kategoris = Kategori::all();
        $selectedKategori = Kategori::findOrFail($kategoriId);
        
        $budidayas = Budidaya::where('kategori_id', $kategoriId)
                        ->with(['rumah.user', 'kategori'])
                        ->latest()
                        ->paginate(12);
        
        return view('public.budidaya.index', compact('budidayas', 'kategoris', 'selectedKategori'));
    }

    public function search(Request $request)
{
    $search = $request->input('q');
    $kategoris = Kategori::all();
    
    $budidayas = Budidaya::where('nama_budidaya', 'like', "%{$search}%")
                    ->orWhereHas('rumah.user', function($query) use ($search) {
                        $query->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('rumah', function($query) use ($search) {
                        $query->where('alamat', 'like', "%{$search}%");
                    })
                    ->with(['rumah.user', 'kategori'])
                    ->latest()
                    ->paginate(12);

    return view('public.budidaya.index', compact('budidayas', 'kategoris', 'search'));
}
}