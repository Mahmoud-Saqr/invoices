<?php

namespace App\Http\Controllers;

use App\Models\sections;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        * Display a listing of the resource.
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

    public function index()
    {
        $t_sections = sections::all();
        $t_products = products::all();
        // return view( 'folder_name.file_name', compact('sections_table', 'products_table') );
        return view( 'products.products', compact( 't_sections', 't_products' ) );

    }

    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        * Show the form for creating a new resource.
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
    public function create()
    {
        //
    }
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        * Store a newly created resource in storage.
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

    public function store(Request $request)
    {
        $validated = $request -> validate( [
            'product_name' => ['required', 'unique:products', 'max:255'],
            'section_id' => ['required'],
        ], [
            'product_name.required' => 'يرجي ادخال اسم المنتج',
            'product_name.unique' => 'اسم المنتج مسجل مسبقا',
            'section_id.required' => 'يرجي ادخال اسم القسم',

        ] );
        products::create( [
            'product_name' => $request -> product_name,
            'section_name' => $request -> section_name,
            'description' => $request -> description,
            'section_id' => $request -> section_id,
            'created_by' => ( Auth::user() -> name ),
        ] );

        session() -> flash('Success_Add');
        return redirect('products');

    }

    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        * Display the specified resource.
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

    public function show(products $products)
    {
        //
    }

    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        * Show the form for editing the specified resource.
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

    public function edit(products $products)
    {
        //
    }

    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        * Update the specified resource in storage.
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

    public function update(Request $request, products $products)
    {
        $id = $request -> pro_id;

        $this -> validate($request, [
            'product_name' => 'required|max:255|unique:products,product_name,' .$id,
        ], [
            'product_name.required' => 'يرجي ادخال اسم المنتج',
            'product_name.unique' => 'اسم المنتج مسجل مسبقا',
        ]);

        $id_section = sections::where( 'section_name', $request -> section_name ) -> first() -> id;
        $products = products::findOrFail( $id );
        $products -> update( [
            'product_name' => $request -> product_name,
            'description' => $request -> description,
            'section_id' => $id_section,
        ] );
        session() -> flash( 'Success_Edit' );
        return back();
    }

    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        * Remove the specified resource from storage.
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

    public function destroy(Request $request, products $products)
    {
        $id = $request -> pro_id;
        $products = products::findOrFail( $id );
        $products -> delete();
        session() -> flash('Success_Remove');
        return redirect('products');
    }
}
