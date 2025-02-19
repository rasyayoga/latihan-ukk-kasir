<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\saless;
use Database\Seeders\sales;
use Illuminate\Http\Request;

class SalessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $saless = saless::with('customer', 'user', 'detail_sales')->get();
        return view('module.pembelian.index', compact('saless'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = products::all();
        return view('module.pembelian.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Cek apakah ada produk yang dipilih
        if (!$request->has('shop')) {
            return back()->with('error', 'Pilih produk terlebih dahulu!');
        }
    
        // Simpan ke sesi atau database
        session(['shop' => $request->shop]);
    
        // Redirect ke halaman yang menampilkan produk yang dipilih
        return redirect()->route('sales.post');
    }

    public function post()
    {
        $shop = session('shop', []);
        return view('module.pembelian.detail', compact('shop'));
    }


    /**
     * Display the specified resource.
     */
    public function show(saless $saless)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(saless $saless)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, saless $saless)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(saless $saless)
    {
        //
    }
}
