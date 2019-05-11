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
                    <input class="form-control datepicker" onchange="reloadTable()"  id="appointmentTime" placeholder="select date">
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
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                </tbody>

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
                    "url": "{!! route('appointment.getAllApointmentData') !!}",
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
                    {data: 'status', name: 'appointment.status'},
                    { "data": function(data){
                            return ' <div class="dropdown">\n' +
                                '  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">\n' +
                                '  </button>\n' +
                                '  <div class="dropdown-menu">\n' +
                                '    <a class="dropdown-item" onclick="startInQueue(this)" data-panel-id="'+data.appointmentId+'">In</a>\n' +
                                '    <a class="dropdown-item" onclick="edit(this)" data-panel-id="'+data.appointmentId+'">Edit</a>\n' +
                                '    <a class="dropdown-item" onclick="print(this)" data-panel-id="'+data.appointmentId+'">Print</a>\n' +
                                '    <a class="dropdown-item" onclick="cancel(this)" data-panel-id="'+data.appointmentId+'">Cancel</a>\n' +
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

        function print(x) {
            var id=$(x).data('panel-id');

            let url = "{{ route('prescription.get', ':id') }}";
            url = url.replace(':id', id);
            // document.location.href=url;
            window.open(url,'_blank');

            // alert('id');
        }

        function startInQueue(x) {
            var id=$(x).data('panel-id');

            $.ajax({
                type: 'POST',
                url: "{!! route('appointment.startInQueue') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'id': id},
                success: function (data) {

                    toastr["success"]("Appointment In", "Success");

                    // console.log(data);
                    reloadTable();
                }
            });
        }
        function cancel(x) {
            var id=$(x).data('panel-id');

            $.ajax({
                type: 'POST',
                url: "{!! route('appointment.cancel') !!}",
                cache: false,
                data: {_token: "{{csrf_token()}}",'id': id},
                success: function (data) {
                    toastr["error"]("Appointment Canceled", "Warning")
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
