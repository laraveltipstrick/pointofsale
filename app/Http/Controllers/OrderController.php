<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

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
        $data['products'] = Product::latest()->get();
        return view($this->folder.'.index', $data);
    }
}
