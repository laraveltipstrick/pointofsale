@extends('layouts.app')

@push('select2')
    <link rel="stylesheet" href="{{asset('AdminLTE-2.4.15/bower_components/select2/dist/css/select2.min.css')}}">
@endpush

@push('scripts')
    <script src="{{asset('AdminLTE-2.4.15/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
    <script>
        $(function () {
            $('.select2').select2();
        })
    </script>
@endpush

@section('content')

@if (session()->has('success'))
<div class="callout callout-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <p>{!!session('success')!!}</p>
</div>
@endif

<div class="box">
	<div class="box-header with-border">
        <a href="{{$url}}" class="btn btn-warning"><i class="fa fa-fw fa-arrow-left"></i> Back</a>
	</div>
    <form action="{{$action}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PUT">
    @csrf
        <div class="box-body">
            <div class="form-group">
                <label class="col-sm-2 control-label">Name</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="name" value="{{$product->name}}" autocomplete="off">
                    @error('name')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Category</label>
                <div class="col-sm-8">
                    <select name="category_id" class="form-control select2">
                        <option value="">- Select Category -</option>
                        @foreach($category as $row)
                            <option value="{{$row->id}}" {{$product->category_id == $row->id ? 'selected' : ''}}>{{$row->name}}</option>
                        @endforeach
                    </select>
                    @error('name')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Image</label>
                <div class="col-sm-8">
                    <input type="file" class="form-control" name="image_file" autocomplete="off">
                    @error('image_file')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Barcode</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="barcode" value="{{$product->barcode}}" autocomplete="off">
                    @error('barcode')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Cost</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="cost" value="{{$product->cost}}" autocomplete="off">
                    @error('cost')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Price</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="price" value="{{$product->price}}" autocomplete="off">
                    @error('price')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Quantity</label>
                <div class="col-sm-8">
                    <input type="number" class="form-control" name="quantity" value="{{$product->quantity}}" autocomplete="off">
                    @error('quantity')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Description</label>
                <div class="col-sm-8">
                    <textarea class="form-control" name="description" autocomplete="off">{{$product->description}}</textarea>
                    @error('description')
                        <p class="text-red">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="col-sm-8 col-sm-offset-2">
            <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>
@endsection