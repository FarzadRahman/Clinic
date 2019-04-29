<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Department;
use App\Doctor;
use App\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class AppoinmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $doctors=Doctor::get();
        $departments=Department::get();
        return view('appoinment.index',compact('doctors','departments'));
    }

    public function insert(Request $r){
        $patient=new Patient();
        $patient->mobile_number=$r->mobile_number;
        $patient->name=$r->name;
        $patient->sex=$r->sex;
        $patient->age=$r->age;
        $patient->save();

        $appointment=new Appointment();
        $appointment->fkpatientId=$patient->id;
        $appointment->appointmentTime=$r->appointmentTime;
        $appointment->fkdoctorId=$r->fkdoctorId;
        $appointment->fkDepartmentId=$r->fkDepartmentId;
        $appointment->created_by=Auth::user()->id;
        $appointment->status='pending';
        $appointment->serialNumber=Appointment::where('appointmentTime',$r->appointmentTime)->count()+1;
        $appointment->save();

        return back();
    }


    public function getData(Request $r){
        $appointments=Appointment::select('appointment.*','appointment.id as appointmentId','doctor.doctorName','patient.*',
            'appointment.id as appointmentId','department.departmentName')
            ->leftJoin('patient','patient.id','appointment.fkpatientId')
            ->leftJoin('doctor','doctor.id','appointment.fkdoctorId')
            ->leftJoin('department','department.id','appointment.fkDepartmentId')
            ->where('status','pending');

        if($r->doctorId){
            $appointments=$appointments->where('fkdoctorId',$r->doctorId);
        }

        if($r->date){
            $appointments=$appointments->where('appointmentTime',$r->date);
        }

        $datatables = Datatables::of($appointments);
        return $datatables->make(true);
    }

    public function edit(Request $r){

        $appointment=Appointment::select('appointment.*','appointment.id as appointmentId','doctor.doctorName','patient.*',
            'appointment.id as appointmentId','department.departmentName')
            ->leftJoin('patient','patient.id','appointment.fkpatientId')
            ->leftJoin('doctor','doctor.id','appointment.fkdoctorId')
            ->leftJoin('department','department.id','appointment.fkDepartmentId')
            ->findOrFail($r->id);

        $doctors=Doctor::get();
        $departments=Department::get();

//        return $appointment;
        return view('appoinment.edit',compact('appointment','doctors','departments'));
    }

    public function update($id,Request $r){
        $appointment=Appointment::findOrFail($id);
        $appointment->appointmentTime=$r->appointmentTime;
        $appointment->fkdoctorId=$r->fkdoctorId;
        $appointment->fkDepartmentId=$r->fkDepartmentId;
        $appointment->save();

        $patient=Patient::findOrFail($appointment->fkpatientId);
        $patient->mobile_number=$r->mobile_number;
        $patient->name=$r->name;
        $patient->sex=$r->sex;
        $patient->age=$r->age;
        $patient->save();

        return back();

    }

    public function runSerial(){

        return view('appoinment.runSerial');
    }

    public function startInQueue(Request $r){
        Appointment::where('id',$r->id)->update(['status'=>'in']);

    }
}
