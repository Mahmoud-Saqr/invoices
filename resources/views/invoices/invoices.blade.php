@extends('layouts.master')
@section('title')
    Invoices - Invoices List
@endsection
@section('css')
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal   Notify -->
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">

        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة
                    الفواتير</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
    {{-- SUCCESS MESSAGE  --}}
    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

    @if (session() -> has('Success_Edit'))
        <script>
            window.onload = function () {
                notif({
                    msg: ' تم تعديل الفاتورة بنجاح',
                    type: "success",
                    position: "right",
                    fade: true,
                });
            }
        </script>
    @elseif(session() -> has('Success_Remove'))
        <script>
            window.onload = function () {
                notif({
                    msg: 'تم حذف الفاتورة بنجاح',
                    type: "warning",
                    position: "right",
                    fade: true,
                });
            }
        </script>
    @elseif(session() -> has('Success_Status_update'))
        <script>
            window.onload = function () {
                notif({
                    msg: ' تم تعديل حالة الدفع بنجاح',
                    type: "success",
                    position: "right",
                    fade: true,
                });
            }
        </script>
    @elseif(session() -> has('Success_Transferred'))
        <script>
            window.onload = function () {
                notif({
                    msg: ' تم نقل الفاتورة الى الارشيف بنجاح ',
                    type: "success",
                    position: "right",
                    fade: true,
                });
            }
        </script>
    @endif

    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
    {{-- END SUCCESS MESSAGE --}}
    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
    {{-- ROW --}}
    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

    <div class="row">
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- ERROR MESSAGE --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

        @if ($errors -> any())
            <div class="alert alert-danger w-100 col-10 mx-auto">
                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ol type="1">
                    <p>يوجد أخطاء</p>
                    @foreach ($errors -> all() as $error)
                        <li style="padding: 5px;"> {{ $error }} </li>
                    @endforeach
                </ol>
            </div>
        @endif

        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- END ERROR MESSAGE --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

		{{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- TABLE INVOISES --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

        <div class="col-xl-12">
            <div class="card mg-b-20">

                <div class="card-header">
                    <div class="d-flex">
                        @can('create invoices')
                        <a href="invoices/create" class="modal-effect btn btn-sm btn-primary" style="color:white"><i
                                class="fas fa-plus ml-2"></i> اضافة فاتورة </a>
                        @endcan
{{--                        <a class="modal-effect btn btn-sm btn-primary mr-3" href="{{ url('export_invoices') }}"--}}
{{--                           style="color:white"><i class="fas fa-file-download ml-2"></i> تصدير اكسيل </a>--}}

{{--                        <a class="modal-effect btn btn-sm btn-primary mr-3" href="{{ url('import_invoices') }}"--}}
{{--                           style="color:white"><i class="fas fa-file-download ml-2"></i>&nbsp;ارفاق اكسيل</a>--}}
                    </div>

                    <div class="card-body">
                        <div class="table-responsive col-12 m-auto py-5">
                            <table class="table table-invoice table-light table-striped table-hover" id="example-1" data-page-length="50">
                                <thead>
                                <tr>
                                    <th class="border-bottom-0"> # </th>
                                    @can('options')
                                    <th class="border-bottom-0"> العمليات </th>
                                    @endcan
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
                                @foreach( $t_invoices as $item )
                                @php
                                    $i++;
                                @endphp
                                <tr>
                                    <td>{{ $i }}</td>
                                @can('options')
                                    <td>
                                        <div class="dropdown dropleft">
                                            <button aria-expanded="false" aria-haspopup="true"
                                                    class="btn ripple btn-secondary btn-sm" data-toggle="dropdown"
                                                    type="button">العمليات</button>
                                            <div class="dropdown-menu tx-14">
                                                @can('edit invoices')
                                                <a class="dropdown-item"
                                                   href=" {{ url('invoice_edit') }}/{{ $item -> id }}">
                                                    <i class="typcn typcn-edit text-secondary ml-2"></i> تعديل الفاتورة </a>
                                                @endcan

                                                @can('update status')
                                                <a class="dropdown-item"
                                                   href="{{ URL::route('status_edit', [$item -> id] ), 'test' }}">
                                                    <i class="typcn typcn-edit text-secondary ml-2"></i> تعديل حالة الدفع </a>
                                                @endcan

                                                @can('details invoices')
                                                <a class="dropdown-item"
                                                   href="{{ url('invoices_details') }}/{{ $item -> id }}">
                                                    <i class="far fa-file-alt text-secondary ml-2"></i> تفاصيل الفاتورة </a>
                                                @endcan

                                                @can('print invoice')
                                                <a class="dropdown-item" href="{{ url('print_invoice') }}/{{ $item -> id }}"><i
                                                        class="icon ion-ios-print text-secondary ml-2"></i>طباعة
                                                    الفاتورة
                                                </a>
                                                @endcan

                                                @can('archived invoice')
                                                <a class="dropdown-item" href="#" data-invoice_id="{{ $item -> id }}"
                                                   data-toggle="modal" data-target="#invoice_archive_form">
                                                    <i class="typcn typcn-archive text-secondary ml-2"></i>نقل الي الارشيف</a>
                                                @endcan

                                                @can('remove invoices')
                                                <a class="dropdown-item" href="#" data-id = "{{ $item -> id }}"
                                                   data-toggle="modal" data-invoice_number="{{ $item -> invoice_number }}" data-target="#invoice_del">
                                                    <i class="far fa-file-alt text-danger ml-2"></i> حذف الفاتورة </a>
                                                @endcan

                                            </div>
                                        </div>
                                    </td>
                                @endcan
                                    <td>{{ $item -> invoice_number }}</td>
                                    <td>{{ $item -> invoice_date }}</td>
                                    <td>{{ $item -> due_date }}</td>
                                    <td>{{ $item -> section -> section_name }}</td>
                                    <td>{{ $item -> product }}</td>
                                    <td>{{ $item -> discount }}</td>
                                    <td>{{ $item -> rate_vat }}</td>
                                    <td>{{ $item -> value_vat }}</td>
                                    <td>{{ $item -> total }}</td>
                                    @if ($item -> value_status == 1)
                                        <td class="text-success"> {{ $item -> status }} </td>
                                    @elseif($item -> value_status == 2)
                                        <td class="text-danger"> {{ $item -> status }} </td>
                                    @else
                                    <td class="text-warning"> {{ $item -> status }} </td>
                                    @endif
                                    <td>{{ $item -> user }}</td>
                                    <td>{{ $item -> note }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- END TABLE INVOISES --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- DELETE INVOICES --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

        <div class="modal" id="invoice_del">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title"> حذف الفاتورة </h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('invoice_del') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متاكد من عملية حذف الفاتورة ؟</p><br>
                            <input type="hidden" name="id" id="id" value="">
                            <input type="text" class="form-control" name="invoice_number" id="invoice_number" value="" readonly>
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
        {{-- END DELETE INVOICES --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- ARCHIVE INVOICES --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

        <div class="modal" id="invoice_archive_form">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title"> ارشفة الفاتورة </h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('invoice_archive') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="modal-body pb-0">
                            <p>هل انت متاكد من عملية نقل الفاتورة الى الارشيف ؟</p><br>
                            <input type="hidden" name="id" id="id" value="">
                            <input type="hidden" name="idPage" id="idPage" value="2">
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
        {{-- END ARCHIVE INVOICES --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

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
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>

    <script>



        /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        {{-- SCRIPT DELETE INVOISES --}}
        \* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

        $('#invoice_del').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })

        /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        {{-- END SCRIPT DELETE INVOISES --}}
        \* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

        /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        {{-- SCRIPT DELETE INVOISES --}}
        \* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

        $('#invoice_archive_form').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })

        /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        {{-- END SCRIPT DELETE INVOISES --}}
        \* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

    </script>

@endsection
