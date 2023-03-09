<?php

use App\Models\invoices;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\InvoicesAttachmentsController;
use App\Http\Controllers\InvoiceArchiveController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CustomersReportController;
use App\Http\Controllers\InvoiceReportController;
use App\Http\Controllers\SearchInvoicesController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
// Auth::routes(['register' => false]);

Route::get('/home', [HomeController::class, 'index']) -> name('home');

Route::resource('invoices', InvoicesController::class);

Route::resource('sections', SectionsController::class);

Route::resource('products', ProductsController::class);

Route::resource('archive', InvoiceArchiveController::class);

Route::resource('InvoiceAttachments', InvoicesAttachmentsController::class);
Route::post('inv_del_from_archive', [InvoiceArchiveController::class, 'destroy']) -> name('inv_del_from_archive');

Route::get('/invoices_details/{id}', [InvoicesDetailsController::class, 'edit']);
Route::get('/view_file/{invoice_number}/{file_name}', [InvoicesDetailsController::class, 'view_file']);
Route::get('/status_edit/{id}', [InvoicesDetailsController::class, 'show']) -> name('status_edit');
Route::post('delete_file', [InvoicesDetailsController::class, 'destroy']) -> name('delete_file');

Route::get('/section/{id}', [InvoicesController::class, 'getProducts']);

Route::get('invoice_edit/{id}', [InvoicesController::class, 'edit']) -> name('invoice_edit');
Route::get('print_invoice/{id}', [InvoicesController::class, 'print']) -> name('print_invoice');

Route::post('status_update/{id}', [InvoicesController::class, 'statusUpdate']) -> name('status_update');
Route::get('send_message/{id_send_message}', [InvoicesController::class, 'sendMessage']) -> name('send_message');

Route::post('invoice_del', [InvoicesController::class, 'destroy']) -> name('invoice_del');
Route::post('invoice_archive', [InvoicesController::class, 'destroy']) -> name('invoice_archive');


Route::get('/paid_invoices', [InvoicesController::class, 'paidInvoices']) -> name('paid_invoices');
Route::get('/unpaid_invoices', [InvoicesController::class, 'unPaidInvoices']) -> name('unpaid_invoices');
Route::get('/part_of_paid_invoices', [InvoicesController::class, 'partOfPaidInvoices']) -> name('part_of_paid_invoices');

//Route::get('/export_invoices', [InvoicesController::class, 'export']);
//Route::get('/import_invoices', [InvoicesController::class, 'import']);

Route::get('/report_invoices', [InvoiceReportController::class, 'index']);
Route::post('/filter_invoices', [InvoiceReportController::class, 'reportInvoice']) -> name('filter_invoices');
Route::get('/search', function () {
//    $t_invoices = DB::table('invoices') -> get() -> toArray();
    $t_invoices = invoices::all();
    return view('reports.report_invoices', compact('t_invoices'));
});

Route::get('/report_customers', [customersReportController::class, 'index']);
Route::post('/filter_customers', [customersReportController::class, 'reportCustomers']) -> name('filter_customers');

Route::get('/search_invoices', [SearchInvoicesController::class, 'index']);
Route::get('/action', [SearchInvoicesController::class, 'action']) -> name('action');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});


Route::get('/{page}', [AdminController::class, 'index']);
