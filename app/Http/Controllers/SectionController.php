<?php

namespace App\Http\Controllers;

use App\Models\Colloge;
use App\Models\Post;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSectionPosts(Request $request){
        $data = Colloge::
        join('sections','sections.colloge_id','=','colloges.id')
       -> join('posts','posts.section_id','=','sections.id')
         ->join('users','users.id','=','posts.id')
         ->where('posts.section_id',$request->section_id)
                    
                    ->select(['posts.*','colloges.name as colloge_name','sections.name as section_name', 'users.name','users.img' ])

                        
                                ->latest()->take(10)
                                ->get();
                    //    ->get(['posts.*','colloges.name as colloge_name','sections.name as section_name', 'users.name','users.img' ]);
                       $posts=[];
     foreach ($data as   $post) {
        # code...
       $numberComments = Post::find($post->id)->comments->count();
       $numberLikes = Post::find($post->id)->likes->count();
       $amILike = Post::find( 38)->likes->count();
       $post->numberComments=$numberComments;
       $post->numberLikes=$numberLikes;
       $post->amILike=$amILike;
      array_push($posts,  $post );
     }
       
 
        return response()->json([
            'status'=>'success',
            'message' => 'The posts',
            'posts'=>$posts,]);
    }
    public function index()
    {
        return Section::find(1)->colloge->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        //
    }
}
