@extends('layouts.main')

@section('fullScreen')

<div class="container-fluid mt-5">
    <h3 align="center"><b>Running Serial</b></h3>

    <div class="row" id="runningSerial">


    </div>

    <div class="row ">


{{--        <div class="col-md-4">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h4 align="center"><b>Serial : <span style="color: green">1</span></b></h4>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="row">--}}
{{--                        <div class="form-group col-md-6">--}}
{{--                            <label>Patient Name : Farzad</label>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-6">--}}
{{--                            <label>Mobile : 0123456</label>--}}
{{--                        </div>--}}

{{--                        <div class="form-group col-md-6">--}}
{{--                            <label>Gender : male</label>--}}
{{--                        </div>--}}

{{--                        <div class="form-group col-md-6">--}}
{{--                            <label>Doctor Name : Doctor 1</label>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}


{{--        <div class="col-md-4">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h4 align="center"><b>Serial : <span style="color: green">1</span></b></h4>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="row">--}}
{{--                        <div class="form-group col-md-6">--}}
{{--                            <label>Patient Name : Farzad</label>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-6">--}}
{{--                            <label>Mobile : 0123456</label>--}}
{{--                        </div>--}}

{{--                        <div class="form-group col-md-6">--}}
{{--                            <label>Gender : male</label>--}}
{{--                        </div>--}}

{{--                        <div class="form-group col-md-6">--}}
{{--                            <label>Doctor Name : Doctor 1</label>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}




{{--        <div class="col-md-4">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h4 align="center"><b>Serial : <span style="color: green">1</span></b></h4>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="row">--}}
{{--                        <div class="form-group col-md-6">--}}
{{--                            <label>Patient Name : Farzad</label>--}}
{{--                        </div>--}}
{{--                        <div class="form-group col-md-6">--}}
{{--                            <label>Mobile : 0123456</label>--}}
{{--                        </div>--}}

{{--                        <div class="form-group col-md-6">--}}
{{--                            <label>Gender : male</label>--}}
{{--                        </div>--}}

{{--                        <div class="form-group col-md-6">--}}
{{--                            <label>Doctor Name : Doctor 1</label>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}




    </div>



</div>


@endsection
@section('js')
    <script>
        $(function () {
            setInterval(function(){ getSerial(); }, 3000);
        });

        function getSerial() {

            $.ajax({
                type: 'POST',
                url: "{!! route('appointment.runSerialGetData') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}"},
                success: function (data) {
                    $("#runningSerial").html(data);

                }
            });

        }

    </script>
@endsection



