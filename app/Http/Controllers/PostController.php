<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Post as PostResource;


class PostController extends BaseController
{
    
    public function index()
    {
        $post=Post::all();
        return $this->sendResponse(PostResource::collection($post),'posts listed successfully');
    }

    
    public function store(Request $request)
    {
        $input= $request->all();
        $validator= Validator::make($input,[
            'title'=>'required',
            'descripion'=>'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('validate error', $validator->errors());
        }

        $user=Auth::user();
        $input['user_id']=$user->id;
        $post=Post::create($input);
        return $this->sendResponse($post, 'post added successfully!');



    }

    
    public function show($id)
    {
        $post=Post::find($id);
        if (is_null($post)) {
            return $this->sendError('post not found!');
        }
        return $this->sendResponse(new PostResource($post), 'post showed successfully!');


    }

    
    public function update(Request $request, Post $post)
    {
        $input= $request->all();
        $validator= Validator::make($input,[
            'title'=>'required',
            'descripion'=>'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('post not found!',$validator->errors());
        }
        $post->title=$input['title'];
        $post->descripion=$input['descripion'];
        $post->save();

        return $this->sendResponse(new PostResource($post), 'post updated successfully!');


    }

    
    public function destroy(Post $post)
    {
        $post->delete();

        return $this->sendResponse(new PostResource($post), 'post deleted successfully!');

    }
}
