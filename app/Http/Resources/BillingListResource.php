<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductResource;

class BillingListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // ->select('products.id', 'products.name', 'products.price', 'transaction_details.quantity')->get();
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'sales_type_id' => $this->sales_type_id,
            'customer_name' => $this->name,
            'tax' => $this->tax,
            'discount' => $this->discount,
            'total' => $this->total,
            'products' => ProductResource::collection($this->detail)
        ];
    }
}
