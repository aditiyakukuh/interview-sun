<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Post\CreateRequest;
use App\Http\Requests\API\Post\RemoveTagRequest;
use App\Http\Requests\API\Post\UpdateRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $post = Post::where('user_id', $user->id)->with(['category','tags'])->get();
        return (new PostCollection($post));
    }  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        try {
            $user_id = $request->user()->id;
            $data = $request->validated();
         
            $data = $this->_handleData($data, $user_id);
   
            $post = Post::create($data['createData']);
          
            $post->tags()->sync($data['tags']);  
            
            return (new PostResource($post))->additional([
                'message' => 'create data succesfully'
            ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $user_id = $request->user()->id;
        $post = $this->_findById($id);

        if ($post->user_id != $user_id) {
            return $this->_forbidden();
        }

        isset($post) ?  $result = (new PostResource($post)) :  $result = $this->_noData();
        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $user_id = $request->user()->id;
        $post = $this->_findById($id);

        if (!isset($post) ) {
            return $this->_noData();
        }
        if ($post->user_id != $user_id) {
            return $this->_forbidden();
        }

        try {
            $data = $request->validated();
 
            $data = $this->_handleData($data, $user_id);
        
            $post->update($data['createData']);
        
            $post->tags()->sync($data['tags']);  
            $post->refresh();
            return (new PostResource($post))->additional([
                'message' => 'update data succesfully'
            ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $user_id = $request->user()->id;
        $post = $this->_findById($id);
        
        if (!isset($post) ) {
            return $this->_noData();
        }

        if ($post->user_id != $user_id) {
            return $this->_forbidden();
        }

        try {
            $post->delete();
            return response()->json([
                'message' => 'delete data succesfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 422);
        }
    }

    public function removeTagFromPost(RemoveTagRequest $request,$id)
    {
        $user_id = $request->user()->id;
        $post = $this->_findById($id);

        if (!isset($post) ) {
            return $this->_noData();
        }
        if ($post->user_id != $user_id) {
            return $this->_forbidden();
        }
        
        try {
            $data = $request->validated();
            $post->tags()->detach($data['tags']);  
            $post->refresh();
            return (new PostResource($post))->additional([
                'message' => 'delete data succesfully'
            ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 422);
        }
    }

    public function _findById($id)
    {
        $post = Post::where('id', $id)->with('category','tags')->first();
        return $post;
    }

    public function _noData()
    {
        return response()->json(['message' => 'no data found'], 404);
    }

    public function _forbidden()
    {
        return response()->json(['message' => 'forbidden access'], 403);
    }

    public function _handleData($data, $user_id)
    {
        $tags = $data['tags'];
        $validTagIds = Tag::whereIn('id', $tags)->pluck('id')->toArray();

        unset($data['tags']);
        $data = array_merge($data, ['user_id' => $user_id]);
      
        return [
            "createData" => $data,
            "tags" => $validTagIds
        ];
    }
}
