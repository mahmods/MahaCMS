<?php
namespace MahaCMS\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MahaCMS\Blog\Models\Post;
use MahaCMS\Blog\Models\Category;
use Carbon\Carbon;
use Auth;
use File;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    private $user;
    
    public function __construct() {
        $this->user = Auth::guard('api')->user();
    }

    public function index()
    {
        return response()->json(Post::with(['category:id,name', 'user'])->paginate(10));
    }

    public function show($id) {
        $post = Post::with('user', 'category')->find($id);
        return $post;
    }

    public function query(Request $request)
    {
        $category = $request->query('category');
        $category = Category::where('slug', $category)->first();
        if ($category) {
            return response()->json([
                'name' => $category->name,
                'items' => $category->posts
                ]);
        }
        return response()->json(['error' => 'not found']);
    }

    public function create()
    {
        $this->authorizeForUser($this->user, 'create', Post::class);
        return Post::form();
    }
    
    public function store(Request $request)
    {
        $this->authorizeForUser($this->user, 'create', Post::class);
        $request->validate(Post::$rules);
        if(!$request->hasFile('image') && !$request->file('image')->isValid()) {
            return abort(404, 'Image not uploaded');
        }
        $fileName = $this->getFileName($request->image);
        $request->image->move(base_path('public/images'), $fileName);
        $post = new Post($request->all());
        $post->image = $fileName;
        $post->save();

        return response()->json(['success' => true, 'id' => $post->id]);
    }

    public function edit($id)
    {
        $post = Post::find($id);
        $this->authorizeForUser($this->user, 'update', $post);
        return Post::form($post);
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $request->validate(Post::$rules);
        $this->authorizeForUser($this->user, 'update', $post);
        if ($request->hasfile('image') && $request->file('image')->isValid()) {
            $filename = $this->getFileName($request->image);
            //return $filename;
            $request->image->move(base_path('public/images'), $filename);
            // remove old image
            File::delete(base_path('public/images/' . $post->image));
            $post->image = $filename;
            $post->save();
        }
        $post->update($request->except('image'));
        return response()->json(['success' => true, 'id' => $post->id]);
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $this->authorizeForUser($this->user, 'delete', $post);
        $post->delete();
        return response()->json(['success' => true ]);
    }

    protected function getFileName($file) {
        return str_random(32).'.'.$file->extension();
    }
}
