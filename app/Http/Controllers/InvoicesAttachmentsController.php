<?php

namespace App\Http\Controllers;

use App\Models\invoices_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class InvoicesAttachmentsController extends Controller
{
    function __construct()
    {
        $this -> middleware('permission:show permission', ['only' => ['index','store','show']]);
        $this -> middleware('permission:create permission', ['only' => ['create','store']]);
        $this -> middleware('permission:edit permission', ['only' => ['edit','update']]);
        $this -> middleware('permission:remove permission', ['only' => ['destroy']]);
    }

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
        $this -> validate($request, [
            'file_name' => 'mimes:jpg,bmp,png,pdf,jpeg',
        ], [
            'file_name.mimes' => '* صيغة المرفق يجب ان تكون jpg, bmp, png, pdf, jpeg'
        ]);

//        getClientOriginalName() => معناها انها بتجيب نوع الملف

        $image = $request -> file('file_name');
        $file_name = $image -> getClientOriginalName();

        $attachments = new invoices_attachments();
        $attachments -> file_name = $file_name;
        $attachments -> invoice_number = $request -> invoice_number;
        $attachments -> invoices_id = $request -> invoice_id;
        $attachments -> created_by = Auth::user() -> name;
        $attachments -> save();

        $imageName = $request -> file_name -> getClientOriginalName();
        $request -> file_name -> move(public_path('Attachments' . '/' . $request -> invoice_number), $imageName);

        session() -> flash('Success_add_file');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(invoices_attachments $invoices_attachments)
    {
        //
    }
}
