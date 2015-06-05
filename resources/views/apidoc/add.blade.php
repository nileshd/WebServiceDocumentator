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

    <form class="form-horizontal" method="POST" action="/api/insert">


        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">


        <fieldset>

            <!-- Form Name -->
<div class="instructions">
            Please add the details for the API that you have developed. Provide as much details as you can. You can add as many parameters, exceptions/errors and code examples that you wish, by pressing the relevant 'add more' buttons in each sections. It will dynamically augment the form. After filling in the form, press the Green Button at the bottom of the form to Save.
</div>
            <h3 class="form_heading">API Details</h3>
            <!-- Select Basic -->
            <div class="form-group">
                <label class="col-md-3 control-label" for="category">Category</label>
                <div class="col-md-4">
                    <select id="category" name="category" class="form-control ">

                        @foreach ($categories as $category)
                            <option value="{{$category->asset_id}}">{{$category->asset_id}}</option>
                        @endforeach



                    </select>
                </div>
            </div>



            <!-- Text input-->
            <div class="form-group required-control">
                <label class="col-md-3 control-label" for="url_endpoint"><strong>API Endpoint</strong></label>
                <div class="col-md-8">
                    <input id="url_endpoint" name="url_endpoint" type="text" placeholder="URL Endpoint" class="form-control " required="">
                    <p class="help-block"><strong>Put URI parameters in curly braces {}</strong> e.g /car/drive/<strong>{</strong>direction<strong>}</strong>/<strong>{</strong>speed<strong>}</strong></p>
                </div>
            </div>


            <!-- Text input-->
            <div class="form-group required-control">
                <label class="col-md-3 control-label" for="url_endpoint">API Alias (e.g Cient SDK)</label>
                <div class="col-md-8">
                    <input id="alias" name="alias" type="text" placeholder="API Alias" class="form-control  ">

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
                    <textarea id="json_success" name="json_success" class="form-control input-lg"></textarea>
                </div>
            </div>


            <!-- Text input-->
            <div class="form-group">
                <label class="col-md-3 control-label" for="name">Example URL Construct</label>
                <div class="col-md-5">
                    <input id="example_call_construct" name="example_call_construct" type="text" placeholder="a real example with example parameters e.g /car/increase_speed/5" class="form-control ">

                </div>
            </div>


            <div class="form-group">
                <h3 class="form_heading">API Parameters</h3>
                <table id="mytable" class="table table-condensed">

                    <tbody class="table-striped">


                    <tr>
                        <td>&nbsp;</td>
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

                            <select class="form-control " name="param_location[]">
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
                    </tbody>
                </table>

            </div>


            <a id="addParameters" name="add_param" class="btn btn-primary">Add More Parameters</a>


<br><br>

            <div class="form-group">
                <h3 class="form_heading">Exceptions</h3>
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


            <a id="addExceptions" name="add_param" class="btn btn-primary">Add More Exceptions</a>




            <br><br>


            <div class="form-group">
                <h3 class="form_heading">Code Examples</h3>
                <h4>Do not add the < ?php or the < script> tags as the framework filters them out and does not allow saving </h4>

                <table id="mytableCodeExamples" class="table table-condensed">

                    <tbody class="table-striped">


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


                    <tr>
<td>

                        <input type="text"  placeholder="URL to link" name="related_link[]" class="form-control ">


</td>


                    </tr>
                    </tbody>
                </table>

            </div>


            <a id="addLinks" name="add_param" class="btn btn-primary">Add More Links</a>





            <!-- Button -->
            <div class="form-group">
                <label class="col-md-3 control-label" for="submit"></label>
                <div class="col-md-5">

                    <input type="submit" id="submit" name="submit" value=" >>>>>>>>>>>> ADD NEW API <<<<<<<<<<<<<< " class="btn btn-success">

                </div>
            </div>

        </fieldset>
    </form>



@endsection