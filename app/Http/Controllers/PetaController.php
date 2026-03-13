<?php
namespace App\Http\Controllers;

use App\Models\Rumah;
use App\Models\Budidaya;

class PetaController extends Controller
{
    public function index()
    {
        $rumahs = Rumah::with(['user', 'budidayas.kategori'])->get();
        
        $locations = [];
        foreach ($rumahs as $rumah) {
            if ($rumah->budidayas->isNotEmpty()) {
                $budidayaList = [];
                foreach ($rumah->budidayas as $budidaya) {
                    $budidayaList[] = [
                        'id' => $budidaya->id,
                        'nama' => $budidaya->nama_budidaya,
                        'kategori' => $budidaya->kategori->nama_kategori,
                        'jumlah' => $budidaya->jumlah . ' ' . $budidaya->satuan
                    ];
                }
                
                $locations[] = [
                    'id' => $rumah->id,
                    'nama_pemilik' => $rumah->user->nama,
                    'alamat' => $rumah->alamat,
                    'latitude' => $rumah->latitude,
                    'longitude' => $rumah->longitude,
                    'budidayas' => $budidayaList
                ];
            }
        }
        
        return view('peta.index', compact('locations'));
    }
}