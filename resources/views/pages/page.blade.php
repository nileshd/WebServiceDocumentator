@extends('app')
@section('javascript')
@endsection
@section('css')
@endsection
@section('content')

    <h2>{{$page['title']}}</h2>
<div class="page_content">
  <?php echo $page['description']; ?>
</div>

@endsection


