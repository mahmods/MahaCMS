<?php
namespace MahaCMS\MahaCMS\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MahaCMS\MahaCMS\Models\Page;
use MahaCMS\MahaCMS\Models\View;
use MahaCMS\MahaCMS\Models\Field;
use MahaCMS\Blog\Models\Category;

class PagesController extends Controller
{
    public function index() {
        return Page::all();
    }

    public function show($id) {
        return Page::find($id);
    }

    public function create() {
        $views = View::all();
        $categories = Category::all();
        return response()->json([
            'views' => $views,
            'categories' => $categories
        ]);
    }

    public function store(Request $request) {
        $page = new Page;
        $page->slug = $request->slug;
        $page->view_id = $request->view_id;
        $page->save();

        foreach ($request->fields as $field) {
            $f = new Field;
            $f->page_id = $page->id;
            $f->category = $field['category'];
            $f->name = '';
            $f->value = '';
            $f->save();
        }
    }
}
