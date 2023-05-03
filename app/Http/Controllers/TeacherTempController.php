<?php

namespace App\Http\Controllers;

use App\Models\TeacherTemp;
use App\Traits\AuthVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherTempController extends Controller
{
    use AuthVerify;
    public function createTeacherTemp(Request $request){
       $checked= $this->checkIfTecherRegsterBefore($request);
       if(isset($checked)){
        return $checked;

       }
       $teacher = TeacherTemp::create([
        'name' => $request->name,
        'email' => $request->email,
        'colloge_id' => $request->colloge_id,
        'id_number' => $request->id_number ,
        'password' => Hash::make($request->password),
        'type'=>$request->type,
    ]);
    return response()->json([
        'status'=>'success',
        'teacher'=> $teacher,
        ]);
    }

    public function delete(Request $request){
       return TeacherTemp::where('id',1)->trashed();
          
    }
}
