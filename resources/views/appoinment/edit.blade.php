<form method="post" action="{{route('appointment.update',['id'=>$appointment->appointmentId])}}">
    @csrf
    <div class="row">
        <div class="form-group col-md-6">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{$appointment->name}}" placeholder="patient name" required>
        </div>

        <div class="form-group col-md-6">
            <label>Mobile no.</label>
            <input type="text" name="mobile_number" class="form-control" value="{{$appointment->mobile_number}}" placeholder="mobile number"
                   required>
        </div>

        <div class="form-group col-md-4">
            <label>Age</label>
            <input type="text" name="age" class="form-control" placeholder="age" value="{{$appointment->age}}" required>
        </div>

        <div class="form-group col-md-4">
            <label>Sex</label>
            <select name="sex" class="form-control" required>
                <option value="">Select Gender</option>
                @foreach(Gender as $gen)
                    <option value="{{$gen}}"  @if($gen== $appointment->sex) selected @endif>{{$gen}}</option>
                @endforeach

            </select>
        </div>

        <div class="form-group col-md-4">
            <label><b>Department</b></label>
            <select name="fkDepartmentId" class="form-control" required>
                <option value="">Select Department</option>
                @foreach($departments as $department)
                    <option value="{{$department->id}}" @if($department->id== $appointment->fkDepartmentId) selected @endif>{{$department->departmentName}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-4">
            <label><b>Doctor</b></label>
            <select name="fkdoctorId" class="form-control" required>
                <option value="">Select Doctor</option>
                @foreach($doctors as $doctor)
                    <option value="{{$doctor->id}}" @if($doctor->id== $appointment->fkdoctorId) selected @endif>{{$doctor->doctorName}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-4">
            <label><b>Date</b></label>
            <input class="form-control datepicker" name="appointmentTime" value="{{$appointment->appointmentTime}}" placeholder="select date"
                   required>
        </div>


        <div class="form-group col-md-12 mt-3">
            <button class="btn btn-block btn-success">Update</button>
        </div>


    </div>
</form>



<script>
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });
</script>