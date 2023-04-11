<?php

namespace App\Http\Controllers;

use App\Models\Colloge;
use Illuminate\Http\Request;

class CollogeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCollogePosts(Request $request){
        // $data = Colloge::join('sections','sections.colloge_id','=','colloges.id')
        //                ->join('posts','posts.section_id','=','sections.id')->get(['colloges.name as colloge_name','sections.name as section_name','posts.*']);
        // return $data;
        $data = Colloge::join('sections','sections.colloge_id','=','colloges.id')
                       ->join('users','users.section_id','=','sections.id')
                        ->join('posts','posts.section_id','=','sections.id')->where('colloges.id',$request->colloge_id)->limit(4)
                       ->get(['posts.*','colloges.name as colloge_name','sections.name as section_name', 'users.name','users.img' ]);
        return response()->json(['posts'=>$data]);
    }
    public function index(Request $request)
    {
       $sections = Colloge::find(2);
       return $sections->sections;
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
     * @param  \App\Models\Colloge  $colloge
     * @return \Illuminate\Http\Response
     */
    public function show(Colloge $colloge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Colloge  $colloge
     * @return \Illuminate\Http\Response
     */
    public function edit(Colloge $colloge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Colloge  $colloge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Colloge $colloge)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Colloge  $colloge
     * @return \Illuminate\Http\Response
     */
    public function destroy(Colloge $colloge)
    {
        //
    }
}
