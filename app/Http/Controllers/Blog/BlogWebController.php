<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogWebController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $posts = Post::with(['category', 'tags', 'user'])->paginate(8);   
       
        return view('blog.index', compact('posts', 'categories'));
    }

    public function byCategory($category_id)
    {
        $categories = Category::all();
        $posts = Post::where('category_id', $category_id)->with(['category', 'tags','user'])->paginate(8);
        return view('blog.index', compact('posts', 'categories'));
    }

    public function byTag($tag_id)
    {
        $categories = Category::all();
        // return Tag::find($tag_id)->posts;
        $posts = Post::with('tags')->whereHas('tags', function ($query) use ($tag_id) {
            $query->where('tag_id', $tag_id);
        })->paginate(8);
        return view('blog.index', compact('posts', 'categories'));
    }

    public function myPages()
    {
        $categories = Category::all();
        $posts = Post::where('user_id', auth()->user()->id)->with(['category', 'tags', 'user'])->paginate(8);   
       
        return view('blog.index', compact('posts', 'categories'));
    }
}
