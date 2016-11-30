<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TravelController extends Controller
{
    protected $postRepository;

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
    }

    public function index()
    {
        return view('travel.index');
    }
}
?>