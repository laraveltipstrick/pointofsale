<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $data = $this->table->select([
            'id', 'category_id', 'name', 'barcode', 
            'image', 'cost', 'price', 'quantity'
        ]);
        // ->orderBy('id', 'desc');
        // $data = $this->table->with('variant')->withSum('variant', 'quantity')->get();
        return DataTables::of($data)
        ->addColumn('category', function ($index) {
            return isset($index->category->name) ? $index->category->name : '-';
        })
        ->editColumn('image', function ($index) {
            return ($index->image != null) ? "<img width='32' height='32' src='uploads/$index->image'/>" : '-';
        })
        ->editColumn('cost', function ($index) {
            return $index->cost;
        })
        ->editColumn('price', function ($index) {
            return $index->price;
        })
        ->editColumn('quantity', function ($index) {
            return ($index->has_variant) ? $index->variant->sum('quantity') : $index->quantity;
        })
        ->addColumn('action', function ($index) {
            $tag = Form::open(array("url" => route($this->uri.'.destroy',$index->id), "method" => "DELETE"));
            $tag .= "<div class='btn-group'>";
            $tag .= "<a href=".route($this->uri.'.edit',$index->id)." class='btn btn-primary btn-xs'><i class='fa fa-edit'></i></a>";
            $tag .= "<a href=".route($this->uri.'.show',$index->id)." class='btn btn-success btn-xs'><i class='fa fa-eye'></i></a>";
            $tag .= " <button type='submit' class='delete btn btn-danger btn-xs'><i class='fa fa-trash-o'></i></button>";
            $tag .= "</div>";
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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'cost' => 'nullable|numeric',
            'image_file' => 'nullable|image',
        ]);

        if($request->hasFile('image_file')) {
            $path = $request->file('image_file')->storePublicly('products', 'public_upload');
            $request->merge([
                'image' => (isset($path) && !empty($path)) ? $path : null
            ]);
        }
        $this->table->create($request->all());
        return redirect(route($this->uri.'.index'))->with('success', trans('message.create'));
    }

    public function edit($id)
    {
        $data['title'] = $this->title;
        $data['desc'] = 'Edit';
        $data['product'] = $this->table->find($id);
        $data['action'] = route($this->uri.'.update', $id);
        $data['url'] = route($this->uri.'.index');
        $data['category'] = Category::orderBy('name')->get();
        return view($this->folder.'.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:products,name,'.$id,
            'category_id' => 'required',
            'price' => 'required|numeric',
            'cost' => 'nullable|numeric',
            'image_file' => 'nullable|image',
        ]);

        $product = $this->table->find($id);

        if($request->hasFile('image_file')) {
            if($product->image) {
                Storage::disk('public_upload')->delete($product->image);
            }
            $path = $request->file('image_file')->storePublicly('products', 'public_upload');
            $request->merge([
                'image' => (isset($path) && !empty($path)) ? $path : null
            ]);
        }

        $product->update($request->all());

        return redirect()->back()->with('success', trans('message.update'));
    }

    public function show($id)
    {
        $data['title'] = $this->title;
        $data['desc'] = 'Detail';
        $data['product'] = $this->table->find($id);
        $data['url'] = route($this->uri.'.index');
        return view($this->folder.'.show', $data);
    }

    public function destroy($id)
    {
        $tb = $this->table->find($id);
        $tb->delete();
        Storage::disk('public_upload')->delete($tb->image);
        return redirect(route($this->uri.'.index'))->with('success', trans('message.delete'));
    }

    public function items()
    {
        $products = Product::latest()->get();
        return response()->json($products);
    }
}