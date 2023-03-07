<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\sections;
use Illuminate\Http\Request;

class CustomersReportController extends Controller
{
    public function index()
    {
        $t_sections = sections::all();
        return view('reports.report_customers', compact('t_sections'));
    }

    public function reportCustomers(Request $request)
    {
        $section = $request -> sections;
        $product = $request -> product;
        $dateFrom = $request -> dateFrom;
        $dateTo = $request -> dateTo;
        $t_sections = sections::all();



        if ($section && $product && $dateFrom && $dateTo) {
            $filter = invoices::whereBetween('invoice_date', [$dateFrom, $dateTo]) -> where('section_id', $section) -> where('product', $product) -> get();
            return view('reports.report_customers', compact('dateFrom', 'dateTo', 't_sections')) -> withDetails($filter);

        } elseif ($section && $product && $dateFrom == '' && $dateTo == '') {
            $filter = invoices::select('*') -> where('section_id', $section) -> where('product', $product) -> get();
            return view('reports.report_customers', compact('t_sections')) -> withDetails($filter);

        } elseif ($section == 'empty' && $product == 'empty' && $dateFrom && $dateTo) {
            $filter = invoices::whereBetween('invoice_date', [$dateFrom, $dateTo])->get();
            return view('reports.report_customers', compact('dateFrom', 'dateTo', 't_sections')) -> withDetails($filter);
        } elseif ($section) {
            $filter = invoices::where('section_id', $section) -> get();
            return view('reports.report_customers', compact('t_sections')) -> withDetails($filter);
        } else {
            session() -> flash('error');
            return redirect('report_customers');
        }
    }
}
