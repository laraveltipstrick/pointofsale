@extends('layouts.app')

@section('content-header')
@endsection

@push('scripts')
    <script src="{{ asset('AdminLTE-2.4.15/dist/js/moment.js') }}"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('.list-selected').slimScroll({
            height: '250px'
        });
        $('.list-product').slimScroll({
            height: '500px'
        })

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        document.addEventListener('alpine:init', () => {
            Alpine.data('products', () => ({
                search: '',
                items: {!!$products!!},
                billingList: {},
                input: {
                    transaction_id: 0,
                    sales_type: 0,
                    customer_name: '',
                    tax: 0,
                    discount: 0,
                    total: 0,
                },
                lastTotal: 0,
                tax: 0,
                discount: 0,
                selectedItems: [],
                category: 0,
                //get listItems() {
                listItems() {
                    if(this.category > 0) {
                        return this.items.filter(
                            i => i.name.toLowerCase().startsWith(this.search.toLowerCase()) 
                            && i.category_id == this.category
                        )
                    } else {
                        return this.items.filter(
                            i => i.name.toLowerCase().startsWith(this.search.toLowerCase()) 
                        )
                    }
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
                    //this.tax = this.calculateTax(this.input.tax)
                    //this.discount = this.calculateDiscount(this.input.discount)

                    //console.log('calculate discount: '+this.calculateDiscount(this.input.discount))
                    //console.log('discount: '+this.discount)
                    //console.log('tax: '+this.tax)
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
                    //this.tax = this.calculateTax(this.input.tax)
                    //this.discount = this.calculateDiscount(this.input.discount)
                },
                removeItem(index) {
                    //var index = this.selectedItems.findIndex(i => i.id === item.id);
                    this.selectedItems.splice(index, 1)
                    //this.tax = this.calculateTax(this.input.tax)
                    //this.discount = this.calculateDiscount(this.input.discount)
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
                        //return (parseInt(sub_total) - parseInt(this.discount)) + parseInt(this.tax)
                        return this.input.total = (parseFloat(sub_total) - parseFloat(this.getDiscount())) + parseFloat(this.getTax())
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
                    if (this.selectedItems.length > 0) {
                        $('#modal-tax').modal('show')
                    } else {
                        return Toast.fire({
                            icon: 'warning',
                            title: 'You have to select product first'
                        })
                    }
                },
                addDiscount() {
                    if (this.selectedItems.length > 0) {
                        $('#modal-discount').modal('show')
                    } else {
                        return Toast.fire({
                            icon: 'warning',
                            title: 'You have to select product first'
                        })
                    }
                },
                //showBillingList() {
                //    $('#modal-billing-list').modal('show')
                //},
                saveBill() {
                    if (this.selectedItems.length == 0) {
                        return Toast.fire({
                            icon: 'warning',
                            title: 'You have to select product first'
                        })
                    }
                    if (this.input.sales_type == 0) {
                        return Toast.fire({
                            icon: 'warning',
                            title: 'Please select sales type'
                        })
                    }
                    $('#modal-save-bill').modal('show')
                },
                updateTax() {
                    //this.tax = this.calculateTax(this.input.tax)
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
                    //this.discount = this.calculateDiscount(this.input.discount)
                    $('#modal-discount').modal('hide')
                },
                calculateDiscount(value) {
                    var inputPercentage = value
                    if(inputPercentage != 0 && inputPercentage.slice(-1) == '%') {
                        return (parseInt(inputPercentage)/100) * this.sumItem()
                    } else {
                        return parseInt(inputPercentage)
                    }
                },
                calculateTax(value) {
                    var inputPercentage = value
                    if(inputPercentage != 0 && inputPercentage.slice(-1) == '%') {
                        //return (parseInt(inputPercentage)/100) * this.sumItem()
                        return (parseInt(inputPercentage)/100) * (this.sumItem() - this.calculateDiscount(this.input.discount))
                    } else {
                        return parseInt(inputPercentage)
                    }
                },
                getTax() {
                    const inputPercentage = this.input.tax
                    if(inputPercentage != 0 && inputPercentage.slice(-1) == '%') {
                        //return (parseInt(inputPercentage)/100) * this.sumItem()
                        return ((parseInt(inputPercentage)/100) * (this.sumItem() - this.getDiscount())).toFixed(2)
                    } else {
                        return parseInt(inputPercentage)
                    }
                },
                getDiscount() {
                    const inputPercentage = this.input.discount
                    if(inputPercentage != 0 && inputPercentage.slice(-1) == '%') {
                        return ((parseInt(inputPercentage)/100) * this.sumItem()).toFixed(2)
                    } else {
                        return parseInt(inputPercentage)
                    }
                },
                limitCharacter(name) {
                    if(name.length > 10) {
                        return name.substring(0, 10) + ' ...'
                    } else {
                        return name
                    }
                },
                /*listItemBasedOnCategory() {
                    if(this.category > 0) {
                        return this.listItems();
                    }
                },*/
                selectCategory(categoryId) {
                    this.category = categoryId
                },
                async retrieveBillingList() {
                    $('#modal-billing-list').modal('show')
                    this.billingList = await(await fetch("{{route('order.billing.list')}}")).json();
                    // console.log(this.billingList);
                },
                async selectBillingList(transactionId) {
                    this.selectedItems = []
                    let billing = await(await fetch("{{url('billing_select')}}/"+transactionId)).json();
                    billing.products.forEach((element, index, array) => {
                        //console.log(element.name)
                        const container = {}
                        container.id = element.id
                        container.name = element.name
                        container.price = element.price
                        container.image = null
                        container.qty = element.quantity
                        container.sub_price = (element.price * element.quantity)
                        this.selectedItems.push(container)
                    })

                    this.input.sales_type = billing.sales_type_id
                    this.input.customer_name = billing.customer_name
                    this.input.tax = billing.tax
                    this.input.discount = billing.discount
                    this.input.transaction_id = billing.id
                    
                    $('#modal-billing-list').modal('hide')
                },
                newData: {},
                async storeBill() {
                    this.newData = await (await fetch('{{$url_store}}', {
                        method: 'POST',
                        body: JSON.stringify({
                            item: this.selectedItems,
                            additional: this.input,
                        }),
                        headers: {
                            'Content-type': 'application/json; charset=UTF-8',
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                        },
                    })).json();
                    if (this.newData) {
                        this.selectedItems = []
                        this.input.sales_type = 0
                        this.input.customer_name = ''
                        this.input.tax = 0
                        this.input.discount = 0
                        this.input.total = 0
                        this.input.transaction_id = 0
                        $('#modal-save-bill').modal('hide')
                    }
                    console.log(this.newData)
                }

            }))
        })
        $('.modal').on('shown.bs.modal', function() {
                $(this).find('[autofocus]').focus();
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
                            <div class="btn-group btn-block btn-bill">
                                <button type="button" @click="retrieveBillingList" class="btn btn-primary btn-flat">
                                    <i class="fa fa-fw fa-list"></i>
                                    Billing List
                                </button>
                                <button type="button" class="btn btn-primary btn-flat">
                                    <i class="fa fa-fw fa-plus"></i>
                                    Add Customer
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <select class="form-control" x-model="input.sales_type" name="sales_type">
                                <option value="0">- Please Select Sale Type -</option>
                                @foreach($sales_type as $key => $value)
                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
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
                                                <td class="text-center" x-text="item.price"></td>
                                                <td>
                                                    <input type="text" class="form-control no-padding text-center" x-on:keyup="updateQty($event, index)" :value="item.qty" onClick="this.select();">
                                                </td>
                                                <td class="text-center" x-text="item.sub_price"></td>
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
                                        <td class="text-right" x-text="getDiscount"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td><a href="javascript:void(0)" @click="addTax">Tax</a></td>
                                        <td class="text-right" x-text="getTax"></td>
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
                                            <button type="button" @click="cancel" class="btn btn-danger btn-flat">Cancel</button>
                                            <button type="button" @click="saveBill" class="btn btn-primary btn-flat">Save Bill</button>
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
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm" @click="selectCategory(0)">All Category</button>
                    @foreach($category as $key => $value)
                        <button type="button" class="btn btn-primary btn-sm" @click="selectCategory({{$value->id}})">{{$value->name}}</button>
                    @endforeach
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="list-product">
                        <div class="product">
                            <template x-for="item in listItems" :key="item.id">
                                <button class="btn btn-flat" @click="selectItem(item)" :title="item.name">
                                    <span class="product-image">
                                        <img :src="item.image ? 'uploads/'+item.image : '/assets/img/no-image.png'" alt="">
                                    </span>
                                    <span class="product-title" x-text="limitCharacter(item.name)"></span>
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
                            {{-- <button type="button" class="btn btn-default pull-left btn-sm btn-block" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm">Save</button> --}}
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
                            {{-- <button type="button" class="btn btn-default pull-left btn-sm btn-block" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm">Save</button> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-save-bill">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <form @submit.prevent="saveBill">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Save Bill</h4>
                        </div>
                        <div class="modal-body">
                            <input type="text" class="form-control input-sm" placeholder="Name" x-model="input.customer_name" onClick="this.select();" autofocus/>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left btn-sm" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary btn-sm" @click="storeBill">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-billing-list">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Billing List</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Billing Name</th>
                                    <th>Total</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(item, index) in billingList" :key="index">
                                    <tr>
                                        <td x-text="item.name"></td>
                                        <td x-text="item.total"></td>
                                        <td x-text="moment(item.created_at).fromNow()"></td>
                                        <td><button type="button" @click="selectBillingList(item.id)" class="btn btn-block btn-primary btn-xs">Select</button></td>
                                    </tr>
                                </template>
                            </tbody>
                            {{-- <tr>
                                <td>1.</td>
                                <td>Update software</td>
                                <td>
                                    <div class="progress progress-xs">
                                        <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                                    </div>
                                </td>
                                <td><span class="badge bg-red">55%</span></td>
                            </tr> --}}
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
