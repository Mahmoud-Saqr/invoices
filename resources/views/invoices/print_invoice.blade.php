@extends('layouts.master')
@section('css')
    <style>
        @media print
        {
            #btn_print, #btn_send
            {
                display: none;
            }
        }
    </style>
    <!--Internal   Notify -->
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>

@endsection
@section('title')
    Invoices - Print Invoice
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">قائمة الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ طباعة فاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

        @if (session() -> has('Success_Send'))
            <script>
                window.onload = function not14() {
                    notif({
                        msg: "تم ارسال الفاتورة بنجاح",
                        type: "success",
                        position: "right",
                        fade: true,
                        // bgcolor: "#8500ff",
                        // color: "#fff",
                    });
                }
            </script>
        @endif


    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
    {{-- ROW --}}
    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
    <div class="row row-sm">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice">
                <div class="card card-invoice" id="print">
                    <div class="card-body">
                        <div class="invoice-header">
                            <h1 class="invoice-title">Invoice</h1>
                            <div class="billed-from">
                                <h6> تفاصيل الطباعة </h6>
                                <p>تاريخ الطباعة: <span class="text-primary mr-1"> {{ date('d-m-Y') }} </span></p>
                                <p>وقت الطباعة: <span class="text-primary mr-1"> {{ date('h:m:s') }} </span></p>
                                <p> تمت الطباعة بواسطة: <span class="text-primary mr-1">{{ Auth::user() -> name }}</span></p>
                                <p>الايميل: <span class="text-primary mr-1"> {{ Auth::user() -> email }} </span></p>
                            </div><!-- billed-from -->
                        </div><!-- invoice-header -->
                        <div class="row mg-t-20">
                            <div class="col-md">
                                <label class="tx-gray-600 text-primary"> تفاصيل الفاتورة </label>
                                <p class="invoice-info-row"><span> رقم الفاتورة: </span> <span> {{ $t_invoices -> invoice_number }} </span></p>
                                <p class="invoice-info-row"><span> تاريخ الاصدار: </span> <span> {{ $t_invoices -> invoice_date }} </span></p>
                                <p class="invoice-info-row"><span> تاريخ الاستحقاق: </span> <span> {{ $t_invoices -> due_date }} </span></p>
                                <p class="invoice-info-row"><span> القسم: </span> <span> {{ $t_invoices -> section -> section_name }} </span></p>
                            </div>
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                <tr>
                                    <th class="wd-20p"> المنتج </th>
                                    <th class="wd-40p"> الوصف </th>
                                    <th class="tx-center"> مبلغ التحصيل </th>
                                    <th class="tx-right"> مبلغ العمولة </th>
                                    <th class="tx-right"> الاجمالي </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td> {{ $t_invoices -> product }} </td>
                                    <td class="tx-12"> {{ $t_invoices -> note }} </td>
                                    <td class="tx-center"> {{ number_format($t_invoices -> amount_collection) }} </td>
                                    <td class="tx-right"> {{ number_format($t_invoices -> amount_commission) }} </td>
                                    <td class="tx-right"> {{ number_format($t_invoices -> amount_commission + $t_invoices -> amount_collection) }} </td>
                                </tr>
                                <tr>
                                    <td class="valign-middle" colspan="2" rowspan="5">
                                        <div class="invoice-notes">
                                            <label class="main-content-label tx-13"> تفاصيل الحساب </label>
                                        </div>
                                    </td>
                                    <td class="tx-right"> الاجمالي </td>
                                    <td class="tx-right" colspan="2"> {{ number_format($t_invoices -> amount_commission + $t_invoices -> amount_collection) }} </td>
                                </tr>
                                <tr>
                                    <td class="tx-right"> قيمة الخصم </td>
                                    <td class="tx-right" colspan="2"> {{ number_format($t_invoices -> discount) }} </td>
                                </tr>
                                <tr>
                                    <td class="tx-right"> نسبة الضريبة المضافة </td>
                                    <td class="tx-right" colspan="2"> {{ $t_invoices -> rate_vat }} </td>
                                </tr>
                                <tr>
                                    <td class="tx-right"> قيمة الضريبة المضافة </td>
                                    <td class="tx-right" colspan="2"> {{ number_format($t_invoices -> value_vat) }} </td>
                                </tr>
                                <tr>
                                    <td class="tx-right tx-uppercase tx-bold tx-inverse"> الاجمالي شامل الضريبة </td>
                                    <td class="tx-right" colspan="2">
                                        <h4 class="tx-primary tx-bold"> {{ number_format($t_invoices -> total) }} </h4>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr class="mg-b-30">
                        <button class="btn btn-danger float-right mt-3 ml-3" id="btn_print" onclick="printInvoice()">
                            <i class="mdi mdi-telegram ml-1"></i>
                            طباعة
                        </button>
                        <a href="{{ url('send_message') }}/ {{ $t_invoices -> id }}}" class="btn btn-success float-right mt-3" id="btn_send">
                            <i class="mdi mdi-telegram ml-1"></i>
                            ارسال فاتورة
                        </a>
                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
    {{-- ROW CLOSED --}}
    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
    </div>
    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
    {{-- MAIN CONTAINER CLOSED --}}
    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
    </div>
    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
    {{-- MAIN CONTENT CLOSED --}}
    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
@endsection
@section('js')
    <!--Internal  Chart.bundle js -->
    <script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>

    <script>
        function printInvoice() {
            var printContents = document.getElementById('print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>

@endsection
