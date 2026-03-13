<?php
namespace App\Http\Controllers;

use App\Models\Rumah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RumahController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $rumah = Rumah::where('user_id', $user->id)->first();
        
        if (!$rumah) {
            return redirect()->route('rumah.create');
        }
        
        return view('warga.rumah.index', compact('rumah'));
    }

    public function create()
    {
        $user = Auth::user();
        $rumah = Rumah::where('user_id', $user->id)->first();
        
        if ($rumah) {
            return redirect()->route('rumah.index');
        }
        
        return view('warga.rumah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string'
        ]);

        Rumah::create([
            'user_id' => Auth::id(),
            'alamat' => $request->alamat,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        return redirect()->route('dashboard')
               ->with('success', 'Data rumah berhasil disimpan!');
    }

    public function edit($id)
    {
        $rumah = Rumah::findOrFail($id);
        
        if ($rumah->user_id != Auth::id()) {
            abort(403);
        }
        
        return view('warga.rumah.edit', compact('rumah'));
    }

    public function update(Request $request, $id)
    {
        $rumah = Rumah::findOrFail($id);
        
        if ($rumah->user_id != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'alamat' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string'
        ]);

        $rumah->update($request->all());

        return redirect()->route('rumah.index')
               ->with('success', 'Data rumah berhasil diperbarui!');
    }
}