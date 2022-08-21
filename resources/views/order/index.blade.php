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

        document.addEventListener('alpine:init', () => {
            Alpine.data('products', () => ({
                search: '',
                items: {!!$products!!},
                input: {
                    tax: 0,
                    discount: 0
                },
                lastTotal: 0,
                tax: 0,
                discount: 0,
                selectedItems: [],
                get listItems() {
                    return this.items.filter(
                        i => i.name.toLowerCase().startsWith(this.search.toLowerCase())
                        //i => i.name.toLowerCase().startsWith((this.search)?this.search.toLowerCase():null)
                    )
                },
                selectItem(item) {
                    var index = this.selectedItems.findIndex(i => i.id === item.id);
                    if(index === -1) {
                        const container = {}
                        container.id = item.id
                        container.name = item.name
                        container.price = item.price
                        container.image = item.image
                        container.qty = 1
                        container.sub_price = (item.price * 1)
                        this.selectedItems.push(container)
                    } else {
                        this.selectedItems[index].qty += 1
                        const sub_price = (this.selectedItems[index].qty * this.selectedItems[index].price) 
                        this.selectedItems[index].sub_price = sub_price
                        //console.log(this.selectedItems[index].qty)
                    }
                    this.tax = this.calculatePercentage(this.input.tax)
                    this.discount = this.calculatePercentage(this.input.discount)
                    //console.log(this.selectedItems)
                },
                updateQty(event, index) {
                    //if(!(event.which < 48 || event.which > 57)) {
                    //if(!isNaN(event.target.value)) {
                      //  console.log(event.target.value)
                    //} else {

                    //}
                    //var index = this.selectedItems.findIndex(i => i.id === item.id);
                    this.selectedItems[index].qty = parseInt(event.target.value)
                    this.selectedItems[index].sub_price = parseInt(event.target.value) * this.selectedItems[index].price
                    //console.log(this.selectedItems)
                    this.tax = this.calculatePercentage(this.input.tax)
                    this.discount = this.calculatePercentage(this.input.discount)
                },
                removeItem(index) {
                    //var index = this.selectedItems.findIndex(i => i.id === item.id);
                    this.selectedItems.splice(index, 1)
                    this.tax = this.calculatePercentage(this.input.tax)
                    this.discount = this.calculatePercentage(this.input.discount)
                },
                lengthItem() {
                    return this.selectedItems.length
                },
                subTotal() {
                    if(this.selectedItems.length > 0) {
                        return this.selectedItems.reduce((a, b) => {
                            return b.sub_price + a
                        }, 0)
                    } else {
                        return 0;
                    }
                },
                total() {
                    if(this.selectedItems.length > 0) {
                        const sub_total = this.selectedItems.reduce((a, b) => {
                            return b.sub_price + a
                        }, 0)
                        //this.lastTotal = (parseInt(sub_total) - parseInt(this.discount)) + parseInt(this.tax)
                        return (parseInt(sub_total) - parseInt(this.discount)) + parseInt(this.tax)
                    } else {
                        return 0;
                    }
                },
                sumItem() {
                    if(this.selectedItems.length > 0) {
                        return this.selectedItems.reduce((a, b) => {
                            return b.sub_price + a
                        }, 0)
                    } else {
                        return 0;
                    }
                },
                addTax() {
                    $('#modal-tax').modal('show')
                },
                addDiscount() {
                    $('#modal-discount').modal('show')
                },
                updateTax() {
                    this.tax = this.calculatePercentage(this.input.tax)
                    /*var inputTax = this.input.tax
                    if(inputTax != 0 && inputTax.slice(-1) == '%') {
                        this.tax = (parseInt(inputTax)/100) * this.sumItem()
                    } else {
                        this.tax = parseInt(inputTax)/100
                    }*/
                    $('#modal-tax').modal('hide')
                },
                updateDiscount() {
                    /*var inputDiscount = this.input.discount
                    if(inputDiscount != 0 && inputDiscount.slice(-1) == '%') {
                        this.discount = parseInt(inputDiscount)/100 * this.sumItem()
                    } else {
                        this.discount = parseInt(inputDiscount)
                    }*/
                    this.discount = this.calculatePercentage(this.input.discount)
                    $('#modal-discount').modal('hide')
                },
                calculatePercentage(value) {
                    var inputPercentage = value
                    if(inputPercentage != 0 && inputPercentage.slice(-1) == '%') {
                        return (parseInt(inputPercentage)/100) * this.sumItem()
                    } else {
                        return parseInt(inputPercentage)
                    }
                },
                getTax() {

                }

            }))
        })
    </script>
@endpush

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
@endpush

@section('content')
    <div class="row" x-data="products">
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
                        <!-- <div class="form-group">
                            <input x-model="search" class="form-control" placeholder="Search product by code or name" autocomplete="off">
                        </div> -->
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
                                <table class="table table-striped table-condensed table-hover selected-product">
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
                                        {{-- <template x-for="item in selectedItems" :key="item.id"> --}}
                                        <template x-for="(item, index) in selectedItems" :key="index">
                                            <tr>
                                                <td x-text="item.name">
                                                    {{-- <button type="button" @click="openModal(item)" class="btn btn-success btn-block btn-xs button-item" x-text="item.name">
                                                    </button> --}}
                                                </td>
                                                <td class="text-right" x-text="item.price"></td>
                                                <td>
                                                    <input type="text" class="form-control no-padding text-center" x-on:keyup="updateQty($event, index)" :value="item.qty" onClick="this.select();">
                                                </td>
                                                <td class="text-right" x-text="item.sub_price"></td>
                                                <td>
                                                    <a href="javascript:void(0)" x-on:click="removeItem(index)">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group clearfix">
                                <table class="table table-condensed">
                                    <tr>
                                        <td width="45%">Total Item</td>
                                        <td class="text-right" x-text="lengthItem"></td>
                                        <td width="25%">Sub Total</td>
                                        <td class="text-right" x-text="subTotal"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td><a href="javascript:void(0)" @click="addDiscount">Discount</a></td>
                                        <td class="text-right" x-text="discount"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td><a href="javascript:void(0)" @click="addTax">Tax</a></td>
                                        <td class="text-right" x-text="tax"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td>Total</td>
                                        <td class="text-right" x-text="total"></td>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <input x-model="search" class="form-control" placeholder="Search product by code or name" autocomplete="off">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="list-product">
                        <div class="product">
                            <template x-for="item in listItems" :key="item.id">
                                <button class="btn btn-flat" @click="selectItem(item)">
                                    <span class="product-image">
                                        <img :src="item.image ? 'uploads/'+item.image : '/assets/img/no-image.png'" alt="">
                                    </span>
                                    <span class="product-title" x-text="item.name"></span>
                                </button>
                            </template>
                            {{--@foreach($products as $product)
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
                            @endforeach--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-tax">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form @submit.prevent="updateTax">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Tax</h4>
                        </div>
                        <div class="modal-body">
                            <input type="text" class="form-control input-sm" x-model="input.tax" onClick="this.select();"/>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left btn-sm" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-discount">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form @submit.prevent="updateDiscount">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Discount</h4>
                        </div>
                        <div class="modal-body">
                            <input type="text" class="form-control input-sm" x-model="input.discount" onClick="this.select();"/>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left btn-sm" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
