<?php
/**
 * Created by PhpStorm.
 * User: lufficc
 * Date: 2016/8/19
 * Time: 17:41
 */
namespace App\Http\Repositories;

use App\Configuration;
use App\Post;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Lufficc\MarkDownParser;

/**
 * design for cache
 *
 *
 * Class PostRepository
 * @package App\Http\Repository
 */
class PostRepository extends Repository
{

    protected $markDownParser;

    static $tag = 'post';

    /**
     * PostRepository constructor.
     * @param MarkDownParser $markDownParser
     */
    public function __construct(MarkDownParser $markDownParser)
    {
        $this->markDownParser = $markDownParser;
    }

    public function model()
    {
        return app(Post::class);
    }

    public function count()
    {
        $count = $this->remember($this->tag() . '.count', function () {
            return $this->model()->withoutGlobalScopes()->count();
        });
        return $count;
    }

    /**
     * @param int $page
     * @return mixed
     */
    public function pagedPostsWithoutGlobalScopes($page = 20)
    {
        $posts = $this->remember('post.WithOutContent.' . $page . '' . request()->get('page', 1), function () use ($page) {
            return Post::withoutGlobalScopes()->orderBy('created_at', 'desc')->select(['id', 'title', 'slug', 'deleted_at', 'published_at', 'status'])->paginate($page);
        });
        return $posts;
    }

    /**
     * @param int $page
     * @return mixed
     */
    public function pagedPosts($page = 7)
    {
        $posts = $this->remember('post.page.' . $page . '' . request()->get('page', 1), function () use ($page) {
            return Post::select(Post::selectArrayWithOutContent)->with(['tags', 'category'])->withCount('comments')->orderBy('created_at', 'desc')->paginate($page);
        });
        return $posts;
    }

    /**
     * @param $slug string
     * @return Post
     */
    public function get($slug)
    {
        $post = $this->remember('post.one.' . $slug, function () use ($slug) {
            return Post::where('slug', $slug)->with(['tags', 'category', 'configuration'])->withCount('comments')->firstOrFail();
        });
        return $post;
    }

    public function achieve()
    {
        $posts = $this->remember('post.achieve', function () {
            return Post::select([
                'id',
                'title',
                'slug',
                'created_at',
            ])->orderBy('created_at', 'desc')->get();
        });
        return $posts;
    }

    public function getWithoutContent($post_id)
    {
        $post = $this->remember('post.one.wc.' . $post_id, function () use ($post_id) {
            return Post::where('id', $post_id)->select(Post::selectArrayWithOutContent)->first();
        });
        if (!$post)
            abort(404);
        return $post;
    }

    /**
     * @param Request $request
     * @return mixed
     */

    public function create(Request $request)
    {
        $this->clearAllCache();

        $ids = [];
        $tags = $request['tags'];
        if (!empty($tags)) {
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                array_push($ids, $tag->id);
            }
        }
        $status = $request->get('status', 0);
        if ($status == 1) {
            $request['published_at'] = Carbon::now();
        }

        $post = auth()->user()->posts()->create(
            array_merge(
                $request->except('_token'),
                ['html_content' => $this->markDownParser->parse($request->get('content'), false)]
            )
        );
        $post->tags()->sync($ids);

        $configuration = new Configuration();
        $configuration->config = [
            'comment_type' => $request['comment_type'],
            'comment_info' => $request['comment_info'],
        ];

        $post->configuration()->save($configuration);

        return $post;
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return bool|int
     */

    public function update(Request $request, Post $post)
    {
        $this->clearAllCache();

        $ids = [];
        $tags = $request['tags'];
        if (!empty($tags)) {
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                array_push($ids, $tag->id);
            }
        }
        $post->tags()->sync($ids);

        $status = $request->get('status', 0);
        if ($status == 1) {
            $request['published_at'] = Carbon::now();
        }
        $configuration = $post->configuration;
        if (!$configuration)
        {
            $configuration = new Configuration();
            $configuration->config = [
                'comment_type' => $request['comment_type'],
                'comment_info' => $request['comment_info'],
            ];
            $post->configuration()->save($configuration);
        }
        else{
            $configuration->config = [
                'comment_type' => $request['comment_type'],
                'comment_info' => $request['comment_info'],
            ];
            $configuration->save();
        }

        return $post->update(
            array_merge(
                $request->except('_token'),
                ['html_content' => $this->markDownParser->parse($request->get('content'), false)]
            ));
    }


    public function tag()
    {
        return PostRepository::$tag;
    }
}