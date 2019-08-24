@extends('layouts.app')

@section('content')
<h3 class="page-title">@lang('global.categories.title')</h3>

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
      <form method="post" action="{{ route('admin.categories.store') }}">
          <div class="form-group">
		      @csrf
              <label for="price">Name :</label>
              <input type="text" class="form-control" name="name" required/>
          </div>
		  <div class="form-group">
              <label for="name">Category :</label>
              <select class="form-control" name="category">
		       @foreach($seriescategories as $categorie)
		       <option value="{{$categorie->name}}">{{$categorie->name}}</option>
		       @endforeach
		      </select>
          </div>
          <div class="form-group">
              <label for="price">Directed By :</label>
              <input type="text" class="form-control" name="directed_by" required/>
          </div>
          <div class="form-group">
              <label for="price">Championship :</label>
              <input type="text" class="form-control" name="championship" required/>
          </div>

          <div class="form-group">
              <label for="quantity">In Conjunction With :</label>
              <input type="text" class="form-control" name="in_conjunction_with" required/>
          </div>
		  <div class="form-group">
              <label for="quantity">Image :</label>
              <input type="text" class="form-control" name="image" required/>
          </div>
		  <div class="form-group">
              <label for="quantity">Author :</label>
              <input type="text" class="form-control" name="author" required/>
          </div>
          <button type="submit" class="btn btn-primary">Add</button>
      </form>
  </div>
</div>

</div>
@endsection
