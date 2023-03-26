<?php
namespace App\Traits;

use App\Models\Colloge;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 

trait AuthVerify {
    public function registerVerify(Request $request ){
       $student = Student::where('university_id',$request->university_id)->where('id_number',$request->id_number)->first();
        return $student;
    }
    // public function addCollogeOrSection( $query ){
    //     DB::table('users')->insert([
    //         'email' => 'kayla@example.com',
    //         'votes' => 0
    //     ]);
    //      return "student";
    //  }
     public function getColloge($query){
      return Colloge::where('name',$query->colloge)->first();
    }
    public function setColloge($query){
          Colloge::create(['name'=>$query->colloge]);
      }
        public function getSection($query){
      return Section::where('name',$query->section)->first();

        }
        public function setSection($query,$id){
          Section::create(['name'=>$query->section,'colloge_id'=>$id]);
      
              }
}