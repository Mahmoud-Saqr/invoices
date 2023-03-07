<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_attachments;
use App\Models\invoices_details;
use App\Models\sections;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show( $id )
    {
        $invoices = invoices::where('id', $id) -> first();
        $section = sections::all();
        return view('invoices.status_edit', compact('invoices', 'section'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id )
    {
        /*
            تروح تجيب الid المشابه للid اللي انت اخدته فى اللينك
            first() => "loop (foreach) بتجيب صف واحد بس من الداتا ومش بيتعمل عليها"
            get() => "loop (foreach) بتجيباكتر من صف من الداتا وبيتعمل عليها"
        */
        $invoices = invoices::where('id', $id) -> first();
        $details = invoices_details::where('id_invoices', $id) -> get();
        $attachments = invoices_attachments::where('invoices_id', $id) -> get();
        return view('invoices.invoice_details', compact('invoices', 'details', 'attachments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoices_details $invoices_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request -> id;
        $file = invoices_attachments::findOrFail($id);
        $file -> delete();
        $file = Storage::disk('public_uploads') -> delete($request -> invoice_number . '/' . $request -> file_name);
        session() -> flash('Success_delete_file');
        return back();
    }

    public function view_file($invoice_number, $file_name)
    {
        $file = public_path('Attachments' . '/' . $invoice_number . '/' . $file_name);
        return response() -> file($file);
    }

}
