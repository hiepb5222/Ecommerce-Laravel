<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Products\CreateProductRequest;
use App\Http\Requests\Products\UpdateProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    protected $product;
    protected $category;
    protected $productDetail;

    public function __construct(Product $product, Category $category, ProductDetail $productDetail)
    {
        $this->product = $product;
        $this->category = $category;
        $this->productDetail = $productDetail;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $this->product->latest('id')->paginate(5);

        if ($request->has('keyword') && $request->input('keyword') !== '') {
            $keyword = $request->input('keyword');
            $products = $this->product->search($keyword)->latest('id')->paginate(5);
        }

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->category->get(['id', 'name','parent_id']);
        
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $dataCreate = $request->except('sizes');
        $sizes = $request->sizes ? json_decode($request->sizes) : [];

        $product = Product::create($dataCreate);
        $dataCreate['image'] = $this->product->saveImage($request);


        $product->images()->create(['url' => $dataCreate['image']]);
        $product->assignCategory($dataCreate['category_ids'] ?? []);
        
        $sizeArray = [];
        foreach ($sizes as $size) {
            $sizeArray[] = ['size' => $size->size, 'quantity' => $size->quantity, 'product_id' => $product->id , 'color' => ''];
        }
        $this->productDetail->insert($sizeArray);
        
        return redirect()->route('products.index')->with(['message' =>'Cập nhập sản phẩm thành công']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        // $product = $this->product->with(['details', 'categories'])->findOrFail($slug);
        $product = $this->product->where('slug', $slug)->with(['details', 'categories'])->firstOrFail();
        $categories = $this->category->get(['id', 'name']);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->product->with(['details', 'categories'])->findOrFail($id);
        $categories = $this->category->get(['id', 'name','parent_id']);
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
         $dataUpdate = $request->except('sizes');
        $sizes = $request->sizes ? json_decode($request->sizes) : [];

        $product = $this->product->findorFail($id);
        $currentImage = $product->images ->count() >0 ? $product->images->first()->url : '';
        $dataUpdate['image'] = $this->product->updateImage($request, $currentImage);
        $product ->update($dataUpdate);
        $product ->images()->delete();
        $product->images()->create(['url' => $dataUpdate['image']]);
        $product->assignCategory($dataUpdate['category_ids'] ?? []);
        
        $sizeArray = [];
        foreach ($sizes as $size) {
            $sizeArray[] = ['size' => $size->size, 'quantity' => $size->quantity, 'product_id' => $product->id , 'color' => ''];
        }
        $product->details()->delete();
        $this->productDetail->insert($sizeArray);
        
        return redirect()->route('products.index')->with(['message' =>'Thêm sản phẩm thành công']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product =$this->product->findOrFail($id);
        $product->delete();
        $product->details()->delete();
        $product->images()->delete();
        $imageName = $product->images->count() >0 ? $product->images->first()->url : '';
        $this->product->deleteImage($imageName);
        return to_route('products.index')->with(['message'=> 'Xóa thành công']);
    }

}
