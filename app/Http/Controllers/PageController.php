<?php

namespace App\Http\Controllers;

use App\Http\Repositories\PageRepository;
use App\Page;
use Illuminate\Http\Request;

use App\Http\Requests;

class PageController extends Controller
{

    protected $pageRepository;

    /**
     * PageController constructor.
     * @param $pageRepository
     */
    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
        $this->middleware(['auth', 'admin'], ['except' => 'show']);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('page.create');
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
            'name' => 'required|unique:pages',
            'display_name' => 'required',
            'content' => 'required',
        ]);

        if ($this->pageRepository->create($request)) {
            return redirect()->route('admin.index')->with('success', '页面' . $request['name'] . '创建成功');
        }
        return back()->withInput()->with('error', '页面' . $request['name'] . '创建失败');
    }

    public function pageShowing($page)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $unreadNotifications = $user->unreadNotifications;
            foreach ($unreadNotifications as $notifications) {
                $comment = $notifications->data;
                if ($comment['commentable_type'] == 'App\Page' && $comment['commentable_id'] == $page->id) {
                    $notifications->markAsRead();
                }
            }
        }
    }

    public function show($name)
    {
        $page = $this->pageRepository->get($name);
        if ($page->configuration && $page->configuration->config['display'] == 'false') {
            if (isAdmin(auth()->user())) {
                return view('page.show', compact('page'));
            } else {
                abort(404);
            }
        }
        $this->pageShowing($page);
        return view('page.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Page $page
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(Page $page)
    {
        return view('page.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Page $page
     * @return mixed
     * @internal param $name
     * @internal param string $page
     * @internal param int $id
     */
    public function update(Request $request, Page $page)
    {
        $this->validate($request, [
            'name' => 'required',
            'display_name' => 'required',
            'content' => 'required',
        ]);
        if ($this->pageRepository->update($request, $page)) {
            return redirect()->route('admin.index')->with('success', '页面' . $request['name'] . '修改成功');
        }
        return back()->withInput()->withErrors('页面' . $request['name'] . '修改失败');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->pageRepository->clearCache();
    }
}
