<?php

namespace App\Http\Controllers\Seller;

use App\Product;
use App\Category;
use App\Http\Controllers\ResponseController as ResponseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class ProductController extends ResponseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product=Product::all();

        return $this->sendResponse($product->toArray(), "product displayed successfully");
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

        $validator=Validator::make($request->all(), [
            'name'=>'required',
            "spec"=>'required',
            'price'=>'required',
            "picture"=>'image|max:1999',
            "categories_id"=>"required"
        ]);
        if($validator->fails())
        {
            return $this->sendError("validator error", $validator->errors());
        }

        $category=Category::where('id',"=", $request->categories_id)->first();
        if($category==null)
        {
            $this->sendError('category does not exist', 'categories does not exist');

        }
        $category_id=$category->id;
        if($request->hasFile('picture')) {
                $filenameWithExt = $request->file('picture')->getClientOriginalName();

                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('picture')->getClientOriginalExtension();

                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                // $path = $request->file('picture')->storeAs('public/picture', $fileNameToStore);
                // move the file to picture folder in the public directory
                $request->file('picture')->move(public_path() . '/picture/', $fileNameToStore);
        }
        else {
            $fileNameToStore = 'noimage.jpg';
        }
            // dd($fileNameToStore);
        $products=Product::create([
            'name'=>$request->name,
            "spec"=>$request->spec,
            'price'=>$request->price,
            "picture"=>$fileNameToStore,
            "categories_id"=>$category_id
        ]);

            return  $this->sendResponse($products->toArray(), "product created successfully");

        }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=Product::find($id);

        if(is_null($product)){

            return $this->sendError('product does not exist');

        }

        return $this->sendResponse($product->toArray(), 'Success product found');



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
    public function update(Request $request, Product $product)
    {

        $validator=Validator::make($request->all(), [
            'name'=>'required',
            "spec"=>'required',
            'price'=>'required',
            "picture"=>'required',
            "categories_id"=>"required"
        ]);
        if($validator->fails())
        {
            return $this->sendError("validator error", $validator->errors());
        }

        $category=Category::where('id', $request->categories_id)->get();
        if($category==null)
        {
               $this->sendError("categories not provided yet");
        }
        $category_id=$category->id;

        $product=Product::create([
            'name'=>$request->name,
            "spec"=>$request->spec,
            'price'=>$request->price,
            "picture"=>$request->picture,
            "categories_id"=>$category_id
        ]);
        $this->sendResponse($product, "product updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        $this->sendResponse($product, "this product has been deleted");

    }
}
