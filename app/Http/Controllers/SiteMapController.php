<?php

namespace App\Http\Controllers;

use App\Contracts\XblogCache;
use App\Http\Requests;
use App\Page;
use App\Post;

class SiteMapController extends Controller
{
    const key = 'sitemap.index';
    const tag = 'sitemap';
    /**
     * @var XblogCache
     */
    private $xblogCache;

    public function index()
    {
        $view = $this->getXblogCache()->remember(SiteMapController::key, function () {
            $posts = Post::select([
                'slug',
                'updated_at',
            ])->orderBy('view_count', 'desc')->get();

            $pages = Page::select(['id', 'name', 'display_name', 'updated_at'])->with('configuration')->get()->reject(function ($page) {
                $result = $page->configuration ? $page->configuration->config['display'] : 'false';
                return $result == 'false';
            });
            return view('sitemap.index', compact('posts', 'pages'))->render();
        });
        return response($view)->header('Content-Type', 'text/xml');
    }

    /**
     * @return XblogCache
     */
    private function getXblogCache()
    {
        if ($this->xblogCache == null) {
            $this->xblogCache = app('XblogCache');
            $this->xblogCache->setTag(SiteMapController::tag);
            $this->xblogCache->setTime(60 * 24);
        }
        return $this->xblogCache;
    }
}
