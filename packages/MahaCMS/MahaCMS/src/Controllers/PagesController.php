<?php
namespace MahaCMS\MahaCMS\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MahaCMS\MahaCMS\Models\Page;
use MahaCMS\MahaCMS\Models\Template;
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
        $templates = Template::all();
        $categories = Category::all();
        return response()->json([
            'templates' => $templates,
            'categories' => $categories
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'slug' => 'required|unique:pages',
            'template_id' => 'required',
            "fields" => 'nullable|array|',
            'fields.*.category' => 'required_without:fields.*.name,fields.*.value',
            'fields.*.name' => 'required_without:fields.*.category',
            'fields.*.value' => 'required_without:fields.*.category',
            ]);
        $page = new Page;
        $page->slug = $request->slug;
        $page->template_id = $request->template_id;
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
        $templates = Template::all();
        $categories = Category::all();
        return response()->json([
            'templates' => $templates,
            'categories' => $categories,
            'form' => $page,
            'fields' => $page->fields
        ]);
    }

    public function update(Request $request, $id) {
        $page = Page::find($id);
        $request->validate([
            'slug' => 'required|unique:pages,slug,'.$page->id,
            'template_id' => 'required',
            "fields" => 'required|array|min:1',
        ]);
        $page->slug = $request->slug;
        $page->template_id = $request->template_id;
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
        $deleted = $page->delete();
        if(!$deleted) {
            return response()->json(['error' => 'You can`t delete the home page.' ], 403);
        }
        //Field::where('page_id', $page->id)->delete();
        if(Field::where('page_id', $page->id)->delete() && $deleted) {
            return response()->json(['success' => true]);
        }
    }
}
