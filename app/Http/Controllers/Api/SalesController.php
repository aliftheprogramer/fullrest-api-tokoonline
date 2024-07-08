<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SalesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            // Ambil tanggal mulai dan akhir dari request, jika tidak ada gunakan default
            $startDate = $request->input('start_date', '2023-01-01');
            $endDate = $request->input('end_date', now());

            // Ambil data penjualan berdasarkan tanggal
            $sales = DB::table('orders')
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->select(DB::raw('DATE(orders.created_at) as date'), DB::raw('SUM(order_items.price * order_items.quantity) as total_sales'))
                ->whereBetween('orders.created_at', [$startDate, $endDate])
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();

            return response()->json(['sales' => $sales], 200);
        } catch (\Exception $e) {
            Log::error('Error generating sales report: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
}
