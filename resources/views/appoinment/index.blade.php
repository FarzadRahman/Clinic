@extends('layouts.main')
@section('css')

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <style>
        label {
            font-weight: bold;
        }
    </style>
@endsection
@section('content')
    <!--  Comment  Modal -->
    <div style="text-align: center;" class="modal" id="editModal" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Appointment</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body" id="editModalBody">


                </div>
                <!-- Modal footer -->
                <div class="modal-footer">

                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>




    <div class="card">
        <div class="card-header">
            <h4 align="center"><b>Create New Appointment</b></h4>
        </div>
        <div class="card-body">
            <form method="post" action="{{route('appointment.insert')}}">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" placeholder="patient name" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label>Mobile no.</label>
                        <input type="text" name="mobile_number" class="form-control" placeholder="mobile number"
                               required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Age</label>
                        <input type="text" name="age" class="form-control" placeholder="age" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label>Sex </label>
                        <select name="sex" class="form-control" required>
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label><b>Department</b></label>
                        <select name="fkDepartmentId" class="form-control" required>
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{$department->id}}">{{$department->departmentName}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label><b>Doctor</b></label>
                        <select name="fkdoctorId" class="form-control" required>
                            <option value="">Select Doctor</option>
                            @foreach($doctors as $doctor)
                                <option value="{{$doctor->id}}">{{$doctor->doctorName}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label><b>Date</b></label>
                        <input class="form-control datepicker" name="appointmentTime" placeholder="select date"
                               required>
                    </div>


                    <div class="form-group col-md-12 mt-3">
                        <button class="btn btn-block btn-success">Insert</button>
                    </div>


                </div>
            </form>
        </div>
    </div>


    <div class="card mt-3">
        <div class="card-header">
            <h4 align="center"><b>All Appointments</b></h4>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label><b>Doctor</b></label>
                    <select id="doctorId" class="form-control" onchange="reloadTable()">
                        <option value="">Select Doctor</option>
                        @foreach($doctors as $doctor)
                            <option value="{{$doctor->id}}">{{$doctor->doctorName}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label><b>Date</b></label>
                    <input class="form-control datepicker" onchange="reloadTable()" value="{{date('Y-m-d')}}" id="appointmentTime" placeholder="select date">
                </div>
            </div>

            <table id="appointmentTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Sex</th>
                    <th>Age</th>
                    <th>Time</th>
                    <th>Serial</th>
                    <th>Doctor</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Sex</th>
                    <th>Age</th>
                    <th>Time</th>
                    <th>Serial</th>
                    <th>Doctor</th>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>





@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <script>
        // $(document).ready(function() {
        //     $('#example').DataTable();
        // } );


        $(document).ready(function () {
            dataTable = $('#appointmentTable').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(0)'
                },
                responsive: true,
                processing: true,
                serverSide: true,
                Filter: true,
                stateSave: true,
                type: "POST",
                "ajax": {
                    "url": "{!! route('appointment.getData') !!}",
                    "type": "POST",
                    data: function (d) {
                        d._token = "{{csrf_token()}}";
                        d.date=$('#appointmentTime').val();
                        d.doctorId=$('#doctorId').val();
                        // d.statusId=$('#statusId').val();
                    },
                },
                columns: [

                    {data: 'name', name: 'patient.name'},
                    {data: 'mobile_number', name: 'patient.mobile_number'},
                    {data: 'sex', name: 'patient.sex'},
                    {data: 'age', name: 'patient.age'},
                    {data: 'appointmentTime', name: 'appointment.appointmentTime'},
                    {data: 'serialNumber', name: 'appointment.serialNumber'},
                    {data: 'doctorName', name: 'doctor.doctorName'},
                    { "data": function(data){
                        return ' <div class="dropdown">\n' +
                            '  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">\n' +
                            '  </button>\n' +
                            '  <div class="dropdown-menu">\n' +
                            '    <a class="dropdown-item" onclick="startInQueue(this)" data-panel-id="'+data.appointmentId+'">In</a>\n' +
                            '    <a class="dropdown-item" onclick="edit(this)" data-panel-id="'+data.appointmentId+'">Edit</a>\n' +
                            '    <a class="dropdown-item" href="#">Cancel</a>\n' +
                            '  </div>\n' +
                            '</div> ';
                        },
                        "orderable": false, "searchable":false, "name":"selected_rows" },
                ]
            });
        });

        function reloadTable() {
            dataTable.ajax.reload();
        }

        function startInQueue(x) {
            var id=$(x).data('panel-id');

            $.ajax({
                type: 'POST',
                url: "{!! route('appointment.startInQueue') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'id': id},
                success: function (data) {

                    console.log(data);
                    reloadTable();
                }
            });

        }
        function edit(x) {
            var id=$(x).data('panel-id');

            // alert(id);
            $.ajax({
                type: 'POST',
                url: "{!! route('appointment.edit') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'id': id},
                    success: function (data) {
                    $("#editModalBody").html(data);
                    $("#editModal").modal();
                    // console.log(data);
                }
            });

        }
    </script>

@endsection
