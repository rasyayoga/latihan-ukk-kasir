<?php

namespace App\Http\Controllers;

use App\Models\detail_sales;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DetailSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
    
        // Ambil total penjualan hanya untuk hari yang memiliki transaksi
        $sales = detail_sales::selectRaw('EXTRACT(DAY FROM created_at) AS day, SUM(amount) AS total')
            ->whereRaw('EXTRACT(MONTH FROM created_at) = ?', [$currentMonth])
            ->whereRaw('EXTRACT(YEAR FROM created_at) = ?', [$currentYear])
            ->groupByRaw('EXTRACT(DAY FROM created_at)')
            ->orderByRaw('EXTRACT(DAY FROM created_at)')
            ->get();
            $detail_sales = detail_sales::with('saless', 'product')->get();
        // Ubah hasil query menjadi array terstruktur
        $labels = $sales->pluck('day')->map(fn($day) => $day . ' ' . Carbon::now()->format('F'))->toArray();
        $salesData = $sales->pluck('total')->toArray();

    
        return view('module.dashboard.index', compact('labels', 'salesData', 'detail_sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(detail_sales $detail_sales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(detail_sales $detail_sales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, detail_sales $detail_sales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(detail_sales $detail_sales)
    {
        //
    }
}
