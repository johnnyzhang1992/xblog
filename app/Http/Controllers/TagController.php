<?php

namespace App\Http\Controllers;

use App\Http\Repositories\TagRepository;
use App\Tag;
use Illuminate\Http\Request;
use XblogConfig;

class TagController extends Controller
{
    public $tagRepository;

    /**
     * TagController constructor.
     * @param TagRepository $tagRepository
     */
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
        $this->middleware(['auth', 'admin'], ['except' => ['show','index']]);
    }

    public function index()
    {
        return view('tag.index');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:tags',
        ]);

        if ($this->tagRepository->create($request)) {
            $this->tagRepository->clearCache();
            return back()->with('success', 'Tag' . $request['name'] . '创建成功');
        } else
            return back()->with('error', 'Tag' . $request['name'] . '创建失败');
    }

    public function show($name)
    {
        $tag = $this->tagRepository->get($name);
        $page_size = $page_size = XblogConfig::getValue('page_size', 7);

        $posts = $this->tagRepository->pagedPostsByTag($tag, $page_size);
        return view('tag.show', compact('posts', 'name'));
    }

    public function destroy(Tag $tag)
    {
        if ($tag->posts()->withoutGlobalScopes()->count() > 0) {
            return redirect()->route('admin.tags')->withErrors($tag->name . '下面有文章，不能刪除');
        }
        if ($tag->delete()) {
            $this->tagRepository->clearCache();
            return back()->with('success', $tag->name . '刪除成功');
        }
        return back()->withErrors($tag->name . '刪除失败');
    }
}
