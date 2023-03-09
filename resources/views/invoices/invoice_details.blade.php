@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">

    <!--Internal   Notify -->
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endsection
@section('title')
    Invoices - Invoices Details
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{ url('/' . $page='invoices') }}"> قائمة الفواتير </a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل الفاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if (session() -> has('Success_add_file'))
        <script>
            window.onload = function () {
                notif({
                    msg: ' تم اضافة المرفق بنجاح',
                    type: "success",
                    position: "right",
                    fade: true,
                });
            }
        </script>
    @elseif(session() -> has('Success_delete_file'))
        <script>
            window.onload = function () {
                notif({
                    msg: 'تم حذف المرفق بنجاح',
                    type: "warning",
                    position: "right",
                    fade: true,
                });
            }
        </script>
    @endif
    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
    {{-- ROW --}}
    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
    <div class="row">

        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- ERROR MESSAGE --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

        @if ($errors->any())
            <div class="alert alert-danger w-100 col-10 mx-auto">
                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ol type="1">
                    <p>يوجد أخطاء</p>
                    @foreach ($errors->all() as $error)
                        <li style="padding: 5px;"> {{ $error }} </li>
                    @endforeach
                </ol>
            </div>
        @endif

        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- END ERROR MESSAGE --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- SUCCESS MESSAGE  --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

        @if (session()->has('Success'))
            <div class="alert alert-success w-100 col-10 mx-auto" role="alert">
                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong> {{ session()->get('Success') }} </strong>
            </div>
        @endif

        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- END SUCCESS MESSAGE --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

        <div class="col-12">
            <div class="card" id="basic-alert">
{{--                    <div>--}}
{{--                        <h6 class="card-title mb-1">Basic Style Tabs</h6>--}}
{{--                        <p class="text-muted card-sub-title">It is Very Easy to Customize and it uses in your website apllication.</p>--}}
{{--                    </div>--}}
                    <div class="text-wrap">
                        <div class="example">
                            <div class="panel panel-primary tabs-style-1">
                                <div class=" tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs main-nav-line">
                                            <li class="nav-item"><a href="#tab1" class="nav-link active" data-toggle="tab"> تفاصيل الفاتورة </a></li>
                                            @can('حالة الدفع')
                                            <li class="nav-item"><a href="#tab2" class="nav-link" data-toggle="tab"> حالة الدفع </a></li>
                                            @endcan
                                            @can('المرفقات')
                                            <li class="nav-item"><a href="#tab3" class="nav-link" data-toggle="tab"> المرفقات </a></li>
                                            @endcan
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
                                    <div class="tab-content">
                                        {{-- TAB 1 --}}
                                        <div class="tab-pane active" id="tab1">
                                            <div class="card-body">
                                                {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                                                {{-- INVOICES DETAILS --}}
                                                {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                                                <div class="card-body">
                                                    <div class="invoice-header justify-content-end">
                                                        <div class="billed-from">
                                                            <h6> تفاصيل الاضافة </h6>
                                                            <p class="mb-1">تاريخ الاضافة: <span class="text-primary mr-1"> {{ date('d-m-Y') }} </span></p>
                                                            <p class="mb-1">وقت الاضافة: <span class="text-primary mr-1"> {{ date('h:m:s') }} </span></p>
                                                            <p class="mb-1"> تمت الاضافة بواسطة: <span class="text-primary mr-1">{{ Auth::user() -> name }}</span></p>
                                                            <p class="mb-1">الايميل: <span class="text-primary mr-1"> {{ Auth::user() -> email }} </span></p>
                                                        </div><!-- billed-from -->
                                                    </div><!-- invoice-header -->
                                                    <div class="row mg-t-20">
                                                        <div class="col-sm-12 col-md-9 col-lg-8 col-xl-7 mx-auto">
                                                            <label class="tx-gray-600 text-primary"> تفاصيل الفاتورة </label>
                                                            <p class="invoice-info-row"><span> رقم الفاتورة: </span> <span> {{ $invoices -> invoice_number }} </span></p>
                                                            <p class="invoice-info-row"><span> تاريخ الاصدار: </span> <span> {{ $invoices -> invoice_date }} </span></p>
                                                            <p class="invoice-info-row"><span> تاريخ الاستحقاق: </span> <span> {{ $invoices -> due_date }} </span></p>
                                                            <p class="invoice-info-row"><span> القسم: </span> <span> {{ $invoices -> section -> section_name }} </span></p>
                                                            <p class="invoice-info-row"><span> المنتج: </span> <span> {{ $invoices -> product }} </span></p>
                                                            <p class="invoice-info-row"><span> مبلغ التحصيل: </span> <span> {{ $invoices -> amount_collection }} </span></p>
                                                            <p class="invoice-info-row"><span> مبلغ العمولة: </span> <span> {{ $invoices -> amount_commission }} </span></p>
                                                            <p class="invoice-info-row"><span> الخصم: </span> <span> {{ $invoices -> discount }} </span></p>
                                                            <p class="invoice-info-row"><span> نسبة الضريبة: </span> <span> {{ $invoices -> rate_vat }} </span></p>
                                                            <p class="invoice-info-row"><span> قيمة الضريبة: </span> <span> {{ $invoices -> value_vat }} </span></p>
                                                            <p class="invoice-info-row"><span> الاجمالي شامل الضريبة: </span> <span> {{ $invoices -> total }} </span></p>
                                                            <p class="invoice-info-row"><span> الحالة الحالية: </span>
                                                            @if(  $invoices -> value_status == 1 )
                                                                <span class="text-success"> {{ $invoices -> status }} </span>
                                                            @elseif(  $invoices -> value_status == 2 )
                                                                <span class="text-danger"> {{ $invoices -> status }} </span>
                                                            @else
                                                                <span class="text-warning"> {{ $invoices -> status }} </span>
                                                            @endif
                                                            </p>
                                                            <p class="invoice-info-row"><span> ملاحظات: </span> <span> {{ $invoices -> note }} </span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                                {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                                                {{-- END INVOICES DETAILS --}}
                                                {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

                                        {{-- TAB 2 --}}
                                    @can('حالة الدفع')
                                        <div class="tab-pane" id="tab2">

                                            {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                                            {{-- TABLE INVOICES STATUS --}}
                                            {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                                            <div class="card-body">
                                                <div class="table-responsive py-4">
                                                    <table class="table table-bordered table-striped table-hover text-md-nowrap">
                                                        <thead>
                                                        <tr>
                                                            <th class="border-bottom-0"> # </th>
                                                            <th class="border-bottom-0"> رقم الفاتورة </th>
                                                            <th class="border-bottom-0"> القسم </th>
                                                            <th class="border-bottom-0"> المنتج </th>
                                                            <th class="border-bottom-0"> الحالة الحالية </th>
                                                            <th class="border-bottom-0"> تاريخ الدفع </th>
                                                            <th class="border-bottom-0"> ملاحظات </th>
                                                            <th class="border-bottom-0"> تاريخ الاضافة </th>
                                                            <th class="border-bottom-0"> قام بالاضافة </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @php
                                                            $i = 0;
                                                        @endphp
                                                        @foreach ($details as $item)
                                                            @php
                                                                $i++;
                                                            @endphp
                                                            <tr>
                                                                <td> {{ $i }} </td>
                                                                <td> {{ $item -> invoice_number }} </td>
                                                                <td> {{ $invoices -> section -> section_name }} </td>
                                                                <td> {{ $item -> product }} </td>
                                                                @if(  $item -> value_status == 1 )
                                                                    <td class="text-success"> {{ $item -> status }} </td>
                                                                @elseif(  $item -> value_status == 2 )
                                                                    <td class="text-danger"> {{ $item -> status }} </td>
                                                                @else
                                                                    <td class="text-warning"> {{ $item -> status }} </td>
                                                                @endif
                                                                <td> {{ $item -> payment_date }} </td>
                                                                <td> {{ $item -> note }} </td>
                                                                <td> {{ $item -> created_at }} </td>
                                                                <td> {{ $item -> user }} </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                                            {{-- END TABLE INVOICES STATUS --}}
                                            {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                                        </div>
                                    @endcan

                                        {{-- TAB 3 --}}
                                    @can('المرفقات')
                                        <div class="tab-pane" id="tab3">
                                            <div class="card-body">

                                                <div class="card-body">
                                                @can('اضافة مرفق')
                                                    <p class="text-danger"> * صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                    <h5 class="card-title"> اضافة مرفقات </h5>
                                                    <form method="post" action="{{ url('/InvoiceAttachments') }}"
                                                          enctype="multipart/form-data">
                                                        {{ csrf_field() }}
                                                        <div class="custom-file">
                                                            <div class="col-sm-12 col-md-12">
                                                                <input type="file" name="file_name" class="dropify"
                                                                       accept=".pdf,.jpg, .png, image/jpeg, image/png" data-height="150" required/>
                                                            </div><br>
                                                            <input type="hidden" id="customFile" name="invoice_number"
                                                                   value="{{ $invoices -> invoice_number }}">
                                                            <input type="hidden" id="invoice_id" name="invoice_id"
                                                                   value="{{ $invoices -> id }}">
                                                        </div>
                                                        <button type="submit" class="btn btn-primary m-auto d-block"
                                                                name="uploadedFile"> تاكيد </button>
                                                    </form>
                                                @endcan
                                                </div>
                                                <div class="table-responsive col-12 m-auto">
                                                    <table class="table table-invoice table-hover table-light table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th class="border-bottom-0"> # </th>
                                                                <th class="border-bottom-0"> اسم الملف </th>
                                                                <th class="border-bottom-0"> قام بالاضافة </th>
                                                                <th class="border-bottom-0"> تاريخ الاضافة </th>
                                                                <th class="border-bottom-0"> العمليات </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @php
                                                            $i = 0;
                                                        @endphp
                                                        @foreach ($attachments as $item)
                                                            @php
                                                                $i++;
                                                            @endphp
                                                            <tr>
                                                                <td> {{ $i }} </td>
                                                                <td> {{ $item -> file_name }} </td>
                                                                <td> {{ $item -> created_by }} </td>
                                                                <td> {{ $item -> created_at }} </td>
                                                                <td>
                                                                    <a class="btn btn-sm btn-primary"
                                                                       href="{{ url('view_file') }}/{{ $invoices -> invoice_number }}/{{ $item -> file_name }}"
                                                                       role="button">
                                                                        <span> عرض </span>
                                                                    </a>
                                                                    @can('حذف المرفق')
                                                                    <button class="btn btn-danger btn-sm"
                                                                            data-toggle="modal"
                                                                            data-id_file="{{ $item -> id }}"
                                                                            data-file_name="{{ $item -> file_name }}"
                                                                            data-invoice_number="{{ $item -> invoice_number }}"
                                                                            data-target="#file_del">
                                                                        <span> حذف </span>
                                                                    </button>
                                                                    @endcan
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                    {{-- DELETE FILE --}}
                    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

                    <div class="modal" id="file_del">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
                                    <h6 class="modal-title"> حذف المرفق </h6>
                                    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('delete_file') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="modal-body">
                                        <p>هل انت متاكد من عملية حذف المرفق ؟</p><br>
                                        <input type="hidden" name="id" id="id" value="">
                                        <input type="hidden" name="invoice_number" id="invoice_number" value="">
                                        <input class="form-control" type="text" name="file_name" id="file_name" value="" readonly>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger">تاكيد</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                    {{-- END DELETE FILE --}}
                    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
            </div>
        </div>

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

    <!-- Internal Data tables -->
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>

    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>

    <script>
    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
    {{-- END SCRIPT DELETE FILE --}}
    \* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

    $('#file_del').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)
    var id = button.data('id_file')
    var invoice_number = button.data('invoice_number')
    var file_name = button.data('file_name')
    var modal = $(this)
    modal.find('.modal-body #id').val(id);
    modal.find('.modal-body #invoice_number').val(invoice_number);
    modal.find('.modal-body #file_name').val(file_name);
    })

    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
    {{-- END SCRIPT DELETE FILE --}}
    \* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
    </script>
@endsection
