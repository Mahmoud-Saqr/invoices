<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\products;
use App\Models\sections;
use App\Models\User;
use Illuminate\Http\Request;

use App\Notifications\InvoicePaid;
use App\Notifications\SendInvoice;
use Illuminate\Notifications\Notification;

use App\Exports\InvoicesExport;
use App\Imports\InvoicesImport;
use Maatwebsite\Excel\Facades\Excel;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\invoices_details;
use App\Models\invoices_attachments;
use Illuminate\Support\Facades\Storage;

class InvoicesController extends Controller
{
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        * Display a listing of the resource.
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

    public function index()
    {
        $t_sections = sections::all();
        $t_products = products::all();
        $t_invoices = invoices::all();
        return view('invoices.invoices', compact('t_sections', 't_products', 't_invoices'));
    }

    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        * Show the form for creating a new resource.
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

    public function create()
    {
        $t_sections = sections::all();
        $t_products = products::all();
        return view('invoices.create_invoice', compact('t_sections', 't_products'));
    }

    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
    * Store a newly created resource in storage.
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */


    public function paidInvoices()
    {
//        $t_invoices = invoices::where('value_status', 1) -> get();
        $t_invoices = invoices::all();
        return view('invoices.paid_invoices', compact('t_invoices'));
    }

    public function unPaidInvoices()
    {
//        $t_invoices = invoices::where('value_status', 2) -> get();
        $t_invoices = invoices::all();
        return view('invoices.unpaid_invoices', compact('t_invoices'));
    }

    public function partOfPaidInvoices()
    {
//        $t_invoices = invoices::where('value_status', 3) -> get();
        $t_invoices = invoices::all();
        return view('invoices.part_of_paid_invoices', compact('t_invoices'));
    }

    public function print( $id )
    {
        $t_invoices = invoices::where('id', $id) -> first();
        return view('invoices.print_invoice', compact('t_invoices'));
    }
    public function sendMessage( $id_send_message )
    {
        $user = User::first();
        $user -> notify( new SendInvoice($id_send_message) );

        session() -> flash('Success_Send');
        return back();
    }


    public function store(Request $request)
    {
        $validated = $request -> validate( [
            'invoice_number' => ['required', 'unique:invoices', 'max:255'],
        ], [
            'invoice_number.required' => 'يرجي ادخال رقم الفاتورة',
            'invoice_number.unique' => 'رقم الفاتورة مسجل مسبقا',
        ] );

        invoices::create( [
            'invoice_number' => $request -> invoice_number,
            'invoice_date' => $request -> invoice_date,
            'due_date' => $request -> due_date,
            'section_id' => $request -> select_section,
            'product' => $request -> product,
            'amount_collection' => $request -> amount_collection,
            'amount_commission' => $request -> amount_commission,
            'discount' => $request -> discount,
            'rate_vat' => $request -> rateVAT,
            'value_vat' => $request -> valueVAT,
            'total' => $request -> total,
            'status' => 'مدفوعة',
            'value_status' => 1,
            'payment_date' => date('Y-m-d'),
            'note' => $request -> note,
            'user' => ( Auth::user() -> name ),
        ] );


        $invoices_id = invoices::latest() -> first() -> id;
        invoices_details::create( [
            'id_invoices' => $invoices_id,
            'invoice_number' => $request -> invoice_number,
            'section' => $request -> select_section,
            'product' => $request -> product,
            'note' => $request -> note,
            'status' => 'مدفوعة',
            'value_status' => 1,
            'payment_date' => date('Y-m-d'),
            'user' => ( Auth::user() -> name ),
        ] );


        if ($request -> hasFile('pic')) {

            $invoice_id = invoices::latest() -> first() -> id;
            $image = $request -> file('pic');
            $file_name = $image -> getClientOriginalName();
            $invoice_number = $request -> invoice_number;

            $attachments = new invoices_attachments();
            $attachments -> file_name = $file_name;
            $attachments -> invoice_number = $invoice_number;
            $attachments -> created_by = Auth::user() -> name;
            $attachments -> invoices_id = $invoice_id;
            $attachments -> save();

        // move pic
            $imageName = $request -> pic -> getClientOriginalName();
            $request -> pic -> move(public_path('Attachments/' . $invoice_number), $imageName);
        }

        /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
            * SEND MAIL TO MY E-MAIL
        /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
//        $user = User::first();
//        $user -> notify(new InvoicePaid($invoices_id));

        session() -> flash('Success_Add');
        return back();
    }

    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        * Display the specified resource.
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

    public function show(invoices $invoices)
    {
        //
    }

    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        * Show the form for editing the specified resource.
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
    * Status Update.
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
    public function statusUpdate( $id, Request $request )
    {
        $invoices = invoices::findOrFail( $id );
        $status = $request -> status;

        if ($status == 'مدفوعة') {
            $invoices -> update([
                'value_status' => 1,
                'status' => $status,
                'payment_date' => $request -> payment_date,
            ]);
            invoices_details::create( [
                'id_invoices' => $request -> invoice_id,
                'invoice_number' => $request -> invoice_number,
                'product' => $request -> product,
                'section' => $request -> select_section,
                'status' => $status,
                'value_status' => 1,
                'note' => $request -> note,
                'payment_date' => $request -> payment_date,
                'user' => ( Auth::user() -> name ),
        ] );
        } elseif ($status == 'غير مدفوعة') {
            $invoices -> update([
                'value_status' => 2,
                'status' => $status,
                'payment_date' => $request -> payment_date,
            ]);
            invoices_details::create( [
                'id_invoices' => $request -> invoice_id,
                'invoice_number' => $request -> invoice_number,
                'product' => $request -> product,
                'section' => $request -> select_section,
                'status' => $status,
                'value_status' => 2,
                'note' => $request -> note,
                'payment_date' => $request -> payment_date,
                'user' => ( Auth::user() -> name ),
            ] );
        } else {
            $invoices -> update([
                'value_status' => 3,
                'status' => $status,
                'payment_date' => $request -> payment_date,
            ]);
            invoices_details::create( [
                'id_invoices' => $request -> invoice_id,
                'invoice_number' => $request -> invoice_number,
                'product' => $request -> product,
                'section' => $request -> select_section,
                'status' => $status,
                'value_status' => 3,
                'note' => $request -> note,
                'payment_date' => $request -> payment_date,
                'user' => ( Auth::user() -> name ),
            ] );
        }


        session() -> flash('Success_Status_update');
        return redirect('invoices');

    }



    public function edit( $id )
    {
        $invoices = invoices::where('id', $id) -> first();
        $section = sections::all();
        return view('invoices.invoice_edit',  compact('invoices', 'section'));
    }

    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        * Update the specified resource in storage.
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

    public function update(Request $request, invoices $invoices)
    {
        $id = $request -> id;

//        $this -> validate( $request, [
//            'invoice_number' => 'required|max:255|unique:invoices,invoice_number,' .$id,
//        ], [
//            'invoice_number.required' => 'يرجي ادخال اسم القسم',
//            'invoice_number.unique' => 'اسم القسم مسجل مسبقا',
//        ] );

        $invoices = invoices::findOrFail($request -> invoice_id);
        $invoices -> update([
            'invoice_id' => $request -> invoice_id,
            'invoice_number' => $request -> invoice_number,
            'invoice_date' => $request -> invoice_date,
            'due_date' => $request -> due_date,
            'section_id' => $request -> select_section,
            'product' => $request -> product,
            'amount_collection' => $request -> amount_collection,
            'amount_commission' => $request -> amount_commission,
            'discount' => $request -> discount,
            'rate_vat' => $request -> rateVAT,
            'value_vat' => $request -> valueVAT,
            'total' => $request -> total,
            'note' => $request -> note,
        ]);

//        $invoices_attachments = invoices_attachments::findOrFail($request -> invoice_id);
//        $invoices_details = invoices_details::findOrFail($request -> invoice_id);
//        $invoices_attachments -> update([
//            'invoice_number' => $request -> invoice_number,
//            'invoices_id ' => $request -> invoice_id,
//        ]);
//        $invoices_details -> update([
//            'invoice_number' => $request -> invoice_number,
//            'id_invoices  ' => $request -> invoice_id,
//        ]);


        session() -> flash('Success_Edit');
        return redirect('invoices');

    }

    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        * Remove the specified resource from storage.
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

    public function destroy(Request $request)
    {
        $id = $request -> id;
        $invoice = invoices::where('id', $id) -> first();
        $details = invoices_attachments::where('invoices_id', $id) -> first();

        if ($request  -> idPage == 2) {
            $invoice -> Delete();
            session() -> flash('Success_Transferred');
            return redirect('invoices');

        } else {
            if(!empty($details -> invoice_number)) {
                Storage::disk('public_uploads') -> deleteDirectory($details -> invoice_number);
            }
            $invoice -> forceDelete();
            session() -> flash('Success_Remove');
            return redirect('invoices');
        }

    }

    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        * Get Product When Select Section.
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
    public function getProducts( $id )
    {
        $selectProduct = DB::table('products') -> where('section_id', $id) -> pluck('product_name', 'id');
        return json_encode($selectProduct);
    }

    public function getAttachments( $id )
    {

    }

//    public function export()
//    {
//        return Excel::download(new InvoicesExport, 'users.xlsx');
//    }

//    public function import()
//    {
//        Excel::import(new InvoicesImport, 'C:\laragon\www\first-project\public\Excel\users.xlsx');
//
//        return redirect('/') -> with('Success', 'All good!');
//    }

}
