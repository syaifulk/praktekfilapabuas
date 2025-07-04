<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function detail($slug){
        $post = Post::where('slug', $slug)->firstOrfail();
        return view('post.detail',['post' => $post]);
    }
    public function showArtikel()
    {
    $post = Post::first(); // Atau find(1), atau berdasarkan slug/ID lain
    return view('post.artikel', compact('post'));
    }
    public function penulis()
    {
    $post = Post::with('media')->latest()->first(); // Post terakhir
    return view('post.penulis', compact('post'));
    }
}