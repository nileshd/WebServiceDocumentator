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

        $("#addCodeExamples, .check ").click(function() {
            $('#mytableCodeExamples tbody>tr:last')
                    .clone(true)
                    .insertAfter('#mytableCodeExamples tbody>tr:last').find('input').each(function(){
                        $(this).val('');
                    });
        });


        $("#addLinks, .check ").click(function() {
            $('#mytableLinks tbody>tr:last')
                    .clone(true)
                    .insertAfter('#mytableLinks tbody>tr:last').find('input').each(function(){
                        $(this).val('');
                    });
        });





    </script>
@endsection
@section('css')
@endsection
@section('content')

    <form class="form-horizontal" method="POST" action="/api/update">


        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="api_id" value="{{$api_id}}">


        <fieldset>

            <!-- Form Name -->
            <legend class="api_title">API Details</legend>

            <!-- Select Basic -->
            <div class="form-group">
                <label class="col-md-3 control-label" for="category">Category</label>
                <div class="col-md-4">
                    <select id="category" name="category" class="form-control ">

                        <option value="{{$api['category']}}" selected>{{$api['category']}}</option>
                        @foreach ($categories as $category)
                            <option>{{$category->asset_id}}</option>
                        @endforeach



                    </select>
                </div>
            </div>



            <!-- Text input-->
            <div class="form-group required-control">
                <label class="col-md-3 control-label" for="url_endpoint"><strong>API Endpoint</strong></label>
                <div class="col-md-8">
                    <input id="url_endpoint" name="url_endpoint" type="text" placeholder="URL Endpoint" class="form-control " required="" value="{{$api['api_endpoint']}}">
                    <p class="help-block">e.g /dog/bark</p>
                </div>
            </div>


            <!-- Text input-->
            <div class="form-group required-control">
                <label class="col-md-3 control-label" for="url_endpoint">API Alias (e.g Cient SDK)</label>
                <div class="col-md-8">
                    <input id="alias" name="alias" type="text" placeholder="API Alias" class="form-control " value="{{$api['alias']}}">

                </div>
            </div>



            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-3 control-label" for="name">Name</label>
                <div class="col-md-5">
                    <input id="name" name="name" type="text" placeholder="Verbose Name of your API. e.g Get All Users" class="form-control " value="{{$api['name']}}">

                </div>
            </div>

            <!-- Textarea -->
            <div class="form-group required-control">
                <label class="col-md-3 control-label" for="description">Description</label>
                <div class="col-md-8">
                    <textarea id="description" name="description" required="" class="form-control input-lg">{{$api['description']}}</textarea>
                </div>
            </div>




            <!-- Select Basic -->
            <div class="form-group">
                <label class="col-md-3 control-label" for="http_method">HTTP Method</label>
                <div class="col-md-2">
                    <select id="http_method" name="http_method" class="form-control ">

                        <option value="{{$api['method']}}" selected>{{$api['method']}}</option>
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
                        <option value="{{$api['output_format']}}" selected>{{$api['output_format']}}</option>
                        @foreach ($outputTypes as $outputType)
                            <option value="{{$outputType->asset_id}}">{{$outputType->asset_id}}</option>
                        @endforeach
                    </select>
                </div>
            </div>



            <!-- Textarea -->
            <div class="form-group">
                <label class="col-md-3 control-label" for="json_success">Success Output Example</label>
                <div class="col-md-8">
                    <textarea id="json_success" name="json_success" class="form-control input-lg">{{$api['json_example_success']}}</textarea>
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-3 control-label" for="name">Example URL Construct</label>
                <div class="col-md-5">
                    <input id="example_call_construct" name="example_call_construct" type="text" placeholder="a real example with example parameters e.g /car/increase_speed/5" class="form-control " value="{{$api['example_call_construct']}}">

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

                    @if (count($parameters) === 0)

                        <tr>


                            <td>
                                <input type="text"  placeholder="Parameter Name" name="param_name[]" class="form-control ">
                            </td>


                            <td>

                                <select class="form-control " name="param_location[]" size="3">
                                    @foreach ($paramCategories as $paramCategory)
                                        <option value="{{$paramCategory->asset_id}}">{{$paramCategory->asset_id}}</option>
                                    @endforeach
                                </select>


                            </td>



                            <td>

                                <select class="form-control " name="param_required[]" size="2">
                                    <option value="1" selected>Yes</option>
                                    <option value="0">No</option>
                                </select>


                            </td>
                            <td>

                                <select class="form-control " name="param_type[]">
                                    @foreach ($paramTypes as $paramType)
                                        <option value="{{$paramType->asset_id}}">{{$paramType->asset_id}}</option>
                                    @endforeach
                                </select>

                            </td>


                            <td>

                                <input type="text" class="form-control " placeholder="Description" name="param_description[]">
                            </td>
                        </tr>

                    @else


                        @foreach ($parameters as $parameter)


                            <tr>


                                <td>
                                    <input type="text"  placeholder="Parameter Name" name="param_name[]" class="form-control " value="{{$parameter['name']}}">
                                </td>

                                <td>

                                    <select class="form-control " name="param_location[]" size="2">
                                        <option value="{{$parameter['location']}}" selected>{{$parameter['location']}}</option>
                                        @foreach ($paramCategories as $paramCategory)
                                            <option value="{{$paramCategory->asset_id}}">{{$paramCategory->asset_id}}</option>
                                        @endforeach
                                    </select>


                                </td>



                                <td>

                                    <select class="form-control " name="param_required[]" size="2">  <option value="{{$parameter['required']}}" selected>{{$parameter['required']}}</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>


                                </td>
                                <td>

                                    <select class="form-control " name="param_type[]">

                                        <option value="{{$parameter['type']}}" selected>{{$parameter['type']}}</option>
                                        @foreach ($paramTypes as $paramType)
                                            <option value="{{$paramType->asset_id}}">{{$paramType->asset_id}}</option>
                                        @endforeach
                                    </select>

                                </td>


                                <td>

                                    <input type="text" class="form-control " placeholder="Description" name="param_description[]" value="{{$parameter['desc']}}">
                                </td>
                            </tr>

                        @endforeach

                    @endif
                    </tbody>
                </table>
            </div>
            <a id="addParameters" name="add_param" class="btn btn-primary">Add More Parameters</a>
            <br><br>
            <div class="form-group">
                <legend class="api_title">Exceptions</legend>
                <table id="mytableExceptions" class="table table-condensed">
                    <tbody class="table-striped">
                    @if (count($exceptions) === 0)

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
                    @else
                        @foreach ($exceptions as $exception)
                            <tr>
                                <td>
                                    <input type="text"  placeholder="Exception Number" name="exception_code[]" class="form-control " value="{{$exception['code']}}">
                                </td>
                                <td>
                                    <input type="text"  placeholder="Exception Name" name="exception_name[]" class="form-control "  value="{{$exception['name']}}">
                                </td>

                                <td>
                                    <input type="text" class="form-control " placeholder="Description" name="exception_description[]"  value="{{$exception['desc']}}">
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>

            <a id="addExceptions" name="add_param" class="btn btn-primary">Add More Exceptions</a>

            <br><br>

            <div class="form-group">
                <legend class="api_title">Code Examples</legend>
                <table id="mytableCodeExamples" class="table table-condensed">
                    <tbody class="table-striped">
                    @if (count($code_examples) === 0)
                        <tr>
                            <td>
                                <div class="col-md-4">
                                    <select id="output_type" name="code_example_language[]" class="form-control ">
                                        @foreach ($languages as $language)
                                            <option value="{{$language->asset_id}}">{{$language->asset_id}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </td>
                            <td>
                                <textarea class="form-control " name="code_example_code[]"> </textarea>
                            </td>
                        </tr>
                    @else
                        @foreach ($code_examples as $example)
                            <tr>
                                <td>

                                    <div class="col-md-4">
                                        <select id="output_type" name="code_example_language[]" class="form-control ">
                                            <option value="{{$example['language']}}">{{$example['language']}}</option>
                                            @foreach ($languages as $language)
                                                <option value="{{$language->asset_id}}">{{$language->asset_id}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <textarea class="form-control " name="code_example_code[]"> <?php echo stripslashes($example['code']); ?></textarea>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>

            <a id="addCodeExamples" name="add_param" class="btn btn-primary">Add More Code Examples</a>




<br><br>



            <div class="form-group">
                <h3 class="form_heading">Related Links</h3>
                <h4>Add related links to this API </h4>

                <table id="mytableLinks" class="table table-condensed">

                    <tbody class="table-striped">

                    @if (count($related_links) === 0)
                    <tr>
                        <td>

                            <input type="text"  placeholder="URL to link" name="related_link[]" class="form-control ">


                        </td>


                    </tr>
                    @else
                        @foreach ($related_links as $link)

                            <tr>
                                <td>

                                    <input type="text"  placeholder="URL to link" name="related_link[]" class="form-control " value="{{$link['url']}}">


                                </td>


                            </tr>

                        @endforeach
                    @endif

                    </tbody>
                </table>

            </div>


            <a id="addLinks" name="add_param" class="btn btn-primary">Add More Links</a>









            <!-- Button -->
            <div class="form-group">
                <label class="col-md-3 control-label" for="submit"></label>
                <div class="col-md-5">
                    <input type="submit" id="submit" name="submit" value=" >>>>>>>>>>>> UPDATE API <<<<<<<<<<<<<< " class="btn btn-success">

                </div>
            </div>

        </fieldset>
    </form>

@endsection