@extends('layouts.app')

@section('content-header')
@endsection

@push('scripts')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        $('.list-selected').slimScroll({
            height: '250px'
        });
        $('.list-product').slimScroll({
            height: '500px'
        })
    </script>
@endpush
@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-5">
            <div class="info-box">
                <form action="" method="POST">
                @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <select class="form-control" name="sale_type">
                                <option value="1">Dine In</option>
                                <option value="2">Take Away</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search product by code or name" autocomplete="off">
                        </div>
                        <div class="wrap-product">
                            <div class="form-group list-selected">
                                <div class="fixed-table-head">
                                    <table class="table table-striped table-condensed text-center">
                                        <thead>
                                            <tr class="info text-center">
                                                <th>Item</th>
                                                <th style="width: 15%;">Price</th>
                                                <th style="width: 15%;">Qty</th>
                                                <th style="width: 20%;">Sub</th>
                                                <th style="width: 20px;"></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <table class="table table-striped table-condensed table-hover selected-product" height="100">
                                    <thead>
                                        <tr class="info">
                                            <th>Item</th>
                                            <th style="width: 15%;">Price</th>
                                            <th style="width: 15%;">Qty</th>
                                            <th style="width: 20%;">Sub</th>
                                            <th style="width: 20px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
<!--                                     
                                    <tbody>
                                        <tr>
                                            <td>Ayam Bakar</td>
                                            <td class="text-right">10.5</td>
                                            <td>
                                                <input type="text" class="form-control no-padding text-center" value="2" onClick="this.select();">
                                            </td>
                                            <td class="text-right">20.00</td>
                                            <td>
                                                <i class="fa fa-trash-o"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ayam Bakar</td>
                                            <td class="text-right">10.5</td>
                                            <td>
                                                <input type="text" class="form-control no-padding text-center" value="2" onClick="this.select();">
                                            </td>
                                            <td class="text-right">20.00</td>
                                            <td>
                                                <i class="fa fa-trash-o"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ayam Bakar</td>
                                            <td class="text-right">10.5</td>
                                            <td>
                                                <input type="text" class="form-control no-padding text-center" value="2" onClick="this.select();">
                                            </td>
                                            <td class="text-right">20.00</td>
                                            <td>
                                                <i class="fa fa-trash-o"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ayam Bakar</td>
                                            <td class="text-right">10.5</td>
                                            <td>
                                                <input type="text" class="form-control no-padding text-center" value="2" onClick="this.select();">
                                            </td>
                                            <td class="text-right">20.00</td>
                                            <td>
                                                <i class="fa fa-trash-o"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ayam Bakar</td>
                                            <td class="text-right">10.5</td>
                                            <td>
                                                <input type="text" class="form-control no-padding text-center" value="2" onClick="this.select();">
                                            </td>
                                            <td class="text-right">20.00</td>
                                            <td>
                                                <i class="fa fa-trash-o"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ayam Bakar</td>
                                            <td class="text-right">10.5</td>
                                            <td>
                                                <input type="text" class="form-control no-padding text-center" value="2" onClick="this.select();">
                                            </td>
                                            <td class="text-right">20.00</td>
                                            <td>
                                                <i class="fa fa-trash-o"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ayam Bakar</td>
                                            <td class="text-right">10.5</td>
                                            <td>
                                                <input type="text" class="form-control no-padding text-center" value="2" onClick="this.select();">
                                            </td>
                                            <td class="text-right">20.00</td>
                                            <td>
                                                <i class="fa fa-trash-o"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ayam Bakar</td>
                                            <td class="text-right">10.5</td>
                                            <td>
                                                <input type="text" class="form-control no-padding text-center" value="2" onClick="this.select();">
                                            </td>
                                            <td class="text-right">20.00</td>
                                            <td>
                                                <i class="fa fa-trash-o"></i>
                                            </td>
                                        </tr>
                                    </tbody> -->

                                </table>
                            </div>
                            <div class="form-group clearfix">
                                <table class="table table-condensed">
                                    <tr>
                                        <td width="45%">Total Item</td>
                                        <td class="text-right">10</td>
                                        <td width="25%">Sub Total</td>
                                        <td class="text-right">235.00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td>Tax</td>
                                        <td class="text-right">20.5</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td>Discount</td>
                                        <td class="text-right">50.5</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td>Total</td>
                                        <td class="text-right">550.5</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="btn-group btn-block btn-bill">
                                            <button type="button" class="btn btn-primary btn-flat">Save Bill</button>
                                            <button type="button" class="btn btn-warning btn-flat">Print Bill</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <button type="button" class="btn btn-success btn-block btn-flat">Payment</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-7">
            <div class="list-product">
                <div class="product">
                    @foreach($products as $product)
                    <button class="btn btn-flat">
                        <span class="product-image">
                            @if($product->image) 
                                <img src="{{asset('uploads/'.$product->image)}}" alt="">
                            @else
                                <img src="{{asset('assets/img/no-image.png')}}" alt="">
                            @endif
                        </span>
                        <span class="product-title">{{$product->name}}</span>
                    </button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
