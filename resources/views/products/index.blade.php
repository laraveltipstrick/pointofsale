@extends('layouts.app')

@push('styles')
	<link rel="stylesheet" href="{{asset('AdminLTE-2.4.15/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@endpush

@push('scripts')
    <script src="{{asset('AdminLTE-2.4.15/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('AdminLTE-2.4.15/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script>
    $(function() {
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{$ajax}}',
            order: [[2,'asc']],
            columns: [
                { data: 'id', searchable: false, orderable: false},
                { data: 'image', searchable: false, orderable: false},
                { data: 'name', searchable: true, orderable: true},
                { data: 'category', searchable: true, orderable: true},
                { data: 'cost', searchable: true, orderable: true},
                { data: 'price', searchable: true, orderable: true},
                { data: 'quantity', searchable: false, orderable: true},
                { data: 'action', searchable: false, orderable: false}
            ],
            columnDefs: [{
                "targets": 0,
                "data": null,
                "render": function (data, type, full, meta) {
                    return meta.settings._iDisplayStart + meta.row + 1;
                }
            }],
        });
    });
    $(document).on('click', '.delete', function () {
		if (!confirm("Do you want to delete")){
	      return false;
	    }
	});

    $(document).on('click', '.view-variant', function () {
        $('#modal-default').modal('show');
        $('.modal-title').text('Variant of '+$(this).data('product'))
        const variant = $(this).data('variant')
        var table = '';
        for(var i = 0; i < variant.length; i++) {
            table += `<tr>
                <td>${i+1}</td>
                <td>${variant[i].name}</td>
                <td>${variant[i].cost}</td>
                <td>${variant[i].price}</td>
                <td>${variant[i].quantity}</td>
                </tr>`
        }
        $('.variant-body').html(table);
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
        <a href="{{$create}}" class="btn btn-primary"><i class="fa fa-fw fa-plus"></i> Create</a>
	</div>
	<div class="box-body">
	  	<table id="dataTable" class="table table-bordered table-hover">
            <thead>
	            <tr>
					<th>#</th>
					<th>Image</th>
					<th>Name</th>
					<th>Category</th>
					<th>Cost</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Action</th>
	            </tr>
            </thead>
            <tbody>
	        </tbody>
	    </table>
	</div>
</div>

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Cost</th>
                            <th>Price</th>
					        <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody class="variant-body">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
    </div>
</div>
@endsection