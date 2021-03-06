<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Department;
use App\Doctor;
use App\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class AppoinmentController extends Controller
{

    public function __construct()
    {
        date_default_timezone_set('Asia/Dhaka');
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

    public function getAllApointmentData(Request $r){
        $appointments=Appointment::select('appointment.*','appointment.id as appointmentId','doctor.doctorName','patient.*',
            'appointment.id as appointmentId','department.departmentName')
            ->leftJoin('patient','patient.id','appointment.fkpatientId')
            ->leftJoin('doctor','doctor.id','appointment.fkdoctorId')
            ->leftJoin('department','department.id','appointment.fkDepartmentId');

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


    public function startInQueue(Request $r){
        Appointment::where('id',$r->id)->update(['status'=>'in','start_at'=>Carbon::now()]);

    }
    public function cancel(Request $r){
        Appointment::where('id',$r->id)->update(['status'=>'canceled']);

    }

    public function runSerial(){

        return view('appoinment.runSerial');
    }


    public function runSerialGetData(){

        $appointments= $appointment=Appointment::select('serialNumber','doctor.doctorName','patient.*',
            'department.departmentName')
            ->where('appointmentTime',date('Y-m-d'))
            ->leftJoin('patient','patient.id','appointment.fkpatientId')
            ->leftJoin('doctor','doctor.id','appointment.fkdoctorId')
            ->leftJoin('department','department.id','appointment.fkDepartmentId')
            ->whereIn('appointment.start_at', function($query){
                $query->select(DB::raw('MAX(start_at)'))
                    ->from('appointment')
                    ->where('status','in')
                    ->groupBy('appointment.fkdoctorId');
            })
            ->get();
        return view('appoinment.runSerialGetData',compact('appointments'));
    }

}
