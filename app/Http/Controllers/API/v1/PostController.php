<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdatePostRequest;
use Exception;
use App\Models\Post;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Post::latest('id')->paginate(2);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUpdatePostRequest $request
     * @param Post $post
     * @return Response
     */
    public function store(StoreUpdatePostRequest $request, Post $post)
    {
        return $post->create($request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreUpdatePostRequest $request
     * @param Post $post
     * @return bool
     */
    public function update(StoreUpdatePostRequest $request, Post $post)
    {
        return $post->update($request->validated());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return bool
     * @throws Exception
     */
    public function destroy(Post $post)
    {
        return $post->delete();
    }
}
