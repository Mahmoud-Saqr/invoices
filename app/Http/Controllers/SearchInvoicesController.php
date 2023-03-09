<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchInvoicesController extends Controller
{

    function __construct()
    {
        $this -> middleware('permission:show permission', ['only' => ['index']]);
    }


    public function index()
    {
        return view('invoices.live_search');
    }

    public function action(Request $request)
    {
        if($request -> ajax())
        {
            $output = '';
            $query = $request -> get('query');
            if($query != '') {
                $data = DB::table('invoices')
                    ->where('invoice_number', 'like', '%'.$query.'%')
                    ->orwhere('invoice_date', 'like', '%'.$query.'%')
                    ->orwhere('due_date', 'like', '%'.$query.'%')
                    ->orWhere('product', 'like', '%'.$query.'%')
                    ->orWhere('discount', 'like', '%'.$query.'%')
                    ->orWhere('rate_vat', 'like', '%'.$query.'%')
                    ->orWhere('value_vat', 'like', '%'.$query.'%')
                    ->orWhere('total', 'like', '%'.$query.'%')
                    ->orWhere('status', 'like', '%'.$query.'%')
                    ->orWhere('user', 'like', '%'.$query.'%')
                    ->orWhere('note', 'like', '%'.$query.'%')
                    ->orderBy('id', 'desc')
                    ->get();

            } else {
                $data = DB::table('invoices') -> orderBy('id', 'desc') -> get();
            }

            $total_row = $data -> count();
            if($total_row > 0){

                foreach($data as $row)
                {
                    $i = 0;
                    $i++;
                    $output .= '
                    <tr>
                        <td>'.$i.'</td>
                        <td>'.$row -> invoice_number.'</td>
                        <td>'.$row -> invoice_date.'</td>
                        <td>'.$row -> due_date.'</td>
                        <td>'.$row -> product.'</td>
                        <td>'.$row -> discount.'</td>
                        <td>'.$row -> rate_vat.'</td>
                        <td>'.$row -> value_vat.'</td>
                        <td>'.$row -> total.'</td>
                        <td>'.$row -> status.'</td>
                        <td>'.$row -> user.'</td>
                        <td>'.$row -> note.'</td>
                    </tr>
                    ';

                }

            } else {
                $output .= '
                <tr>
                    <td colspan="14" class="text-center"> لا توجد بيانات </td>
                </tr>
                ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );
            echo json_encode($data);
        }
    }
}
