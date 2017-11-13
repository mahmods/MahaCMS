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
        $request->validate([
            'slug' => 'required|unique:pages',
            'view' => 'required',
            "fields" => 'required|array|min:1',
            'fields.*.name' => 'required',
            'fields.*.value' => 'required'
        ]);
        $page = new Page;
        $page->slug = $request->slug;
        $page->view = $request->view;
        $success = $page->save();

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
            $success = $f->save();
        }
        return response()->json(['success' => $success]);
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
        $request->validate([
            'slug' => 'required|unique:pages,slug,'.$page->id,
            'view' => 'required',
            "fields" => 'required|array|min:1',
            'fields.*.name' => 'required',
            'fields.*.value' => 'required'
        ]);
        $page->slug = $request->slug;
        $page->view = $request->view;
        $success = $page->save();

        $success = Field::where('page_id', $page->id)->delete();
        
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
            $success = $f->save();
        }
        return response()->json(['success' => $success]);
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
