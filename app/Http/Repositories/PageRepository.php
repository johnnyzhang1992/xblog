<?php
/**
 * Created by PhpStorm.
 * User: lufficc
 * Date: 2016/8/19
 * Time: 17:41
 */
namespace App\Http\Repositories;

use App\Configuration;
use App\Page;
use Illuminate\Http\Request;
use Parsedown;

/**
 * Class PageRepository
 * @package App\Http\Repository
 */
class PageRepository extends Repository
{
    static $tag = 'page';
    protected $parseDown;

    public function __construct()
    {
        $this->parseDown = new Parsedown();
    }

    public function model()
    {
        return app(Page::class);
    }

    /**
     * @param $name string
     * @return mixed
     */
    public function get($name)
    {
        $page = $this->remember('page.one.' . $name, function () use ($name) {
            return Page::where('name', $name)->with('configuration')->withCount(['comments'])->first();
        });

        if (!$page)
            abort(404);
        return $page;
    }

    public function getAll()
    {
        $page = $this->remember('page.all.', function () {
            return Page::select(['id', 'name', 'display_name'])->with('configuration')->get();
        });

        if (!$page)
            abort(404);
        return $page;
    }

    /**
     * @param Request $request
     * @return Page
     */
    public function create(Request $request)
    {
        $this->clearCache();
        $page = Page::create(array_merge(
            $request->except('_token'),
            ['html_content' => $this->parseDown->text($request->get('content'))]
        ));

        $configuration = new Configuration();
        $configuration->config = [
            'comment_type' => $request['comment_type'],
            'comment_info' => $request['comment_info'],
            'display' => $request['display'],
            'sort_order' => $request['sort_order'],
        ];
        $page->configuration()->save($configuration);
        return $page;
    }

    public function update(Request $request, Page $page)
    {
        $this->clearCache();
        $configuration = $page->configuration;
        if (!$configuration) {
            $configuration = new Configuration();
            $configuration->config = [
                'comment_type' => $request['comment_type'],
                'comment_info' => $request['comment_info'],
                'display' => $request['display'],
                'sort_order' => $request['sort_order'],
            ];
            $page->configuration()->save($configuration);
        } else {
            $configuration->config = [
                'comment_type' => $request['comment_type'],
                'comment_info' => $request['comment_info'],
                'display' => $request['display'],
                'sort_order' => $request['sort_order'],
            ];
            $configuration->save();
        }
        return $page->update(array_merge(
            $request->except('_token'),
            ['html_content' => $this->parseDown->text($request->get('content'))]
        ));
    }

    public function tag()
    {
        return PageRepository::$tag;
    }
}