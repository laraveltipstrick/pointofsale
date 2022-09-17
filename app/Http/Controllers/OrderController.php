<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SalesType;
use App\Models\Category;

class OrderController extends Controller
{
    public $title = 'Order';
    public $uri = 'order';
    public $folder = 'order';

    // public function __construct(Product $table)
    // {
    //     $this->table = $table;
    // }

    public function index()
    {
        $data['title'] = $this->title;
        $data['desc'] = 'List';
        $data['products'] = collect(Product::latest()->get())->toJson();
        $data['sales_type'] = SalesType::orderBy('id')->get();
        $data['category'] = Category::orderBy('id')->get();
        // $data['products'] = Product::latest()->get();
        return view($this->folder.'.index', $data);
    }
}
