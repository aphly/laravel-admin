<?php

namespace Aphly\LaravelAdmin\Controllers;

class Controller extends \Aphly\Laravel\Controllers\Controller
{
    public function index_url($post): string
    {
        if (!empty($post['pid'])) {
            return $this->index_url . '?pid=' . $post['pid'];
        } else {
            return $this->index_url;
        }
    }
}
