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
    <!--Internal   Notify -->
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
@endsection
@section('title')
    Invoices - Create Invoice
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">قائمة الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ اضافة فاتورة</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    @if (session() -> has('Success_Add'))
        <script>
            window.onload = function () {
                notif({
                    msg: 'تم اضافة الفاتورة بنجاح',
                    type: "primary",
                    position: "right",
                    fade: true,
                    // bgcolor: "#8500ff",
                    // color: "#fff",
                });
            }
        </script>
    @endif

    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
    {{-- BESICE ROW --}}
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

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                    {{-- FORM CREATE INVOICE --}}
                    {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

                    <form action="{{ route('invoices.store') }}" method="post" enctype="multipart/form-data"
                          autocomplete="off">
                        {{ csrf_field() }}

                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        {{-- ROW => [ 1 ] --}}
                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        <div class="row mt-2">
                            <div class="col">
                                <label for="inputName" class="control-label"> رقم الفاتورة </label>
                                <input type="text" class="form-control" id="inputName" name="invoice_number"
                                       title=" يرجي ادخال رقم الفاتورة " required>
                            </div>
                            <div class="col">
                                <label> تاريخ الفاتورة </label>
                                <div class="input-group">
                                    <input class="form-control fc-datepicker" name="invoice_date"
                                           placeholder="YYYY-MM-DD" value="{{ date('Y-m-d') }}" type="text" required>
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
                                       placeholder="YYYY-MM-DD" type="text" required>
                            </div>
                        </div>

                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        {{-- ROW => [ 3 ] --}}
                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        <div class="row mt-3">

                            <div class="col">
                                <label for="inputName" class="control-label"> القسم </label>
                                <select name="select_section" class="form-control select2-no-search" onclick="console.log($(this).val())"
                                        onchange="console.log('change is firing')" required>
                                    <option label="empty" selected disabled> __حدد القسم__ </option>
                                    @foreach ($t_sections as $item)
                                        <option value="{{ $item -> id }}"> {{ $item -> section_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col">
                                <label for="inputName" class="control-label"> المنتج </label>
                                <select id="product" name="product" class="form-control select2-no-search" required>
                                    <option label="empty" selected disabled> __المنتج__ </option>
                                </select>
                            </div>

                        </div>

                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        {{-- ROW => [ 4 ] --}}
                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}

                        <div class="row mt-3">
                            <div class="col">
                                <label for="inputName" class="control-label"> مبلغ التحصيل </label>
                                <input type="text" class="form-control" id="inputName" name="amount_collection"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                            </div>
                        </div>

                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        {{-- ROW => [ 5 ] --}}
                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        <div class="row mt-3">
                            <div class="col">
                                <label for="inputName" class="control-label"> مبلغ العمولة </label>
                                <input type="text" class="form-control form-control-lg" id="amount_commission"
                                       name="amount_commission" title=" يرجي ادخال مبلغ العمولة "
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       required>
                            </div>
                            <div class="col">
                                <label for="inputName" class="control-label"> الخصم </label>
                                <input type="text" class="form-control form-control-lg" id="discount" name="discount"
                                       title="يرجي ادخال مبلغ الخصم "
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                       value="0" required>
                            </div>
                        </div>

                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        {{-- ROW => [ 6 ] --}}
                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        <div class="row mt-3">
                            <div class="col">
                                <label for="inputName" class="control-label"> نسبة ضريبة القيمة المضافة </label>
                                <select name="rateVAT" id="rateVAT" class="form-control select2-no-search" onchange="myFunction()" required>
                                    <option label="empty" selected disabled> __حدد النسبة__ </option>
                                    <option value=" 5%">5%</option>
                                    <option value="10%">10%</option>
                                </select>
                            </div>
                        </div>

                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        {{-- ROW => [ 7 ] --}}
                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        <div class="row mt-3">
                            <div class="col">
                                <label for="inputName" class="control-label"> قيمة ضريبة القيمة المضافة </label>
                                <input type="text" class="form-control" id="valueVAT" name="valueVAT" readonly>
                            </div>
                        </div>

                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        {{-- ROW => [ 8 ] --}}
                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        <div class="row mt-3">
                            <div class="col">
                                <label for="inputName" class="control-label"> الاجمالي شامل الضريبة </label>
                                <input type="text" class="form-control" id="total" name="total" readonly>
                            </div>
                        </div>

                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        {{-- ROW => [ 9 ] --}}
                        {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
                        <div class="row mt-3">
                            <div class="col">
                                <label for="exampleTextarea"> ملاحظات </label>
                                <textarea class="form-control" id="exampleTextarea" name="note" rows="3"></textarea>
                            </div>
                        </div>

                        <br>

                        <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                        <label for="exampleTextarea"> المرفقات </label>
                        <div class="col-sm-12 col-md-12">
                            <input type="file" name="pic" class="dropify"
                                   accept=".pdf,.jpg, .png, image/jpeg, image/png" data-height="150" />
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
    <!--Internal  Notify js -->
    <script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>

    <script>
        const dateFormat = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>

    <script>

        /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        {{-- Link Select Product When Select Section Automatic. --}}
        \* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

        $(document).ready(function() {
            $('select[ name="select_section" ]').on('change', function() {
                var sectionId = $(this).val();
                if (sectionId) {
                    $.ajax({
                        url: "{{ URL::to( 'section' ) }}/" + sectionId,
                        type: "GET",
                        dataType: "json",
                        success: function( data ) {
                            $('select[ name="product" ]').empty();
                            $.each(data, function( key, value ) {
                                $( 'select[ name="product" ]' ).append( '<option value="' + value + '">' + value + '</option>' );
                            });
                        },
                    });
                } else {
                    console.log( 'AJAX Load Did Not Work' );
                }
            });
        });

        /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ *\
        {{-- END SCRIPT --}}
        \* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

    </script>

    <script>
        function myFunction() {
            var amountCommission = parseFloat(document.getElementById("amount_commission").value);
            var discount = parseFloat(document.getElementById("discount").value);
            var rateVAT = parseFloat(document.getElementById("rateVAT").value);
            var valueVAT = parseFloat(document.getElementById("valueVAT").value);
            var amountCommission2 = amountCommission - discount;
            if (typeof amountCommission === 'undefined' || !amountCommission) {
                alert('يرجي ادخال مبلغ العمولة ');
            } else {
                var intResults = amountCommission2 * rateVAT / 100;
                var intResults2 = parseFloat(intResults + amountCommission2);
                sumq = parseFloat(intResults).toFixed(2);
                sumt = parseFloat(intResults2).toFixed(2);
                document.getElementById("valueVAT").value = sumq;
                document.getElementById("total").value = sumt;
            }
        }
    </script>
@endsection
