<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;


class CommentController extends Controller
{
    public function getAllComments(Request $request){
    $data = Comment::get();
    return $data;
    }
    public function addComment(Request $request){
        $data = Comment::get();
        }
}
