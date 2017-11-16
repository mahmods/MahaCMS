<?php
namespace MahaCMS\Blog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MahaCMS\Blog\Models\Category;
use MahaCMS\Blog\Models\Post;
use Auth;

class CategoryController extends Controller
{
    private $user;

    public function __construct() {
        $this->user = Auth::guard('api')->user();
    }

    public function index()
    {
        $this->authorizeForUser($this->user, 'access', Category::class);
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
        $this->authorizeForUser($this->user, 'create', Category::class);
        return Category::form();
    }
    
    
    public function store(Request $request)
    {
        $this->authorizeForUser($this->user, 'create', Category::class);
        $request->validate(Category::$rules);
        $permission = new Category($request->all());
        $permission->save();
        
        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        $category = Category::find($id);
        $this->authorizeForUser($this->user, 'update', $category);
        return Category::form($category);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $request->validate(Category::$rules);
        $this->authorizeForUser($this->user, 'update', $category);
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,'.$category->id
        ]);
        $category->update($request->all());
        return response()->json(['success' => true ]);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $this->authorizeForUser($this->user, 'delete', $category);
        $category->delete();
        return response()->json(['success' => true ]);
    }
}