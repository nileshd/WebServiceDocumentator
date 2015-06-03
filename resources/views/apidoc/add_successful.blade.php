@extends('app')
@section('content')
<h3>Api <span class="api_endpoint">{{$url_endpoint}}</span> [{{$api_method}}] was successfully {{$action_verb}} to the <span class="api_category">{{$category}} Api Collection</span></h3>


<a href="/api/add" name="add_param" class="btn btn-info">Add Another API</a>
<a href="/api/{{$api_id}}" name="add_param" class="btn btn-warning">View API Page</a>
<a href="/api/category/{{$category}}" name="add_param" class="btn btn-primary">View All Apis in same Category</a>

@endsection