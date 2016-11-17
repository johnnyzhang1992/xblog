<?php
/**
 * Created by PhpStorm.
 * User: zq199
 * Date: 2016/11/17
 * Time: 17:29
 */

namespace App\Http\Repositories;

use App\Configuration;
use Illuminate\Http\Request;
use Lufficc\MarkDownParser;

/**
 * design for cache
 *
 *
 * Class VisitorsRepository
 * @package App\Http\Repository
 */
class VisitorsRepository extends Repository
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
//        $count = $this->remember($this->tag() . '.count', function () {
//            return $this->model()->withoutGlobalScopes()->count();
////        });
//        return $count;
    }
}
