@extends('layouts.master')
@section('title')
    Invoices - Products
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
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
    {{-- SUCCESS MESSAGE --}}
    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

    @if (session() -> has('Success_Add'))
        <script>
            window.onload = function () {
                notif({
                    msg: "تم اضافة المنتج بنجاح",
                    type: "primary",
                    position: "right",
                    fade: true,
                });
            }
        </script>
    @elseif(session() -> has('Success_Edit'))
        <script>
            window.onload = function () {
                notif({
                    msg: 'تم تعديل المنتج بنجاح',
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
                    msg: 'تم حذف المنتج بنجاح',
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
        {{-- TABLE PRODUCT --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <a  data-effect="effect-scale" data-toggle="modal" href="#form-add"
                            class="modal-effect btn btn-sm btn-primary ml-2" style="color:white">
                            <i class="fas fa-plus ml-2"></i> اضافة منتج </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive col-12 m-auto">
                        <table class="table table-invoice table-light table-striped table-hover" id="example-1" data-page-length="50">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0"> # </th>
                                    <th class="border-bottom-0"> العمليات </th>
                                    <th class="border-bottom-0"> اسم المنتج </th>
                                    <th class="border-bottom-0"> القسم </th>
                                    <th class="border-bottom-0"> قام بالاضافة </th>
                                    <th class="border-bottom-0"> تاريخ الاضافة </th>
                                    <th class="border-bottom-0"> ملاحظات </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($t_products as $item)
                                @php
                                    $i++;
                                @endphp
                                    <tr>
                                        <td> {{ $i }} </td>
                                        <td>
                                            <div class="dropdown">
                                                <button aria-expanded="false" aria-haspopup="true"
                                                        class="btn ripple btn-secondary btn-sm" data-toggle="dropdown"
                                                        type="button">العمليات</button>
                                                <div class="dropdown-menu tx-14">

                                                    <button class="dropdown-item" data-name="{{ $item->product_name }}"
                                                            data-pro_id="{{ $item->id }}"
                                                            data-section_name="{{ $item->section->section_name }}"
                                                            data-description="{{ $item->description }}" data-toggle="modal"
                                                            data-target="#product_edit"><i class="typcn typcn-edit text-secondary ml-2"></i> تعديل </button>

                                                    <button class="dropdown-item" data-pro_id="{{ $item->id }}"
                                                            data-product_name="{{ $item->product_name }}" data-toggle="modal"
                                                            data-target="#product_del"><i class="far fa-file-alt text-danger ml-2"></i> حذف </button>

                                                </div>
                                            </div>
                                        </td>
                                        <td> {{ $item->product_name }} </td>
                                        <td> {{ $item->section->section_name }} </td>
                                        <td> {{ $item->created_by }} </td>
                                        <td> {{ $item->created_at }} </td>
                                        <td> {{ $item->description }} </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- END TABLE PRODUCT --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- ADD PRODUCT --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

        <div class="modal" id="form-add">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">اضافة قسم</h6><button aria-label="Close" class="close" data-dismiss="modal"
                            type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('products.store') }}" method="POST" autocomplete="off">
                            {{ csrf_field() }}
                            <div class="row row-sm">
                                <div class="col-lg">
                                    <input class="form-control" id="product_name" name="product_name"
                                        placeholder="اسم المنتج" type="text">
                                </div>
                            </div>

                            <div class="row row-sm">
                                <div class="col-lg mg-t-20">
                                    <select class="form-control select2" id="section_id" name="section_id">
                                        <option label="اختيار القسم..." value=""> __اختيار القسم__ </option>

                                        @foreach ($t_sections as $items)
                                            <option value="{{ $items->id }}"> {{ $items->section_name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row row-sm mg-t-20">
                                <div class="col-lg">
                                    <textarea class="form-control" id="description" name="description" placeholder="ملاحظات" rows="6"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer mt-4">
                                <button class="btn ripple btn-primary" type="submit">تأكيد</button>
                                <button class="btn ripple btn-secondary" data-dismiss="modal"
                                    type="button">اغلاق</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- END ADD PRODUCT --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- EDITE PRODUCT --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

        <div class="modal" id="product_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">تعديل المنتج</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="products/update" method="POST" autocomplete="off">
                            {{ method_field('patch') }}
                            {{ csrf_field() }}
                            <div class="row row-sm">
                                <div class="col-lg">
                                    <input class="form-control" id="pro_id" name="pro_id" placeholder="id"
                                        type="hidden">
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-lg">
                                    <input class="form-control" id="product_name" name="product_name"
                                        placeholder="اسم المنتج" type="text">
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-lg mg-t-20">
                                    <select class="form-control select2" id="section_name" name="section_name">
                                        @foreach ($t_sections as $items)
                                            <option> {{ $items->section_name }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row row-sm mg-t-20">
                                <div class="col-lg">
                                    <textarea class="form-control" id="description" name="description" placeholder="ملاحظات" rows="6"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer mt-4">
                                <button class="btn ripple btn-primary" type="submit">تأكيد</button>
                                <button class="btn ripple btn-secondary" data-dismiss="modal"
                                    type="button">اغلاق</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- END EDITE PRODUCT --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
        {{-- DELETE PRODUCT --}}
        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

        <div class="modal" id="product_del">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">حذف القسم</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="products/destroy" method="POST">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متاكد من عملية حذف القسم ؟</p><br>
                            <input type="hidden" name="pro_id" id="pro_id">
                            <input class="form-control" name="product_name" id="product_name" type="text" readonly>
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
        {{-- END DELETE PRODUCT --}}
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
        {{-- SCRIPT EDITE PRODUCT --}}
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
        {{-- END SCRIPT EDITE PRODUCT --}}
        \* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

        /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        {{-- SCRIPT DELETE PRODUCT --}}
        \* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

        $('#product_del').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var pro_id = button.data('pro_id')
            var product_name = button.data('product_name')
            var modal = $(this)
            modal.find('.modal-body #pro_id').val(pro_id);
            modal.find('.modal-body #product_name').val(product_name);
        })

        /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        {{-- END SCRIPT DELETE PRODUCT --}}
        \* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

    </script>
@endsection
