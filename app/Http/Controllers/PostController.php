<?php

namespace App\Http\Controllers;

use App\Models\Colloge;
use App\Models\Post;
use App\Models\User;
use App\Notifications\CreatePost;
// use Auth;
use App\Traits\UploadFile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
{
    use UploadFile;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllPosts(){
        // $data = Colloge::join('sections','sections.colloge_id','=','colloges.id')
        //                ->join('posts','posts.section_id','=','sections.id')->get(['colloges.name as colloge_name','sections.name as section_name','posts.*']);
        // return $data;
        $data = Colloge::join('sections','sections.colloge_id','=','colloges.id')
                       ->join('users','users.section_id','=','sections.id')
                         ->join('posts','posts.section_id','=','sections.id')->limit(8)
                         ->orderBy('created_at', 'desc')
                       ->get(['posts.*','colloges.name as colloge_name','sections.name as section_name', 'users.name','users.img' ]);
        return response()->json([
            'status'=>'success',
            'message' => 'The posts',
            'posts'=>$data,]);
    }

   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        
        return 'create';
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = Post::create([
            'content'=>$request->content,
            'type'=>$request->type,
            'url'=> $request->url ,
            'user_id'=>  $request->user_id,
            'section_id'=>  $request->section_id,
            'colloge_id'=>  $request->colloge_id,
            
        ]);
        // $users = User::where('id','!=',Auth('api')->user()->id)->get();
        $users = User::where('id','!=',Auth('api')->user()->id)->where('colloge_id',$request->colloge_id)->get();
        $user_cteate=Auth('api')->user()->name;

        Notification::send($users,new CreatePost($user_cteate,$post->id));
        return   response()->json([
            'status' => 'success',
            'message' => 'Post  created and stored successfully',
            
        ]);
        
    }
    // public function store(Request $request)
    // {
    //     $post = Post::create([
    //         'title'=>$request->title,
    //         'body'=>$request->body ,
    //     ]);
    //     $users = User::where('id','!=',Auth('api')->user()->id)->get();
    //     $user_cteate=Auth('api')->user()->name;

    //     Notification::send($users,new CreatePost($user_cteate,$post->id));
    //     return  $user_cteate;
        
    // }
    public function showNotifications(Post $post)
    
    {
        // $notifications = Auth('api')->user()->unreadNotifications;
        $notifications = Auth('api')->user()->notifications;
        return $notifications;
        
    }
    public function storeFile(Request $request)
    {
        $path = $this->uploadImage($request,'users');//like user image
       
        return $path; 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return 'show';
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return 'edit';
        
    }
 
    public function update(Request $request, Post $post)
    {
        return 'update';
        
    }

    
    public function destroy(Request $request)
    {
        // Post::
        return response()->json(['status'=>'delete']);
    }
    public function delete(Request $request)
    {
        $post = Post::where('id',$request->id)->delete();

        // Post::
        if(isset($post)){
            return response()->json(['status'=>'delete']);

        }
    }
}