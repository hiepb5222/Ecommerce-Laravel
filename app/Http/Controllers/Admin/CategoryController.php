<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\CreateCategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    protected $category;
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index(Request $request)
    {
        $categories = Category::latest('id')->paginate(3);
        if ($request->has('keyword') && $request->input('keyword') !== '') {
            $keyword = $request->input('keyword');
            $categories = $this->category->search($keyword)->latest('id')->paginate(5);
        }
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parentCategories = $this->category->getParents();
        return view('admin.categories.create', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $dataCreate = $request->all();
        $category = $this->category->create($dataCreate);

        return redirect()->route('categories.index')->with(['message' => 'Thêm mới ', $category->name . " thành công"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->category->with('childrens')->findOrFail($id);
        $parentCategories = $this->category->getParents();
        return view('admin.categories.edit', compact('category', 'parentCategories'));
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
        $dataUpdate = $request->all();

        $category = $this->category->findOrFail($id);
        $category->update($dataUpdate);

        return redirect()->route('categories.index')->with(['message' => 'Cập nhật ', $category->name . " thành công"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $category = $this->category->findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with(['message' => 'Xóa ', $category->name . " thành công"]);
    }
}
