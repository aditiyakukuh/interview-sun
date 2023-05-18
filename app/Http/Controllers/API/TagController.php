<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Tag\CreateRequest;
use App\Http\Requests\API\Tag\UpdateRequest;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::all();
        return (new TagCollection($tags));
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
            $data = $request->validated();
            $tag = Tag::create($data);
            
            return (new TagResource($tag))->additional([
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
    public function show($id)
    {
        $tag = $this->_findById($id);
        isset($tag) ?  $result = (new TagResource($tag)) :  $result = $this->_noData();
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
        $tag = $this->_findById($id);
        if (!isset($tag) ) {
            return $this->_noData();
        }
        try {
            $data = $request->validated();
            $tag->update($data);
            $tag->refresh();
            return (new TagResource($tag))->additional([
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
    public function destroy($id)
    {
        $tag = $this->_findById($id);
        if (!isset($tag) ) {
            return $this->_noData();
        }
        try {
            $tag->delete();
            return response()->json([
                'message' => 'delete data succesfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 422);
        }
    }

    public function _findById($id)
    {
        $category = Tag::find($id);
        return $category;
    }

    public function _noData()
    {
        return response()->json(['message' => 'no data found'], 404);
    }
}
