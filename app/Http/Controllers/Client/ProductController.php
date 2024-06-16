<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $product;
    public function __construct(Product $product,Category $category)
    {
        $this->product = $product;
        $this->category = $category;
    }
    public function index(Request $request, $category_id)
    {
        $products = $this->product->getBy($request->all, $category_id);
        $categories = $this->category->whereNull('parent_id')->get(['id', 'name']);;
        // return view('client.products.index', compact('product'));
        return view('client.products.index', compact('products','categories'));
    }


    public function listSearch(Request $request)
    {
        $keyword = $request->input('keyword');
        $products = $this->product->search($keyword)->get();
        $categories = $this->category->whereNull('parent_id')->get(['id', 'name']);;
        if ($products->isEmpty()) {
            return view('client.products.index', compact('products'))->with(['message' =>'Không tìm thấy kết quả']);
        }
        
        
        return view('client.products.index', compact('products','categories'));
    }
    public function autocompleteSearch(Request $request)
    {
        $keyword = $request->input('keyword');
        $products = $this->product->search($keyword)->limit(5)->get(['name', 'slug']); // Lấy các thuộc tính cần thiết

        return response()->json($products);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = $this->product->where('slug', $slug)->with('details')->firstOrFail();
        return view('client.products.detail', compact('product'));
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function filterByCategory(Request $request)
    {
       // Lấy tất cả các danh mục với số lượng sản phẩm

       $categories = Category::withCount('products')->get();
       

       // Kiểm tra xem có tham số 'categories' trong request hay không
       $categoryIds = $request->input('categories', []);

       if (empty($categoryIds)) {
           // Nếu không có danh mục nào được chọn, hiển thị tất cả sản phẩm
           $products = Product::paginate(10);
       } else {
           // Nếu có danh mục được chọn, lọc sản phẩm theo danh mục
           $products = Product::whereHas('categories', function ($query) use ($categoryIds) {
               $query->whereIn('categories.id', $categoryIds);
           })->paginate(10);
       }

       $message = $products->isEmpty() ? 'Không tìm thấy sản phẩm nào' : null;

       return view('client.products.index', compact('products', 'categories'));
    }
}
