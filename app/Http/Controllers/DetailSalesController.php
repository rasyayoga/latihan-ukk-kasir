<?php

namespace App\Http\Controllers;

use App\Models\customers;
use App\Models\detail_sales;
use App\Models\saless;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Log;


class DetailSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentDate = Carbon::now()->toDateString();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Hitung jumlah transaksi (data yang terbuat) hari ini
        $todaySalesCount = detail_sales::whereDate('created_at', $currentDate)->count();

        // Ambil total penjualan hanya untuk hari yang memiliki transaksi
        $sales = detail_sales::selectRaw('EXTRACT(DAY FROM created_at) AS day, COUNT(*) AS total')
            ->whereRaw('EXTRACT(MONTH FROM created_at) = ?', [$currentMonth])
            ->whereRaw('EXTRACT(YEAR FROM created_at) = ?', [$currentYear])
            ->groupByRaw('EXTRACT(DAY FROM created_at)')
            ->orderByRaw('EXTRACT(DAY FROM created_at)')
            ->get();

        $detail_sales = detail_sales::with('saless', 'product')->get();

        // Ubah hasil query menjadi array terstruktur
        $labels = $sales->pluck('day')->map(fn($day) => $day . ' ' . Carbon::now()->format('F'))->toArray();
        $salesData = $sales->pluck('total')->toArray();

        return view('module.dashboard.index', compact('labels', 'salesData', 'detail_sales', 'todaySalesCount'));
    }


    public function show(Request $request, $id)
    {
        // Ambil sale berdasarkan id
        $sale = saless::with('detail_sales.product')->findOrFail($id);
        // check request apakah dia ngirim request poin yang artinya dia adalah member jika tidak ada maka dia non member
        if($request->check_poin){
            // Proses pengurangan point
            $customer = customers::where('id', $request->customer_id)->first();
            $sale->update([
                'total_point' => $customer->point,
                'total_pay' => $sale->total_pay - $customer->point,
                'total_return' => $sale->total_return + $customer->point

            ]);
            $customer->update([
                'name' => $request->name,
                'point' => 0
            ]);
        }
        return view('module.pembelian.print-sale', compact('sale'));
    }

    public function downloadPDF($id) {
        try {
            $sale = saless::with('detail_sales.product')->findOrFail($id);

            $pdf = FacadePdf::loadView('module.pembelian.download', ['sale' => $sale]);
            Log::info('PDF berhasil diunduh untuk transaksi dengan ID ' . $id);

            return $pdf->download('Surat_receipt.pdf');
        } catch (\Exception $e) {
            Log::error('Gagal mengunduh PDF: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengunduh PDF');
        }
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
