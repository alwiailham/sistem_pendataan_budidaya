<?php
namespace App\Http\Controllers;

use App\Models\Budidaya;
use App\Models\Kategori;
use App\Models\Rumah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BudidayaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $rumah = Rumah::where('user_id', $user->id)->first();
        
        if (!$rumah) {
            return redirect()->route('rumah.create')
                   ->with('error', 'Anda harus mengisi data rumah terlebih dahulu!');
        }
        
        $budidayas = Budidaya::where('rumah_id', $rumah->id)
                    ->with('kategori')
                    ->get();
        
        return view('warga.budidaya.index', compact('budidayas', 'rumah'));
    }

    public function create()
    {
        $user = Auth::user();
        $rumah = Rumah::where('user_id', $user->id)->first();
        
        if (!$rumah) {
            return redirect()->route('rumah.create')
                   ->with('error', 'Anda harus mengisi data rumah terlebih dahulu!');
        }
        
        $kategoris = Kategori::all();
        
        return view('warga.budidaya.create', compact('rumah', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_budidaya' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:1',
            'satuan' => 'required|string|max:50'
        ]);

        $rumah = Rumah::where('user_id', Auth::id())->first();

        Budidaya::create([
            'rumah_id' => $rumah->id,
            'kategori_id' => $request->kategori_id,
            'nama_budidaya' => $request->nama_budidaya,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan
        ]);

        return redirect()->route('budidaya.index')
               ->with('success', 'Data budidaya berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $budidaya = Budidaya::findOrFail($id);
        
        if ($budidaya->rumah->user_id != Auth::id()) {
            abort(403);
        }
        
        $kategoris = Kategori::all();
        
        return view('warga.budidaya.edit', compact('budidaya', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $budidaya = Budidaya::findOrFail($id);
        
        if ($budidaya->rumah->user_id != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_budidaya' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:1',
            'satuan' => 'required|string|max:50'
        ]);

        $budidaya->update($request->all());

        return redirect()->route('budidaya.index')
               ->with('success', 'Data budidaya berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $budidaya = Budidaya::findOrFail($id);
        
        if ($budidaya->rumah->user_id != Auth::id()) {
            abort(403);
        }
        
        $budidaya->delete();
        
        return redirect()->route('budidaya.index')
               ->with('success', 'Data budidaya berhasil dihapus!');
    }
}