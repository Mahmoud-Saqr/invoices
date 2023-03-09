<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoces_report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceReportController extends Controller
{

    function __construct()
    {
        $this -> middleware('permission:show permission', ['only' => ['index','reportInvoice']]);
    }

    public function index()
    {
        return view('reports.report_invoices');
    }

    public function reportInvoice(Request $request)
    {
        $status = $request -> status;
        $dateFrom = $request -> dateFrom;
        $dateTo = $request -> dateTo;
        $invoiceNumber = $request -> invoice_number;

            if ( $status && $dateFrom && $dateTo ) {
                $filter = invoices::whereBetween('invoice_date', [$dateFrom, $dateTo]) -> where('status', $status) -> get();
                return view('reports.report_invoices', compact('status', 'dateFrom', 'dateTo')) -> withDetails($filter);
            } elseif ( $status && $dateFrom == '' && $dateTo == '' ) {
                $filter = invoices::select('*') -> where('status', $status) -> get();
                return view('reports.report_invoices', compact('status')) -> withDetails($filter);
            } elseif ( $status == 'حدد حالة الفواتير' && $dateFrom && $dateTo ) {
                $filter = invoices::whereBetween('invoice_date', [$dateFrom, $dateTo]) -> get();
                return view('reports.report_invoices', compact( 'dateFrom', 'dateTo')) -> withDetails($filter);
            } elseif ( $invoiceNumber ) {
                $filter = invoices::where('invoice_number', $invoiceNumber) -> get();
                return view('reports.report_invoices', compact('invoiceNumber')) -> withDetails($filter);
            } elseif ($status) {
                $filter = invoices::where('status', $status) -> get();
                return view('reports.report_invoices', compact('status')) -> withDetails($filter);
            } else {
                session() -> flash('error');
                return redirect('report_invoices');
            }

    }


}
