@extends('layouts.master')
@section('css')
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
@endsection
@section('title')
    Invoices - Update Status
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">قائمة الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعديل حالة الدفع </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
    {{-- BESICE ROW --}}
    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
    <div class="row">

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                    {{-- FORM CREATE INVOICE --}}
                    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

                    <form action="{{ URL::route('status_update', [ $invoices -> id ]) }}" method="POST" enctype="multipart/form-data"
                          autocomplete="off">
                        {{ csrf_field() }}

                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        {{-- ROW => [ 1 ] --}}
                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        <div class="row mt-2">
                            <div class="col">
                                <label for="inputName" class="control-label"> رقم الفاتورة </label>
                                <input type="hidden" class="form-control" id="invoice_id" name="invoice_id" value="{{ $invoices -> id }}">
                                <input type="text" class="form-control" id="inputName" name="invoice_number"
                                       title=" يرجي ادخال رقم الفاتورة " value="{{ $invoices -> invoice_number }}" readonly>
                            </div>
                            <div class="col">
                                <label> تاريخ الفاتورة </label>
                                <div class="input-group">
                                    <input class="form-control fc-datepicker" name="invoice_date"
                                           placeholder="MM/DD/YYYY" value="{{ $invoices -> invoice_date }}" type="text" readonly>
                                </div><!-- input-group -->
                            </div>
                        </div>

                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        {{-- ROW => [ 2 ] --}}
                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        <div class="row mt-3">
                            <div class="col">
                                <label> تاريخ الاستحقاق </label>
                                <input class="form-control fc-datepicker" name="due_date"
                                       placeholder="MM/DD/YYYY" type="text" value="{{ $invoices -> due_date }}" readonly>
                            </div>
                        </div>

                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        {{-- ROW => [ 3 ] --}}
                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        <div class="row mt-3">

                            <div class="col">
                                <label for="inputName" class="control-label">القسم</label>
                                <select name="select_section" class="form-control select2-no-search" onclick="console.log($(this).val())"
                                        onchange="console.log('change is firing')" readonly>
                                    <option value="{{ $invoices -> section -> id }}">
                                        {{ $invoices -> section -> section_name }}
                                    </option>
                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label">المنتج</label>
                                <select id="product" name="product" class="form-control select2-no-search" readonly>
                                    <option value="{{ $invoices -> product }}"> {{ $invoices -> product }} </option>
                                </select>
                            </div>

                        </div>

                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        {{-- ROW => [ 4 ] --}}
                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

                        <div class="row mt-3">
                            <div class="col">
                                <label for="inputName" class="control-label"> مبلغ التحصيل </label>
                                <input type="text" class="form-control" id="inputName" name="amount_collection" value="{{ $invoices -> amount_collection }}"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly>
                            </div>
                        </div>

                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        {{-- ROW => [ 5 ] --}}
                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        <div class="row mt-3">
                            <div class="col">
                                <label for="inputName" class="control-label"> مبلغ العمولة </label>
                                <input type="text" class="form-control form-control-lg" id="amount_commission" value="{{ $invoices -> amount_commission }}"
                                       name="amount_commission" title=" يرجي ادخال مبلغ العمولة "
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       readonly>
                            </div>
                            <div class="col">
                                <label for="inputName" class="control-label"> الخصم </label>
                                <input type="text" class="form-control form-control-lg" id="discount" name="discount" value="{{ $invoices -> discount }}"
                                       title="يرجي ادخال مبلغ الخصم "
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       value="0" readonly>
                            </div>
                        </div>

                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        {{-- ROW => [ 6 ] --}}
                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        <div class="row mt-3">
                            <div class="col">
                                <label for="inputName" class="control-label"> نسبة ضريبة القيمة المضافة </label>
                                <select name="rateVAT" id="rateVAT" class="form-control select2-no-search" onchange="myFunction()" readonly>
                                    <option value="{{ $invoices -> rate_vat }}"> {{ $invoices -> rate_vat }} </option>
                                </select>
                            </div>
                        </div>

                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        {{-- ROW => [ 7 ] --}}
                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        <div class="row mt-3">
                            <div class="col">
                                <label for="inputName" class="control-label"> قيمة ضريبة القيمة المضافة </label>
                                <input type="text" class="form-control" id="valueVAT" name="valueVAT" value="{{ $invoices -> value_vat }}" readonly>
                            </div>
                        </div>

                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        {{-- ROW => [ 8 ] --}}
                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        <div class="row mt-3">
                            <div class="col">
                                <label for="inputName" class="control-label"> الاجمالي شامل الضريبة </label>
                                <input type="text" class="form-control" id="total" name="total" value="{{ $invoices -> total }}" readonly>
                            </div>
                        </div>

                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        {{-- ROW => [ 9 ] --}}
                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        <div class="row mt-3">
                            <div class="col">
                                <label for="exampleTextarea"> ملاحظات </label>
                                <textarea class="form-control" id="exampleTextarea" value="{{ $invoices -> note }}" name="note" rows="3" readonly></textarea>
                            </div>
                        </div>

                        <div class="card-body mt-4">
                            <h4 class="card-title"> تغيير حالة الدفع </h4>
                            <div class="row mt-3">

                                <div class="col">
                                    <label for="inputName" class="control-label"> حالة الدفع </label>
                                    <select name="status" id="status" class="form-control select2-no-search" required>
                                        <option value="{{ $invoices -> status }}" selected disabled> {{ $invoices -> status }} </option>
                                        <option value="مدفوعة"> مدفوعة </option>
                                        <option value="غير مدفوعة"> غير مدفوعة </option>
                                        <option value="مدفوعة جزئياً"> مدفوعة جزئياً </option>
                                    </select>
                                </div>

                                <div class="col">
                                    <label> تاريخ الدفع </label>
                                    <input class="form-control fc-datepicker" name="payment_date"
                                           placeholder="YYYY-MM-DD" type="text" value="{{ date('Y-m-d') }}">
                                </div>

                            </div>
                        </div>


                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-primary"> حفظ البيانات </button>
                        </div>
                    </form>

                    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                    {{-- END FORM CREATE INVOICE --}}
                    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                </div>
            </div>
        </div>
    </div>
    </div>
    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
    {{-- BESICE ROW CLOSED --}}
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

    <script>
        const dateFormat = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>

@endsection
