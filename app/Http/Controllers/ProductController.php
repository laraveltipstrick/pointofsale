<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use DataTables;
use Form;

class ProductController extends Controller
{
    public $title = 'Products';
    public $uri = 'products';
    public $folder = 'products';

    public function __construct(Product $table)
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
        $data = $this->table->with('variant')->select([
            'id', 'category_id', 'name', 'barcode', 
            'image', 'cost', 'price', 'quantity', 'has_variant'
        ]);
        // $data = $this->table->with('variant')->withSum('variant', 'quantity')->get();
        return DataTables::of($data)
        ->addColumn('category', function ($index) {
            return isset($index->category->name) ? $index->category->name : '-';
        })
        ->editColumn('image', function ($index) {
            return ($index->image != null) ? "<img width='32' height='32' src='$index->image'/>" : '-';
        })
        ->editColumn('cost', function ($index) {
            return ($index->has_variant) ? "<a href='javascript:void(0)' data-product='$index->name' data-variant='$index->variant' class='btn btn-warning btn-xs view-variant'>View Variant</a>" : $index->cost;
        })
        ->editColumn('price', function ($index) {
            return ($index->has_variant) ? "<a href='javascript:void(0)' data-product='$index->name' data-variant='$index->variant' class='btn btn-warning btn-xs view-variant'>View Variant</a>" : $index->price;
        })
        ->editColumn('quantity', function ($index) {
            return ($index->has_variant) ? $index->variant->sum('quantity') : $index->quantity;
        })
        ->addColumn('action', function ($index) {
            $tag = Form::open(array("url" => route($this->uri.'.destroy',$index->id), "method" => "DELETE"));
            $tag .= "<a href=".route($this->uri.'.edit',$index->id)." class='btn btn-primary btn-xs'>edit</a>";
            $tag .= " <button type='submit' class='delete btn btn-danger btn-xs'>delete</button>";
            $tag .= Form::close();
            return $tag;
        })
        ->rawColumns(['id', 'image', 'cost', 'price', 'quantity', 'action'])
        ->make(true);
    }

    public function create()
    {
        $data['title'] = $this->title;
        $data['desc'] = 'Create';
        $data['action'] = route($this->uri.'.store');
        $data['url'] = route($this->uri.'.index');
        $data['category'] = Category::orderBy('name')->get();
        return view($this->folder.'.create', $data);
    }
}
