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
        $appointment->serialNumber=Appointment::where('appointmentTime',$r->appointmentTime)->count()+1;
        $appointment->save();

        return back();
    }


    public function getData(Request $r){
        $appointments=Appointment::select('appointment.*','doctor.doctorName','patient.*',
            'appointment.id as appointmentId','department.departmentName')
            ->leftJoin('patient','patient.id','appointment.fkpatientId')
            ->leftJoin('doctor','doctor.id','appointment.fkdoctorId')
            ->leftJoin('department','department.id','appointment.fkDepartmentId');

        if($r->doctorId){
            $appointments=$appointments->where('fkdoctorId',$r->doctorId);
        }

        $datatables = Datatables::of($appointments);
        return $datatables->make(true);
    }


    public function runSerial(){

        return view('appoinment.runSerial');
    }
}
