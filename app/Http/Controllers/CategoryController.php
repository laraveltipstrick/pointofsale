<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use DataTables;
use Form;

class CategoryController extends Controller
{
    public $title = 'Category';
    public $uri = 'category';
    public $folder = 'category';

    public function __construct(Category $table)
    {
        $this->table = $table;
    }

    public function index()
    {
        $data['title'] = $this->title;
        $data['desc'] = 'List';
        $data['ajax'] = route($this->uri.'.data');
        $data['create'] = route($this->uri.'.create');
        return view($this->folder.'.index', $data);
    }

    public function data(Request $request)
    {
        if (!$request->ajax()) { return; }
        $data = $this->table->withCount(['products'])->select([
            'id', 'name', 'created_at'
        ]);
        return DataTables::of($data)
        ->editColumn('created_at', function ($index) {
            return isset($index->created_at) ? $index->created_at->format('d F Y H:i:s') : '-';
        })
        ->addColumn('amount', function ($index) {
            return isset($index->products_count) ? $index->products_count : 0;
        })
        ->addColumn('action', function ($index) {
            $tag = Form::open(array("url" => route($this->uri.'.destroy',$index->id), "method" => "DELETE"));
            $tag .= "<a href=".route($this->uri.'.edit',$index->id)." class='btn btn-primary btn-xs'>edit</a>";
            $tag .= " <button type='submit' class='delete btn btn-danger btn-xs'>delete</button>";
            $tag .= Form::close();
            return $tag;
        })
        ->rawColumns(['id', 'action'])
        ->make(true);
    }


    public function create()
    {
        $data['title'] = $this->title;
        $data['desc'] = 'Create';
        $data['action'] = route($this->uri.'.store');
        $data['url'] = route($this->uri.'.index');
        return view($this->folder.'.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $this->table->create($request->all());
        return redirect(route($this->uri.'.index'))->with('success', trans('message.create'));
    }

    public function edit($id)
    {
        $data['title'] = $this->title;
        $data['desc'] = 'Edit';
        $data['category'] = $this->table->find($id);
        $data['action'] = route($this->uri.'.update', $id);
        $data['url'] = route($this->uri.'.index');
        return view($this->folder.'.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $this->table->find($id)->update($request->all());

        return redirect(route($this->uri.'.index'))->with('success', trans('message.update'));
    }

    public function destroy($id)
    {
        $tb = $this->table->find($id);
        $tb->delete();
        return response()->json(['message' => true,'success' => trans('message.delete')]);
    }
}
