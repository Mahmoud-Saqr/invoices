@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">

    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <!--Internal   Notify -->
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>

@section('title')
    Invoices - Invoices Reports
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">التقارير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تقرير الفواتير</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if (session() -> has('error'))
        <script>
            window.onload = function () {
                notif({
                    msg: ' برجاء مراجعة مدخلات البحث ',
                    type: "error",
                    position: "right",
                    fade: true,
                });
            }
        </script>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>خطا</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- row -->
    <div class="row">

        <div class="col-xl-12">
            <div class="card mg-b-20">


                <div class="card-header pb-0">

                    <form action="/filter_invoices" method="POST" role="search" autocomplete="off">
                        {{ csrf_field() }}

                        <div class="d-flex justify-content-start flex-wrap gap-4">
                            <div class="col-lg-3 mt-3" id="invoice_number">
                                <p class="mg-b-10"> البحث برقم الفاتورة </p>
                                <input type="text" class="form-control"
                                       id="invoice_number_input" name="invoice_number" value="{{  $invoiceNumber?? ''  }}">
                            </div>

                            <div class="col-lg-3 mt-3" id="status">
                                <p class="mg-b-10"> تحديد حالة الفواتير </p>
                                <select class="form-control select2-no-search" name="status">
                                    <option value="{{ $status ?? 'حدد حالة الفواتير' }}"
                                            disabled selected> {{ $status ?? 'حدد حالة الفواتير' }} </option>
                                    <option value="مدفوعة"> مدفوعة </option>
                                    <option value="غير مدفوعة"> غير مدفوعة </option>
                                    <option value="مدفوعة جزئياً"> مدفوعة جزئياً </option>
                                </select>
                            </div>

                            <div class="col-lg-3 mt-3" id="dateFrom">
                                <label for="exampleFormControlSelect1"> من تاريخ </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </div>
                                    <input class="form-control fc-datepicker"
                                           value="{{ $dateFrom ?? '' }}" name="dateFrom"
                                           placeholder="YYYY-MM-DD" type="text" />
                                </div>
                            </div>

                            <div class="col-lg-3 mt-3" id="dateTo">
                                <label for="exampleFormControlSelect1"> الي تاريخ </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </div>
                                    <input class="form-control fc-datepicker" name="dateTo"
                                           value="{{ $dateTo ?? '' }}" placeholder="YYYY-MM-DD" type="text">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-sm-12 col-md-4 col-lg-3 col-xl-2 mr-3">
                                <button class="btn btn-primary btn-block"> بحث </button>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="card-body">
                    <div class="table-responsive col-12 m-auto">
                        @if (isset($details))
                                <table class="table table-invoice table-light table-striped table-hover" id="example-1" data-page-length="50">
                                <thead>
                                <tr>
                                    <th class="border-bottom-0"> # </th>
                                    <th class="border-bottom-0"> العمليات </th>
                                    <th class="border-bottom-0"> رقم الفاتورة </th>
                                    <th class="border-bottom-0"> ناريخ الفاتورة </th>
                                    <th class="border-bottom-0"> تاريخ الاستحقاق </th>
                                    <th class="border-bottom-0"> القسم </th>
                                    <th class="border-bottom-0"> المنتج </th>
                                    <th class="border-bottom-0"> الخصم </th>
                                    <th class="border-bottom-0">نسبة الضريبة </th>
                                    <th class="border-bottom-0"> قيمة الضريبة </th>
                                    <th class="border-bottom-0"> الاجمالي </th>
                                    <th class="border-bottom-0"> الحالة </th>
                                    <th class="border-bottom-0"> قام بالاضافة </th>
                                    <th class="border-bottom-0"> ملاحظات </th>
                                </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach( $details as $item )
                                    @php
                                        $i++;
                                    @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>
                                            <div class="dropdown dropleft z-index-200">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                        class="btn ripple btn-secondary btn-sm" data-toggle="dropdown"
                                                        type="button"> العمليات </button>
                                                <div class="dropdown-menu tx-14">

                                                    <a class="dropdown-item"
                                                       href=" {{ url('invoice_edit') }}/{{ $item -> id }}">
                                                        <i class="typcn typcn-edit text-secondary ml-2"></i> تعديل الفاتورة </a>

                                                    <a class="dropdown-item"
                                                       href="{{ URL::route('status_edit', [$item -> id] ), 'test' }}">
                                                        <i class="typcn typcn-edit text-secondary ml-2"></i> تعديل حالة الدفع </a>

                                                    <a class="dropdown-item"
                                                       href="{{ url('invoices_details') }}/{{ $item -> id }}">
                                                        <i class="far fa-file-alt text-secondary ml-2"></i> تفاصيل الفاتورة </a>

                                                    <a class="dropdown-item" href="{{ url('print_invoice') }}/{{ $item -> id }}"><i
                                                            class="icon ion-ios-print text-secondary ml-2"></i>طباعة الفاتورة</a>

                                                    <a class="dropdown-item" href="#" data-invoice_id="{{ $item -> id }}"
                                                       data-toggle="modal" data-target="#invoice_archive_form">
                                                        <i class="typcn typcn-archive text-secondary ml-2"></i>نقل الي الارشيف</a>

                                                    <a class="dropdown-item" href="#" data-id = "{{ $item -> id }}"
                                                       data-toggle="modal" data-invoice_number="{{ $item -> invoice_number }}" data-target="#invoice_del">
                                                        <i class="far fa-file-alt text-danger ml-2"></i> حذف الفاتورة </a>

                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $item -> invoice_number }} </td>
                                        <td>{{ $item -> invoice_date }}</td>
                                        <td>{{ $item -> due_date }}</td>
                                        <td>{{ $item -> section -> section_name }}</td>
                                        <td>{{ $item -> product }}</td>
                                        <td>{{ $item -> discount }}</td>
                                        <td>{{ $item -> rate_vat }}</td>
                                        <td>{{ $item -> value_vat }}</td>
                                        <td>{{ $item -> total }}</td>
                                        <td>
                                            @if ($item -> value_status == 1)
                                                <span class="text-success">{{ $item -> status }}</span>
                                            @elseif($item -> value_status == 2)
                                                <span class="text-danger">{{ $item -> status }}</span>
                                            @else
                                                <span class="text-warning">{{ $item -> status }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $item -> user }}</td>
                                        <td>{{ $item -> note }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
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

    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{ URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{ URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
    <!-- Ionicons js -->
    <script src="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
    <!--Internal  pickerjs js -->
    <script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>

@endsection
