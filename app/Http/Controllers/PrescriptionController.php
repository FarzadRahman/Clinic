<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   public function index(){
       return view('prescription.pdf');
   }

   public function getPrescription($id){
        $appointment=Appointment::select('appointment.*','patient.*','doctor.*','appointment.id as regNo')
            ->leftJoin('patient','patient.id','appointment.fkpatientId')
            ->leftJoin('doctor','doctor.id','appointment.fkdoctorId')
            ->findOrFail($id);

       return view('prescription.pdf',compact('appointment'));



   }
}
