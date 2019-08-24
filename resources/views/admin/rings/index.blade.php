@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.rings.title')</h3>
    <p>
        <a href="{{ route('admin.rings.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>
    </p>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
		<select onchange="changeselectcat();" id="selectcat">
		<option value="Select">Select</option>
		@foreach($categories as $categorie)
		<option value="{{$categorie->name}}">{{$categorie->name}}</option>
		@endforeach
		</select>
            <table id="ringstable" class="table table-bordered table-striped {{ count($rings) > 0 ? 'datatable' : '' }} dt-select">
                <thead>
                    <tr>
                        <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        <th>ID</th>
                        <th>@lang('global.rings.fields.name')</th>
                        <th>@lang('global.rings.fields.image')</th>
                        <th>@lang('global.rings.fields.link')</th>
                        <th>@lang('global.rings.fields.category')</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if (count($rings) > 0)
                        @foreach ($rings as $ring)
                            <tr data-entry-id="{{ $ring->id }}">
                                <td></td>
                                <td>{{ $ring->id }}</td>
                                <td>{{ $ring->name }}</td>
                                <td>{{ $ring->image }}</td>
                                <td>{{ $ring->link }}</td>
                                <td>{{ $ring->category->name }}</td>
                                <td>
                                    <a href="{{ route('admin.rings.edit',[$ring->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.rings.destroy', $ring->id])) !!}
                                    {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">@lang('global.app_no_entries_in_table')</td>
                        </tr>
                    @endif
				</tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript') 
    <script>
        window.route_mass_crud_entries_destroy = '{{ route('admin.rings.mass_destroy') }}';



function changeselectcat(){
	regExSearch = $('#selectcat').val();
	var table = $('#ringstable').DataTable();
    table.column(5).search(regExSearch, true, false).draw();
}

$(document).ready(function() {
    regExSearch = $('#selectcat').val();
	var table = $('#ringstable').DataTable();
    table.column(5).search(regExSearch, true, false).draw();
} );
		
    </script>
@endsection