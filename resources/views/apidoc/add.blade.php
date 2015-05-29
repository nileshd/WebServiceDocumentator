@extends('app')
@section('javascript')
    <script>
        $("#addParameters, .check ").click(function() {
            $('#mytable tbody>tr:last')
                    .clone(true)
                    .insertAfter('#mytable tbody>tr:last').find('input').each(function(){
                        $(this).val('');
                    });
        });



        $("#addExceptions, .check ").click(function() {
            $('#mytableExceptions tbody>tr:last')
                    .clone(true)
                    .insertAfter('#mytableExceptions tbody>tr:last').find('input').each(function(){
                        $(this).val('');
                    });
        });


    </script>
@endsection
@section('css')
@endsection
@section('content')

    <form class="form-horizontal" method="POST" action="/api/insert">


        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">


        <fieldset>

            <!-- Form Name -->
            <legend class="api_title">API Details</legend>

            <!-- Select Basic -->
            <div class="form-group">
                <label class="col-md-3 control-label" for="category">Category</label>
                <div class="col-md-4">
                    <select id="category" name="category" class="form-control ">

                        @foreach ($categories as $category)
                            <option>{{$category->asset_id}}</option>
                        @endforeach



                    </select>
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-3 control-label" for="name">Name</label>
                <div class="col-md-5">
                    <input id="name" name="name" type="text" placeholder="Verbose Name of your API. e.g Get All Users" class="form-control ">

                </div>
            </div>

            <!-- Textarea -->
            <div class="form-group required-control">
                <label class="col-md-3 control-label" for="description">Description</label>
                <div class="col-md-8">
                    <textarea id="description" name="description" required="" class="form-control input-lg"></textarea>
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group required-control">
                <label class="col-md-3 control-label" for="url_endpoint">API Endpoint</label>
                <div class="col-md-8">
                    <input id="url_endpoint" name="url_endpoint" type="text" placeholder="URL Endpoint" class="form-control " required="">
                    <p class="help-block">e.g /dog/bark</p>
                </div>
            </div>


            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-3 control-label" for="example_url">Example URL Construct</label>
                <div class="col-md-6">
                    <input id="example_url" name="example_url" type="text" placeholder="example url construct" class="form-control ">

                </div>
            </div>



            <!-- Select Basic -->
            <div class="form-group">
                <label class="col-md-3 control-label" for="http_method">HTTP Method</label>
                <div class="col-md-2">
                    <select id="http_method" name="http_method" class="form-control ">
                        <option>GET</option>
                        <option>POST</option>
                        <option>PUT</option>
                        <option>DELETE</option>
                    </select>
                </div>
            </div>


            <!-- Select Basic -->
            <div class="form-group">
                <label class="col-md-3 control-label" for="http_method">API Output Type</label>
                <div class="col-md-2">
                    <select id="output_type" name="output_type" class="form-control ">
                        <option>JSON</option>
                        <option>XML</option>
                        <option>CSV</option>
                        <option>TXT</option>
                    </select>
                </div>
            </div>



            <!-- Textarea -->
            <div class="form-group">
                <label class="col-md-3 control-label" for="json_success">Success Output Example</label>
                <div class="col-md-8">
                    <textarea id="json_success" name="json_success" class="form-control input-lg"></textarea>
                </div>
            </div>



            <div class="form-group">
                <legend class="api_title">API Parameters</legend>

                <table id="mytable" class="table table-condensed">

                    <tbody class="table-striped">


                    <tr>
                        <td>&nbsp;</td>
                        <td>Required</td>
                        <td>Type</td>
                        <td>&nbsp;</td>

                    </tr>

                    <tr>


                        <td>
                            <input type="text"  placeholder="Parameter Name" name="param_name[]" class="form-control ">
                        </td>

                        <td>

                            <select class="form-control " name="param_required[]" size="2">
                                <option value="1" selected>Yes</option>
                                <option value="0">No</option>
                            </select>


                        </td>
                        <td>

                            <select class="form-control " name="param_type[]">
                                <option>int</option>
                                <option>string</option>
                                <option>email</option>
                                <option>date (yyyy-mm-dd)</option>
                            </select>

                        </td>


                        <td>

                            <input type="text" class="form-control " placeholder="Description" name="param_description[]">
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>


            <a id="addParameters" name="add_param" class="btn btn-info">Add More Parameters</a>




            <div class="form-group">
                <legend class="api_title">Exceptions</legend>

                <table id="mytableExceptions" class="table table-condensed">

                    <tbody class="table-striped">


                    <tr>


                        <td>
                            <input type="text"  placeholder="Exception Number" name="exception_code[]" class="form-control ">
                        </td>


                        <td>
                            <input type="text"  placeholder="Exception Name" name="exception_name[]" class="form-control ">
                        </td>


                        <td>

                            <input type="text" class="form-control " placeholder="Description" name="exception_description[]">
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>


            <a id="addExceptions" name="add_param" class="btn btn-info">Add More Parameters</a>














            <!-- Button -->
            <div class="form-group">
                <label class="col-md-3 control-label" for="submit"></label>
                <div class="col-lg-6">

                    <input type="submit" id="submit" name="submit" value="Add New API" class="btn btn-primary">

                </div>
            </div>

        </fieldset>
    </form>
















@endsection