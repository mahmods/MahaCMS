<?php
namespace MahaCMS\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MahaCMS\Blog\Models\Category;
use MahaCMS\Blog\Models\Post;
use Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $user = Auth::guard('api')->user();
        $this->authorizeForUser($user, 'access', Category::class);
        return response()->json([
            'items' => Category::select('id', 'name')->get(),
            'columns' => [['id', '#'], ['name', 'Name']]
            ]);
    }

    public function show($id)
    {
        $posts = Post::where('category_id', $id)->get();
        return response()->json(['items' => $posts]);
    }

    public function create(Request $request)
    {
        $user = Auth::guard('api')->user();
        $this->authorizeForUser($user, 'create', Category::class);
        return Category::form();
    }
    
    
    public function store(Request $request)
    {
        $user = Auth::guard('api')->user();
        $this->authorizeForUser($user, 'create', Category::class);
        $request->validate(Category::$rules);
        $permission = new Category($request->all());
        $permission->save();
        
        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        $user = Auth::guard('api')->user();
        $category = Category::find($id);
        $this->authorizeForUser($user, 'update', $category);
        return Category::form($category);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::guard('api')->user();
        $category = Category::find($id);
        $request->validate(Category::$rules);
        $this->authorizeForUser($user, 'update', $category);
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'.$category->id
        ]);
        $category->update($request->all());
        return response()->json(['success' => true ]);
    }

    public function destroy($id)
    {
        $user = Auth::guard('api')->user();
        $category = Category::find($id);
        $this->authorizeForUser($user, 'delete', $category);
        $category->delete();
        return response()->json(['success' => true ]);
    }
}