<?php

namespace App\Http\Controllers;

use App\Exports\BestSellingProductsExport;
use App\Exports\SalesReportExport;
use App\Http\Requests\ReportBSPRequest;
use App\Http\Requests\ReportSalesRequest;
use App\Models\Sale;
use App\Models\SaleDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelFormat;

class ReportController extends Controller
{
    public function bestSellingProducts(ReportBSPRequest $request)
    {
        $data = $request->validated();

        $startDate = $data['start_date'];
        $endDate = Carbon::parse($data['end_date'])->endOfDay();
        $productName = $data['product_name'] ?? null;
        $customerName = $data['customer_name'] ?? null;
        $sellerName = $data['seller_name'] ?? null;
        $format = $data['format'];

        $query = SaleDetail::selectRaw('
                products.sku,
                products.name,
                SUM(sale_details.quantity) as total_quantity,
                SUM(sale_details.total) as total_sales
            ')
            ->join('products', 'sale_details.product_id', '=', 'products.id')
            ->join('sales', 'sale_details.sale_id', '=', 'sales.id')
            ->join('customers', 'sales.customer_id', '=', 'customers.id')
            ->join('users as sellers', 'sales.seller_id', '=', 'sellers.id')
            ->whereBetween('sales.created_at', [$startDate, $endDate])
            ->groupBy('products.sku', 'products.name')
            ->orderByDesc('total_quantity')
            ->limit(20);

        if (!empty($productName)) {
            $query->where('products.name', 'like', "%$productName%");
        }

        if (!empty($customerName)) {
            $query->where('customers.name', 'like', "%$customerName%");
        }

        if (!empty($sellerName)) {
            $query->where('sellers.name', 'like', "%$sellerName%");
        }

        $data = $query->get();

        if ($format === 'json') {
            return response()->json($data, 200);
        } else if ($format === 'xlsx') {
            return Excel::download(new BestSellingProductsExport($data), 'best_selling_products.xlsx', ExcelFormat::XLSX);
        } else {
            return response()->json(['message' => 'Formato inválido.'], 400);
        }
    }

    public function sales(ReportSalesRequest $request)
    {
        $data = $request->all();

        $startDate = $data['start_date'];
        $endDate = Carbon::parse($data['end_date'])->endOfDay();
        $format = $data['format'];

        $query = Sale::selectRaw('
                sales.code as code,
                customers.name as customer_name,
                CONCAT(customers.document_id, " ", customers.number_id) as customer_identification,
                customers.email as customer_email,
                SUM(sale_details.quantity) as total_products,
                SUM(sale_details.total) as total_sales,
                DATE_FORMAT(sales.created_at, "%d/%m/%Y %H:%i:%s") as sale_date
            ')
            ->join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
            ->join('customers', 'sales.customer_id', '=', 'customers.id')
            ->whereBetween('sales.created_at', [$startDate, $endDate])
            ->groupBy('sales.code', 'customers.name', 'customers.document_id', 'customers.number_id', 'customers.email', 'sales.created_at')
            ->orderByDesc('sales.created_at');

        if (!empty($data['customer_id'])) {
            $query->where('sales.customer_id', $data['customer_id']);
        }

        if (!empty($data['seller_id'])) {
            $query->where('sales.seller_id', $data['seller_id']);
        }

        $sales = $query->get();

        if ($format === 'json') {
            return response()->json($sales, 200);
        } else if ($format === 'xlsx') {
            return Excel::download(new SalesReportExport($sales), 'sales_report.xlsx');
        } else {
            return response()->json(['message' => 'Formato inválido.'], 400);
        }
    }
}
