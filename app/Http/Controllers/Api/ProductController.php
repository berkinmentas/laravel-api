<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductWithCategoriesResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Integer;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
//        return Product::all();
//        return response()->json(Product::all(),200);
//        return response(Product::all(), 200);
//        return response(Product::paginate(10), 200);
//        return response(Product::offset($request->offset)->limit($request->limit), 200);
        $offset = $request->offset ? $request->offset : 0;
        $limit = $request->limit ? $request->limit : 10;
//        return response(Product::offset($request->offset)->limit($request->limit), 200);

        $qb = Product::query()->with('categories');
        if ($request->has('q'))
            $qb->where('name', 'like', '%' . $request->query('q') . '%');

        if ($request->has('sortBy'))
            $qb->orderBy($request->query('sortBy'), $request->query('sort', 'DESC'));

        $data = $qb->offset($offset)->limit($limit)->get();
        return response($data, 200);
//        $qb = Product::query();
//        if ($request->has('q'))
//            $qb-> where('name', 'like','%',$request);
//        return response(Product::offset($offset)->limit($limit)->get(), 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();

        $product = Product::create($input);


        $product = new Product;
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->price = $request->price;
        $product->save();

        return response([
            'data' => $product,
            'message' => 'Product Created'
        ], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
//        return response($product,200);
//        return  $product;

        $product = Product::find($id);
        if ($product)
            return response($product, 200);
        else
            return response(['message' => 'Product Not Found'], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $input = $request->all();
        $product->update($input);

        return response([
            'data' => $product,
            'message' => 'Product Updated'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $product->delete();

        return response([
            'message' => 'Product Deleted'
        ], 200);
    }

    public function custom1()
    {
//        return Product::select('id', 'name')->orderBy('created_at', 'desc')->take(10)->get();
        return Product::selectRaw('id as product_id, name as product_name')
            ->orderBy('created_at', 'desc')
            ->take(10)->get();
    }

    public function custom2()
    {

        $products = Product::orderBy('created_at', 'desc')->take(10)->get();

        $mapped = $products->map(function ($product) {
            return [
                '_id' => $product['id'],
                'product_name' => $product['name'],
                'product_price' => $product['price'] * 1.03
            ];
        });
        return $mapped->all();
    }

    public function custom3(){

        $products = Product::paginate(10);
        return ProductResource::collection($products);
    }

    public function listWithCategories(){
        $products = Product::paginate();
        return ProductWithCategoriesResource::collection($products);
    }
}
