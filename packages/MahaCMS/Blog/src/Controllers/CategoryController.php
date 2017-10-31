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
        if ($user->can('access', Category::class)) {
            return response()->json([
                'items' => Category::select('id', 'name')->get(),
                'columns' => [['id', '#'], ['name', 'Name']]
                ]);
        }
        return response()->json(['authorized' => false]);
    }

    public function show($id)
    {
        $posts = Post::where('category_id', $id)->get();
        return response()->json(['items' => $posts,]);
    }

    public function create()
    {
        $user = Auth::guard('api')->user();
        if ($user->can('create', Category::class)) {
            return response()->json(['form' => [
                ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'value' => ''],
            ]]);
        }
        return response()->json(['authorized' => false]);

    }
    
    
    public function store(Request $request)
    {
        $user = Auth::guard('api')->user();
        if ($user->can('create', Category::class)) {
            $permission = new Category($request->all());
            $permission->save();
    
            return response()->json(['success' => true]);
        }
        return response()->json(['authorized' => false]);
    }

    public function edit($id)
    {
        $category = Category::find($id);
        $user = Auth::guard('api')->user();
        if ($user->can('update', $category)) {
            return response()->json(['form' => [
                ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'value' => $category->name],
            ]]);
        }
        return response()->json(['authorized' => false]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $user = Auth::guard('api')->user();
        if ($user->can('update', $category)) {
            $category->update($request->all());
            return response()->json(['success' => true ]);
        }
        return response()->json(['authorized' => false]);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $user = Auth::guard('api')->user();
        if ($user->can('update', $category)) {
            $category->delete();
            return response()->json(['success' => true ]);
        }
        return response()->json(['authorized' => false]);
    }
}