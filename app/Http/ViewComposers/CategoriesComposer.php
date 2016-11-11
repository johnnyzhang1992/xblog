<?php
/**
 * Created by PhpStorm.
 * User: lufficc
 * Date: 2016/8/19
 * Time: 14:41
 */
namespace App\Http\ViewComposers;

use App\Http\Repositories\CategoryRepository;
use Illuminate\View\View;

class CategoriesComposer
{

    protected $categoryRepository;

    /**
     * Create a new profile composer.
     *
     * @internal param UserRepository $users
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $categories = $this->categoryRepository->getAll()->reject(function ($category) {
            return $category->posts_count == 0;
        });
        $view->with('categories', $categories);
    }
}