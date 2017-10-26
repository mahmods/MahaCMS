<?php
namespace MahaCMS\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MahaCMS\Blog\Models\Post;

class PostController extends Controller
{
    public function __construct()
    {
    	//$this->middleware('auth:api')->except('index');
    }
    public function index()
    {
        $posts = Post::all();

        return response()->json([
            'posts' => $posts
        ]);
    }

    public function create()
    {
        return response()->json([
            'form' => [
                'title' => '',
                'description' => '',
                'content' => '',
            ]
        ]);
    }
    
    public function store(Request $request)
    {
        $post = new Post($request->all());
        $post->save();

        return response()->json([
            'created' => true
        ]);
    }

    public function edit($id)
    {
        $post = Post::find($id);
        return response()->json([
            'form' => [
                'id' => $post->id,
                'title' => $post->title,
                'description' => $post->description,
                'content' => $post->content,
                'user_id' => $post->user->id
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $post->title = $request->title;
        $post->description = $request->description;
        $post->content = $request->content;
        $post->save();

        return response()->json([
            'edited' => true
        ]);
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return response()
            ->json([
                'deleted' => true
            ]);
    }
}
