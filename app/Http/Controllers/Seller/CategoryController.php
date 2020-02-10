<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ResponseController as ResponseController;
use App\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class CategoryController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category=Category::all();

        $this->sendResponse($category->toArray(),'category listed succesfully');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(is_null($request->all())){
            return $this->sendError("Validation Error", 'request in empty');
        }


         $category=Category::create(['name'=>$request->name]);

         return $this->sendResponse($category,"category created successfully");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category=Category::find($id);

        if(is_null($category)){

            return $this->sendError('Category does not exist');

        }

        return $this->sendResponse($category->toArray(), 'Success categories found');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required'
        ]);
        if($validator->fails()){
           return $this->sendError($validator->errors(), 'check this name plsease');
        }
        return $this->sendResponse($category->toArray(), "categories updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->sendResponse($category->toArray(), 'deleted successfully');
    }
}
