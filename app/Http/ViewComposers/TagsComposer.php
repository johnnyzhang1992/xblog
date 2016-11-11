<?php
/**
 * Created by PhpStorm.
 * User: lufficc
 * Date: 2016/8/19
 * Time: 14:41
 */
namespace App\Http\ViewComposers;

use App\Http\Repositories\TagRepository;
use Illuminate\View\View;

class TagsComposer
{

    protected $tagRepository;

    /**
     * Create a new profile composer.
     *
     * @internal param UserRepository $users
     * @param TagRepository $tagRepository
     */
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $tags = $this->tagRepository->getAll()->reject(function ($tag) {
            return $tag->posts_count == 0;
        });
        $view->with('tags', $tags);
    }
}