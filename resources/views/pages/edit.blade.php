@extends('app')
@section('javascript')
    <script src="/js/jquery.cleditor.min.js"></script>
    <script>
        $(document).ready(function () { $("#editor").cleditor(); });
    </script>
@endsection
@section('css')
    <link rel="stylesheet" href="/css/jquery.cleditor.css" />
@endsection
@section('content')

    <form class="form-horizontal" method="POST" action="/pages/update">


        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="page_id" value="{{$page_id}}">

        <fieldset>

            <!-- Form Name -->
<div class="instructions">
    Edit Documentation here.
</div>
            <h3 class="form_heading">Edit Documentation</h3>
            <!-- Select Basic -->
            <div class="form-group">
                <label class="col-md-3 control-label" for="category">Category</label>
                <div class="col-md-4">
                    <select id="category" name="category" class="form-control ">
<option value="{{$page['category']}}">{{$page['category']}}</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->asset_id}}">{{$category->asset_id}}</option>
                        @endforeach



                    </select>
                </div>
            </div>



            <!-- Text input-->
            <div class="form-group required-control">
                <label class="col-md-3 control-label" for="url_endpoint"><strong>Title</strong></label>
                <div class="col-md-8">
                    <input id="title" name="title" type="text" placeholder="Title" class="form-control " required="" value="{{$page['title']}}">
                </div>
            </div>



            <!-- Textarea -->
            <div class="form-group required-control">
                <label class="col-md-3 control-label" for="description">Page Content</label>
                <div class="col-md-8">
                    <textarea id="editor" name="page_content" required="" class="form-control input-lg" rows="20">{{$page['description']}}</textarea>
                </div>
            </div>




            <!-- Button -->
            <div class="form-group">
                <label class="col-md-3 control-label" for="submit"></label>
                <div class="col-md-5">

                    <input type="submit" id="submit" name="submit" value=" >>>>>>>>>>>> Update Documentation <<<<<<<<<<<<<< " class="btn btn-success">

                </div>
            </div>

        </fieldset>
    </form>



@endsection