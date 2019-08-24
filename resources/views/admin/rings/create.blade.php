@extends('layouts.app')

@section('content')
<h3 class="page-title">@lang('global.rings.title')</h3>

<div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_create')
        </div>
        
<div class="panel-body">
<div class="row">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('admin.rings.store') }}">
          <div class="form-group">
              @csrf
              <label for="name">Name:</label>
              <input type="text" class="form-control" name="name" required/>
          </div>
          <div class="form-group">
              <label for="price">image :</label>
              <input type="text" class="form-control" name="image" required/>
          </div>
          <div class="form-group">
              <label for="price">link :</label>
              <input type="text" class="form-control" name="link" required/>
          </div>

          <div class="form-group">
              <label for="quantity">Category :</label>
              <select onchange="changeselectcat();" id="selectcat" name="categories_id">
		       @foreach($categories as $categorie)
		       <option value="{{$categorie->name}}">{{$categorie->name}}</option>
		       @endforeach
		      </select>
          </div>
          <button type="submit" class="btn btn-primary">Add</button>
      </form>
  </div>
</div>

</div>
@endsection
