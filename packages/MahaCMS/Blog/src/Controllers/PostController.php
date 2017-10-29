<?php
namespace MahaCMS\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MahaCMS\Blog\Models\Post;
use MahaCMS\Blog\Models\Category;
use Carbon\Carbon;
use Auth;

class PostController extends Controller
{
    public function index()
    {
        return response()->json([
            'items' => Post::with(['category:id,name', 'user'])->get(),
            ]);
    }

    public function create()
    {
        $user = Auth::guard('api')->user();
        if ($user->can('create', Post::class)) {
            return response()->json(['form' => [
                ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'value' => ''],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'value' => ''],
                ['name' => 'image', 'label' => 'Image', 'type' => 'image', 'value' => ''],
                ['name' => 'category_id', 'label' => 'Category', 'type' => 'select', 'value' => '', 'options' => Category::select('id', 'name')->get()],
                ['name' => 'content', 'label' => 'Content', 'type' => 'textarea', 'value' => '', 'editor' => true],
                ['name' => 'user_id', 'value' => $user->id]
            ]]);
        }
        return response()->json(['authorized' => false]);

    }
    
    public function store(Request $request)
    {
        $user = Auth::guard('api')->user();
        if ($user->can('create', Post::class)) {
            if(!$request->hasFile('image') && !$request->file('image')->isValid()) {
                return abort(404, 'Image not uploaded');
            }
            $imageData = $request->get('image');
            $fileName = $this->getFileName($request->image);
            $request->image->move(base_path('public/img'), $fileName);
            $post = new Post($request->all());
            $post->image = $fileName;
            $post->save();
    
            return response()->json(['success' => true]);
        }
        return response()->json(['authorized' => false]);
    }

    protected function getFileName($file) {
        return str_random(32).'.'.$file->extension();
    }

    public function edit($id)
    {
        $post = Post::find($id);
        $user = Auth::guard('api')->user();
        if ($user->can('update', $post)) {
            return response()->json(['form' => [
                ['name' => 'title', 'label' => 'Title', 'type' => 'text', 'value' => $post->title],
                ['name' => 'description', 'label' => 'Description', 'type' => 'textarea', 'value' => $post->description],
                ['name' => 'content', 'label' => 'Content', 'type' => 'textarea', 'value' => $post->content, 'editor' => true],
                ['name' => 'category_id', 'label' => 'Category', 'type' => 'select', 'value' => $post->category->id, 'options' => Category::select('id', 'name')->get()],
                ['name' => 'user_id', 'value' => $post->user->id]
                ]]);
        }
        return response()->json(['authorized' => false]);
    }
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $user = Auth::guard('api')->user();
        if ($user->can('update', $post)) {
            $post->update($request->all());
            return response()->json(['success' => true ]);
        }
        return response()->json(['authorized' => false]);
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $user = Auth::guard('api')->user();
        if ($user->can('update', $post)) {
            $post->delete();
            return response()->json(['success' => true ]);
        }
        return response()->json(['authorized' => false]);
    }
}
