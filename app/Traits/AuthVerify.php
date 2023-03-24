<?php
namespace App\Traits;

use App\Models\Student;
use Illuminate\Http\Request;
 

trait AuthVerify {
    public function registerVerify(Request $request ){
       $student = Student::where('university_id',$request->university_id)->where('id_number',$request->id_number)->first();
        return $student;
    }
}