<?php
/**
 * Created by PhpStorm.
 * User: lufficc
 * Date: 2016/9/21
 * Time: 23:00
 */

namespace Lufficc;

use Parsedown;

class MarkDownParser
{
    protected $parseDown;

    /**
     * MarkDownParser constructor.
     */
    public function __construct()
    {
        $this->parseDown = new Parsedown();
    }

    public function parse($markdown, $clean = true)
    {
        $convertedHtml = $this->parseDown->setBreaksEnabled(true)->text($markdown);
        if ($clean) {
            $convertedHtml = clean($convertedHtml, 'user_comment_content');
        }
        return $convertedHtml;
    }
}