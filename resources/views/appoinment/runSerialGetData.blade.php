
@foreach($appointments as $appointment)
<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h4 align="center"><b>Serial : <span style="color: green">{{$appointment->serialNumber}}</span></b></h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-6">
                    <label>Patient Name : {{$appointment->name}}</label>
                </div>
                <div class="form-group col-md-6">
                    <label>Mobile : {{$appointment->mobile_number}}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>Gender : {{$appointment->sex}}</label>
                </div>

                <div class="form-group col-md-6">
                    <label>Doctor Name : {{$appointment->doctorName}}</label>
                </div>
            </div>

        </div>
    </div>
</div>

    @endforeach