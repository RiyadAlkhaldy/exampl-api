<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function addLike(Request $request){
        $data = Like::where('user_id',$request->user_id)->where('post_id',$request->post_id)->first();
    // return response()->json([$data]);

if(!isset($data)){
    $like = Like::create([
        'post_id'=> $request->post_id,
        'user_id'=> $request->user_id,
        
        ]);
        return response()->json([$like]);
}
    
return response()->json([ 
    'status'=>'success',
    'message'=> 'comment add before',
]);
     
}
}
