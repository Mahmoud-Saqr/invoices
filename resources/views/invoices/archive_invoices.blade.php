@extends('layouts.master')
@section('title')
    Invoices - Archived Invoices List
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
                <h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ ارشيف الفواتير </span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
    {{-- SUCCESS MESSAGE  --}}
    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

    @if (session() -> has('Success_Transfare'))
        <script>
            window.onload = function () {
                notif({
                    msg: 'تم ارجاع الفاتورة الي قائمة الفواتير بنجاح',
                    type: "primary",
                    position: "right",
                    fade: true,
                    // bgcolor: "#8500ff",
                    // color: "#fff",
                });
            }
        </script>
    @elseif(session() -> has('Success_Delete'))
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
        {{-- TABLE INVOISES --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

        <div class="col-xl-12">
            <div class="card mg-b-20">

                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">

                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive col-12 m-auto">
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
                            @foreach( $invoices as $item )
                                @php
                                    $i++;
                                @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                        class="btn ripple btn-secondary btn-sm" data-toggle="dropdown"
                                                        type="button">العمليات</button>
                                                <div class="dropdown-menu tx-14">

                                                    <a class="dropdown-item" href="#" data-id = "{{ $item -> id }}"
                                                       data-toggle="modal" data-invoice_number="{{ $item -> invoice_number }}"
                                                       data-target="#invoice_del">
                                                        <i class="text-danger fas fa-trash-alt ml-2"></i> حذف الفاتورة </a>

                                                    <a class="dropdown-item" href="#" data-invoice_id="{{ $item -> id }}"
                                                       data-toggle="modal" data-target="#transfer_invoice_form">
                                                        <i class="text-warning fas fa-exchange-alt ml-2"></i>نقل الي الفواتير</a>

                                                </div>
                                            </div>
                                        </td>
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

        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- END TABLE INVOISES --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- DELETE INVOISES --}}
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
                    <form action="{{ route('inv_del_from_archive') }}" method="POST">
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
        {{-- END DELETE INVOISES --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- RESTORE INVOISES --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

        <div class="modal" id="transfer_invoice_form">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title"> حذف الفاتورة </h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('archive.update', 'test') }}" method="POST">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متاكد من عملية ارجاع الفاتورة ؟</p><br>
                            <input type="hidden" name="id" id="id" value="">
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
        {{-- END RESTORE INVOISES --}}
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
        {{-- SCRIPT EDITE INVOISES --}}
        \* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

        $('#product_edit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var product_name = button.data('name')
            var section_name = button.data('section_name')
            var pro_id = button.data('pro_id')
            var description = button.data('description')
            var modal = $(this)
            modal.find('.modal-body #product_name').val(product_name);
            modal.find('.modal-body #section_name').val(section_name);
            modal.find('.modal-body #description').val(description);
            modal.find('.modal-body #pro_id').val(pro_id);
        })

        /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        {{-- END SCRIPT EDITE INVOISES --}}
        \* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

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
        {{-- SCRIPT RESTORE INVOISES --}}
        \* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

        $('#transfer_invoice_form').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #id').val(id);
        })

        /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        {{-- END SCRIPT RESTORE INVOISES --}}
        \* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

    </script>

@endsection
