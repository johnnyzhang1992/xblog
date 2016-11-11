<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Repositories\CategoryRepository;
use App\Http\Requests;
use Illuminate\Http\Request;
use XblogConfig;
class CategoryController extends Controller
{
    protected $categoryRepository;

    /**
     * CategoryController constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->middleware(['auth', 'admin'], ['except' => ['show','index']]);
    }
    public function index()
    {
        return view('category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories',
        ]);

        if ($this->categoryRepository->create($request))
            return back()->with('success', '分类' . $request['name'] . '创建成功');
        else
            return back()->with('error', '分类' . $request['name'] . '创建失败');
    }

    /**
     * Display the specified resource.
     *
     * @param $name
     * @return \Illuminate\Http\Response
     * @internal param Category $category
     * @internal param int $id
     */
    public function show($name)
    {
        $category = $this->categoryRepository->get($name);
        $page_size = $page_size = XblogConfig::getValue('page_size', 7);
        $posts = $this->categoryRepository->pagedPostsByCategory($category, $page_size);
        return view('category.show', compact('posts', 'name'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Category $category
     * @return mixed
     * @internal param int $id
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories',
        ]);

        if ($this->categoryRepository->update($request, $category)) {
            return redirect()->route('admin.categories')->with('success', '分类' . $request['name'] . '修改成功');
        }

        return back()->withInput()->withErrors('分类' . $request['name'] . '修改失败');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return mixed
     * @internal param int $id
     */
    public function destroy(Category $category)
    {
        if ($category->posts()->withoutGlobalScopes()->count() > 0) {
            return redirect()->route('admin.categories')->withErrors($category->name . '下面有文章，不能刪除');
        }
        $this->categoryRepository->clearCache();
        if ($category->delete())
            return back()->with('success', $category->name . '刪除成功');
        return back()->withErrors($category->name . '刪除失败');
    }
}
