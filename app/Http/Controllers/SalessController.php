<?php

namespace App\Http\Controllers;

use App\Models\detail_sales;
use App\Models\products;
use App\Models\saless;
use Carbon\Carbon;
use Database\Seeders\sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (!$request->has('shop')) {
            return back()->with('error', 'Pilih produk terlebih dahulu!');
        }
    
        // Hapus data sebelumnya agar tidak terjadi duplikasi
        session()->forget('shop');
  
        $selectedProducts = $request->shop;
    
        // Pastikan data dikirim dalam bentuk array
        if (!is_array($selectedProducts)) {
            return back()->with('error', 'Format data tidak valid!');
        }
    
        // Simpan hanya produk yang memiliki jumlah lebih dari 0, hapus duplikasi
        $filteredProducts = collect($selectedProducts)
            ->mapWithKeys(function ($item) {
                $parts = explode(';', $item);
                if (count($parts) > 3) {
                    $id = $parts[0];
                    return [$id => $item]; // Pastikan hanya 1 produk per ID
                }
                return [];
            })
            ->values()
            ->toArray();
    
        // Simpan ke sesi
        session(['shop' => $filteredProducts]);
        
        return redirect()->route('sales.post');
    }
    

    public function post()
    {
        $shop = session('shop', []);
        return view('module.pembelian.detail', compact('shop'));
    }

    public function createsales(Request $request)
    {
        $request->validate([
            'total_pay' => 'required',
        ], [
            'total_pay.required' => 'Berapa jumlah uang yang dibayarkan?',
        ]);
    
        $newPrice = (int) preg_replace('/\D/', '', $request->total_price);
        $newPay = (int) preg_replace('/\D/', '', $request->total_pay);
        $newreturn = $newPay - $newPrice;
    
        if (!empty($request->customer_id)) {
            $customerTransactions = saless::where('customer_id', $request->customer_id)->count();
            $point = ($customerTransactions > 1) ? floor($newPrice / 1000) : 0;
            $lastTotalPoint = saless::where('customer_id', $request->customer_id)->max('total_point') ?? 0;
            $totalPoint = $lastTotalPoint + $point;
        } else {
            $point = 0;
            $totalPoint = 0;
        }
    
        $sales = saless::create([
            'sale_date' => Carbon::now()->format('Y-m-d'),
            'total_price' => $newPrice,
            'total_pay' => $newPay,
            'total_return' => $newreturn,
            'customer_id' => $request->customer_id,
            'user_id' => Auth::id(),
            'point' => $point,
            'total_point' => $totalPoint,
        ]);
    
        $detailSalesData = [];
    
        foreach ($request->shop as $shopItem) {
            $item = explode(';', $shopItem);
            $productId = (int) $item[0];
            $amount = (int) $item[3];
            $subtotal = (int) $item[4];
    
            $detailSalesData[] = [
                'sale_id' => $sales->id,
                'product_id' => $productId,
                'amount' => $amount,
                'subtotal' => $subtotal,
                'created_at' => now(),
                'updated_at' => now(),
            ];
    
            detail_sales::insert($detailSalesData);
            
            // Update stok produk di database
            $product = products::find($productId);
            if ($product) {
                $newStock = $product->stock - $amount;
                if ($newStock < 0) {
                    return redirect()->back()->withErrors(['error' => 'Stok tidak mencukupi untuk produk ' . $product->name]);
                }
                $product->update(['stock' => $newStock]);
            }
        }
    

    
        if ($request->member === 'Member') {
            return redirect()->route('sales.create.member', ['id' => $sales->id])
                ->with('message', 'Silahkan daftar sebagai member');
        }
    
        return redirect()->route('sales.print.show', ['id' => $sales->id])->with('Silahkan Print');
    }
    

    /**
     * Display the specified resource.
     */
    public function createmember($id)
    {
        $sale = saless::with('detail_sales.product')->findOrFail($id);
        return view('module.pembelian.view-member', compact('sale'));
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
