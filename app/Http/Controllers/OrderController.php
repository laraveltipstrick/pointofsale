<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SalesType;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BillingListResource;

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
        $data['url_store'] = route('order.store');
        // $data['products'] = Product::latest()->get();
        return view($this->folder.'.index', $data);
    }

    public function billing_list()
    {
        $data = Transaction::latest()
                ->where('status', 0)
                ->select('id', 'name', 'total', 'created_at')
                ->get();
        return response()->json($data);
    }

    public function billing_select($transaction_id)
    {
        // $data = TransactionDetail::leftJoin('products', 'products.id', '=', 'transaction_details.product_id')
        // ->where('transaction_details.transaction_id', $transaction_id)
        // ->select('products.id', 'products.name', 'products.price', 'transaction_details.quantity')->get();
        $data = Transaction::with('detail', 'detail.product')->find($transaction_id);
        return new BillingListResource($data);
        // return response()->json($data);
    }

    public function store(Request $request)
    {
        $transaction = new Transaction;
        $transaction->sales_type_id = $request->additional['sales_type'];
        $transaction->user_id = Auth::id();
        $transaction->name = $request->additional['customer_name'];
        $transaction->total = $request->additional['total'];
        $transaction->discount = $request->additional['discount'];
        $transaction->tax = $request->additional['tax'];
        $transaction->save();
        
        foreach ($request->item as $key => $value) {
            $detail = new TransactionDetail;
            $detail->transaction_id = $transaction->id;
            $detail->product_id = $value['id'];
            $detail->quantity = $value['qty'];
            $detail->save();
        }

        return response()->json($transaction->save());
    }
}
