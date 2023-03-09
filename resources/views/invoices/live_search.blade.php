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


                    <div class="row m-0 p-2">
                        <div class="col-6 mx-auto d-flex w-100 border rounded">

                            <input type="text" id="search" class="form-control" name="search" autocomplete="off"
                                   style="border: 0;box-shadow: none;" placeholder="ابحث عن فاتورة">

                            <button class="microphone mt-2 bg-white" id="serchBtn" style="border: 0; outline: none; cursor: pointer">
                                    <i class="la la-microphone tx-20" id="searchIcon"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive col-12 m-auto py-5">
                            <table class="table table-invoice table-light table-striped table-hover text-center" id="example1" data-page-length="50">
                                <thead>
                                <tr>
                                    <th class="border-bottom-0"> # </th>
                                    <th class="border-bottom-0"> رقم الفاتورة </th>
                                    <th class="border-bottom-0"> ناريخ الفاتورة </th>
                                    <th class="border-bottom-0"> تاريخ الاستحقاق </th>
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
                                <tbody id="total_records"></tbody>
                            </table>
                        </div>
                    </div>
            </div>


            {{-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ --}}
            {{-- END TABLE INVOISES --}}
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.10/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.17.1/axios.min.js"></script>
    <script src="vuesearchapp.js"></script>

    <script>


        $(document).ready(function() {

            fetch_customer_data();

            function fetch_customer_data(query = '')
            {

                $.ajax({
                    url:"{{ route('action') }}",
                    method:'GET',
                    data:{query:query},
                    dataType:'json',
                    success:function (data)
                    {

                        $('tbody').html(data.table_data);
                        $('#total_records').html(data.table_data);

                    }
                });
            }

            $(document).on('keyup', '#search', function() {
                let query = $(this).val();
                fetch_customer_data(query);
            })

        });

        // import React from 'react';
        // import SpeechRecognition, { useSpeechRecognition } from 'react-speech-recognition';
    </script>




    <script>

        let serchBtn = document.getElementById('serchBtn');
        let searchIcon = document.getElementById('searchIcon');
        let search = document.getElementById('search');
        let count = 1;

        // search.addEventListener('change', () => {
        //     speechText = this.value;
        //     speechSynthesis.cancel();
        // });

        serchBtn.addEventListener('click', () => {

            /* =================================================================== *\
                => SPEECH TO TEXT
            \* =================================================================== */

            let speech = true;
            window.SpeechRecognition = window.webkitSpeechRecognition;
            const recognition = new SpeechRecognition();
            recognition.interimResults = true;

            recognition.addEventListener('result', (e) => {
                const transcript = Array.from(e.results)
                    .map(result => result[0])
                    .map(result => result.transcript)
                search.value = transcript;
            });

            if (speech == true) {
                recognition.start();
            }

















            /* =================================================================== *\
                => TEXT TO SPEECH
            \* =================================================================== */

            // if (!speechSynthesis.speaking || speechSynthesis.pause()) {
            //     speechText = search.value;
            //
            //     let speechVoice = new SpeechSynthesisUtterance();
            //     let voices = speechSynthesis.getVoices();
            //     speechVoice.voice = voices[2];
            //     speechVoice.text = speechText;
            //     speechVoice.lang = 'en-US';
            //     speechSynthesis.speak(speechVoice);
            // }
            //
            // if ( count == 1) {
            //     // serchBtn.innerHTML = 'Play';
            //     searchIcon.style.color = 'red';
            //     speechSynthesis.resume();
            //     setTimeout( () => {
            //         count = 2;
            //     }, 1000);
            // } else {
            //     // serchBtn.innerHTML = 'Pause';
            //     searchIcon.style.color = 'blue';
            //     speechSynthesis.pause();
            //     count = 1;
            // }
            // setInterval( () => {
            //     if (!speechSynthesis.speaking && count == 2) {
            //         searchIcon.style.color = 'black';
            //         count = 1;
            //     }
            // });
        });






    </script>








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
