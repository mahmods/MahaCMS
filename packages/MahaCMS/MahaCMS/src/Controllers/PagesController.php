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
        $page->view = $request->view;
        $page->save();

        foreach ($request->fields as $field) {
            $f = new Field;
            $f->page_id = $page->id;
            if(isset($field['category'])) {
                $f->category = $field['category'];
                $f->name = '';
                $f->value = '';
            } else {
                $f->category = '';
                $f->name = $field['name'];
                $f->value = $field['value'];
            }
            $f->save();
        }
    }

    public function edit($id) {
        $page = Page::find($id);
        $views = View::all();
        $categories = Category::all();
        return response()->json([
            'views' => $views,
            'categories' => $categories,
            'form' => $page,
            'fields' => $page->fields
        ]);
    }

    public function update(Request $request, $id) {
        $page = Page::find($id);
        $page->slug = $request->slug;
        $page->view = $request->view;
        $page->save();

        Field::where('page_id', $page->id)->delete();
        
        foreach ($request->fields as $field) {
            $f = new Field;
            $f->page_id = $page->id;
            if(isset($field['category'])) {
                $f->category = $field['category'];
                $f->name = '';
                $f->value = '';
            } else {
                $f->category = '';
                $f->name = $field['name'];
                $f->value = $field['value'];
            }
            $f->save();
        }
    }

    public function destroy($id) {
        $page = Page::find($id);
        Field::where('page_id', $page->id)->delete();
        $page->delete();
        if(Field::where('page_id', $page->id)->delete() && $page->delete()) {
            return response()->json(['success' => true]);
        }
    }
}
