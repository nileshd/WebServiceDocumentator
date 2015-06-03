@extends('app')
@section('content')
<h3>Api <span class="api_endpoint">{{$title}}</span>  was successfully {{$action_verb}} to the <span class="api_category">{{$category}} Api Docs</span></h3>


<a href="/pages/add" name="add_param" class="btn btn-info">Add Another Page</a>
<a href="/pages/{{$page_id}}" name="add_param" class="btn btn-warning">View Doc Page</a>
<a href="/pages/category/{{$category}}" name="add_param" class="btn btn-primary">View All pages in same Category</a>

@endsection