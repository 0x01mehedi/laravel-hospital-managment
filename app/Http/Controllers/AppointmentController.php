<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
// use App\Http\Controllers\Appointment;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\AppointmentStatuse;

use Illuminate\Support\Facades\DB;
// use Illuminate\Pagination\Paginator;


class AppointmentController extends Controller{

   public function __construct(){
      $this->middleware('auth');
  }

   public function index(){

      $appointments = Appointment::paginate(5);

    //   $appointments=DB::table("appointments as a")
    //   ->join("patients as u","p.uom_id","=","u.id")
    //   ->join("bloods as g","g.id","=","p.bloods_id")
    //   ->select("p.id","p.name","g.name as blood","p.email","p.contact_number","p.address","p.photo")
    //   ->paginate(2);

      return view("pages.appointment.index", ["appointments" => $appointments]);

   //    $doctors = DB::table('doctors')->get();
   //    $doctors = Doctor::paginate(5);
   //    //print_r(Role::all());
   //   return view("pages.doctor.index",["doctors"=>Doctor::all()]);
   }

   public function create(){
    $appointments = DB::table('appointments')->get();
    $patients=Patient::all();
    $statuses=AppointmentStatuse::all();
    $doctors=Doctor::all();
      return view("pages.appointment.create",["appointments" => $appointments,"patients" => $patients,"statuses" => $statuses,"doctors" => $doctors]); 
   }

   public function store(Request $request){
      //echo $request->name;
    
      $r=new Appointment();
      $r->patient_id=$request->patient;
      $r->doctor_id=$request->doctor;
      $r->appointment_date=$request->date;
      $r->appointment_statuses_id=$request->status;
      $r->save();

      return redirect()->route("appointments.index")->with('success','Success.');

   }


   public function edit(Doctor $doctor){
      //echo "Edit:".$id;
      //$role=Role::find($id);
      return view("pages.doctor.edit", ["doctor"=>$doctor]); 
   }

  public function update(Request $request,Doctor $doctor){
     //echo "Update:".$id;
     //$role= Role::find($id);
     $doctor->name=$request->name;
     $doctor->phone=$request->phone;
     $doctor->update();
     return redirect()->route("doctors.index")->with('success','Success.');
  }  


  public function show(Patient $patient){
    $patientDetail = DB::table("patients as p")
        ->join("bloods as b", "b.id", "=", "p.bloods_id")
        ->join("genders as g", "g.id", "=", "p.gender_id")
        ->join("types as t", "t.id", "=", "p.type_id")
        ->join("doctors as d", "d.id", "=", "p.doctor_id")
        ->select("p.id", "p.name", "p.dob", "b.name as blood", "g.name as gender", "p.email", "p.employee", "p.contact_number as contact", "p.address", "t.name as type", "d.name as doctor", "p.photo")
        ->where("p.id", $patient->id)
        ->first();
 
    return view('pages.patient.show', ["patient" => $patientDetail]);
 } 
 
    public function delete($id){
       $patient=Patient::find($id);
       //echo $role->id;
       return view("pages.patient.delete",["patient"=>$patient]);
    }
 
    public function destroy(Patient $patient){
       $patient->delete();
       return redirect()->route("patients.index")->with('success','Success.');
    }

}