<?php

namespace App\Http\Controllers;

use App\Appointment;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;

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
//       $connector = new FilePrintConnector("php://stdout");
//       $printer = new Printer($connector);
//       $printer -> text("Hello World!\n");
//       $printer -> cut();
//       $printer -> close();
//
//       return "printed";
        $appointment=Appointment::select('appointment.*','patient.*','doctor.*','appointment.id as regNo')
            ->leftJoin('patient','patient.id','appointment.fkpatientId')
            ->leftJoin('doctor','doctor.id','appointment.fkdoctorId')
            ->findOrFail($id);

       return view('prescription.pdf',compact('appointment'));



   }
}
