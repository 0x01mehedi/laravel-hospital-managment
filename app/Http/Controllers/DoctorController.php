<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Doctor;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Pagination\Paginator;


class DoctorController extends Controller{

   public function __construct(){
      $this->middleware('auth');
  }

   public function index(){

      $doctors = Doctor::paginate(5);
      return view("pages.doctor.index", ["doctors" => $doctors]);

   //    $doctors = DB::table('doctors')->get();
   //    $doctors = Doctor::paginate(5);
   //    //print_r(Role::all());
   //   return view("pages.doctor.index",["doctors"=>Doctor::all()]);
   }

   public function create(){
      return view("pages.doctor.create"); 
   }

   public function store(Request $request){
      //echo $request->name;
      $r=new Doctor();
      $r->name=$request->name;
      $r->email=$request->email;
      $r->phone=$request->phone;
      $r->save();

      return redirect()->route("doctors.index")->with('success','Success.');

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


   public function show($id){
      echo "Show:".$id;
      // return view("pages.role.show");
   }

   public function delete($id){
      $doctor=Doctor::find($id);
      //echo $role->id;
      return view("pages.doctor.delete",["doctor"=>$doctor]);
   }

   public function destroy(Doctor $doctor){
      $doctor->delete();
      return redirect()->route("doctors.index")->with('success','Success.');
   }

}