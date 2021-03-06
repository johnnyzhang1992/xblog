<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed commentable_type
 * @property mixed commentable_id
 */
class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = ['content'];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }


    protected $commentableData = [];

    public function getCommentableData()
    {
        if (empty($this->commentableData)) {
            switch ($this->commentable_type) {
                case 'App\Post':
                    $post = app('App\Post')->where('id', $this->commentable_id)->select('title', 'slug')->firstOrFail();
                    $this->commentableData['type'] = '文章';
                    $this->commentableData['title'] = $post->title;
                    $this->commentableData['url'] = route('post.show', $post->slug);
                    break;
                case 'App\Page':
                    $page = app('App\Page')->where('id', $this->commentable_id)->select('name', 'display_name')->firstOrFail();
                    $this->commentableData['type'] = '页面';
                    $this->commentableData['title'] = $page->display_name;
                    $this->commentableData['url'] = route('page.show', $page->name);
                    break;
                case 'App\Poi':
                    $poi = app('App\Poi')->where('id', $this->commentable_id)->select('id', 'poi_name')->firstOrFail();
                    $this->commentableData['type'] = '游记';
                    $this->commentableData['title'] = $poi->poi_name;
                    $this->commentableData['url'] = url('travel/poi', $poi->id);
                    break;
                case 'App\Book':
                    $book = app('App\Book')->where('id', $this->commentable_id)->select('id', 'book_name')->firstOrFail();
                    $this->commentableData['type'] = '书籍';
                    $this->commentableData['title'] = $book->book_name;
                    $this->commentableData['url'] = url('book/', $book->id);
                    break;
            }
        }

        return $this->commentableData;
    }
}
