<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,manager');
    }

    /**
     * Display current stock report.
     */
    public function currentStock()
    {
        // Calculate current stock by aggregating all transactions for each item
        $stockLevels = DB::table('stock_transactions')
            ->select(
                'item_id',
                'items.name as item_name',
                'items.sku',
                DB::raw('SUM(CASE WHEN transaction_type = "in" THEN quantity ELSE -quantity END) as current_stock')
            )
            ->join('items', 'stock_transactions.item_id', '=', 'items.id')
            ->groupBy('item_id', 'items.name', 'items.sku')
            ->orderBy('current_stock', 'desc')
            ->get();

        return view('reports.current-stock', compact('stockLevels'));
    }

    /**
     * Display stock movement report.
     */
    public function stockMovement(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $movements = StockTransaction::with(['item', 'location', 'user'])
            ->when($startDate, function ($query) use ($startDate) {
                return $query->whereDate('transaction_date', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                return $query->whereDate('transaction_date', '<=', $endDate);
            })
            ->orderBy('transaction_date', 'desc')
            ->paginate(20);

        return view('reports.stock-movement', compact('movements', 'startDate', 'endDate'));
    }

    /**
     * Display low stock report.
     */
    public function lowStock()
    {
        // Get items where current stock is below minimum stock
        $lowStockItems = Item::select(
            'items.id',
            'items.name',
            'items.sku',
            'items.minimum_stock',
            DB::raw('COALESCE(stock_summary.current_stock, 0) as current_stock')
        )
        ->leftJoin(DB::raw('(
            SELECT 
                item_id, 
                SUM(CASE WHEN transaction_type = "in" THEN quantity ELSE -quantity END) as current_stock
            FROM stock_transactions 
            GROUP BY item_id
        ) as stock_summary'), 'items.id', '=', 'stock_summary.item_id')
        ->havingRaw('COALESCE(stock_summary.current_stock, 0) < items.minimum_stock')
        ->get();

        return view('reports.low-stock', compact('lowStockItems'));
    }

    /**
     * Export reports to CSV.
     */
    public function exportCsv($reportType)
    {
        $fileName = '';
        $data = [];

        switch ($reportType) {
            case 'current-stock':
                $stockLevels = DB::table('stock_transactions')
                    ->select(
                        'item_id',
                        'items.name as item_name',
                        'items.sku',
                        DB::raw('SUM(CASE WHEN transaction_type = "in" THEN quantity ELSE -quantity END) as current_stock')
                    )
                    ->join('items', 'stock_transactions.item_id', '=', 'items.id')
                    ->groupBy('item_id', 'items.name', 'items.sku')
                    ->orderBy('current_stock', 'desc')
                    ->get();

                $fileName = 'current_stock_report_' . date('Y-m-d') . '.csv';
                $data = $stockLevels->toArray();
                break;

            case 'low-stock':
                $lowStockItems = Item::select(
                    'items.id',
                    'items.name',
                    'items.sku',
                    'items.minimum_stock',
                    DB::raw('COALESCE(stock_summary.current_stock, 0) as current_stock')
                )
                ->leftJoin(DB::raw('(
                    SELECT 
                        item_id, 
                        SUM(CASE WHEN transaction_type = "in" THEN quantity ELSE -quantity END) as current_stock
                    FROM stock_transactions 
                    GROUP BY item_id
                ) as stock_summary'), 'items.id', '=', 'stock_summary.item_id')
                ->havingRaw('COALESCE(stock_summary.current_stock, 0) < items.minimum_stock')
                ->get();

                $fileName = 'low_stock_report_' . date('Y-m-d') . '.csv';
                $data = $lowStockItems->toArray();
                break;

            default:
                abort(404);
        }

        // Generate CSV
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            
            // Add headers if data exists
            if (!empty($data)) {
                fputcsv($file, array_keys((array)$data[0]));
                
                foreach ($data as $row) {
                    fputcsv($file, (array)$row);
                }
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}