<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Category\CreateRequest;
use App\Http\Requests\API\Category\UpdateRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return (new CategoryCollection($categories));
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
            $category = Category::create($data);
            
            return (new CategoryResource($category))->additional([
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
        $category = $this->_findById($id);
        isset($category) ?  $result = (new CategoryResource($category)) :  $result = $this->_noData();
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
        $category = $this->_findById($id);
        if (!isset($category) ) {
            return $this->_noData();
        }
        try {
            $data = $request->validated();
            $category->update($data);
            $category->refresh();
            return (new CategoryResource($category))->additional([
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
        $category = $this->_findById($id);
        if (!isset($category) ) {
            return $this->_noData();
        }
        try {
            $category->delete();
            return response()->json([
                'message' => 'delete data succesfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 422);
        }
    }

    public function _findById($id)
    {
        $category = Category::find($id);
        return $category;
    }

    public function _noData()
    {
        return response()->json(['message' => 'no data found'], 404);
    }
}
