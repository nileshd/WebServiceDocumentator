@extends('app')
@section('content')
<h3>Api <span class="api_endpoint">{{$url_endpoint}}</span> was successfully added to the <span class="api_category">{{$category}} Api Collection</span></h3>


<a href="/api/add" name="add_param" class="btn btn-info">Add Another API</a>

@endsection