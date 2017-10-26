<?php
namespace MahaCMS\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MahaCMS\Blog\Models\Post;
use Auth;

class PostController extends Controller
{
    public function index()
    {
        $user = Auth::guard('api')->user();
        if ($user->can('access', Post::class)) {
            return response()->json([
                'items' => Post::select('id', 'title', 'description', 'created_at')->get(),
                'columns' => [['id', '#'], ['title', 'Title'], ['description', 'Description'], ['created_at', 'Date']]
                ]);
        } else {
            return response()->json([
                'authorized' => false
            ]);
        }
    }

    public function create()
    {
        $user = Auth::guard('api')->user();
        if ($user->can('create', Post::class)) {
            return response()->json(['form' => [
                ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'value' => ''],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'value' => ''],
                ['name' => 'content', 'label' => 'Content', 'type' => 'textarea', 'value' => ''],
                ['name' => 'user_id', 'value' => $user->id]
            ]]);
        } else {
            return response()->json([
                'authorized' => false
            ]);
        }

    }
    
    public function store(Request $request)
    {
        $user = Auth::guard('api')->user();
        if ($user->can('create', Post::class)) {
            $permission = new Post($request->all());
            $permission->save();
    
            return response()->json(['success' => true ]);
        } else {
            return response()->json([
                'authorized' => false
            ]);
        }
    }

    public function edit($id)
    {
        $post = Post::find($id);
        $user = Auth::guard('api')->user();
        if ($user->can('update', $post)) {
            return response()->json(['form' => [
                ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'value' => $post->id],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'value' => $post->title],
                ['name' => 'content', 'label' => 'Content', 'type' => 'textarea', 'value' => $post->content],
                ['name' => 'user_id', 'value' => $post->user->id]
            ]]);
        } else {
            return response()->json([
                'authorized' => false
            ]);
        }
    }
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $user = Auth::guard('api')->user();
        if ($user->can('update', $post)) {
            $post->update($request->all());
            return response()->json(['success' => true ]);
        } else {
            return response()->json([
                'authorized' => false
            ]);
        }
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $user = Auth::guard('api')->user();
        if ($user->can('update', $post)) {
            $post->delete();
            return response()->json(['success' => true ]);
        } else {
            return response()->json([
                'authorized' => false
            ]);
        }
        return response()
            ->json([
                'deleted' => true
            ]);
    }
}
