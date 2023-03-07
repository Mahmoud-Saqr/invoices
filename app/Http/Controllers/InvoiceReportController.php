<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use Illuminate\Http\Request;

class InvoiceReportController extends Controller
{
    public function index()
    {
        return view('reports.report_invoices');
    }

    public function reportInvoice(Request $request)
    {
        $status = $request -> type_invoice;
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
            } else {
                session() -> flash('error');
                return redirect('report_invoices');
            }

    }

}
