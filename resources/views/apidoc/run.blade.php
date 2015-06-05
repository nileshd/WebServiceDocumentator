@extends('app')
@section('javascript')
    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>

    <script>


        $( ".param_input" ).keyup(function() {
            var input_txt = this.value;
            var match = this.name;
            input_txt = '<span class=\'api_endpoint\'>' + input_txt + '</span>';

            $('.param_'+match).html(input_txt);

        });


        $( "#server_list" ).change(function() {

            $('#server_url1').html('<span class=\'api_endpoint\'>'+this.value+'</span>');
            $('#server_url').html('<span class=\'api_endpoint\'>'+this.value+'</span>');
            $('#form_api_base_url').val(this.value);
        });

        $( "#run_api" ).click(function() {


            var f_api_base_url = $('#form_api_base_url').val();
            var f_api_end_point = $('#form_api_end_point').html();
            var f_api_extra_get_string = $('#extra_get_string').val();

            if (f_api_base_url == "") {
                alert("Please pick a server before proceeding");
            }
            else {



            // Removing HTML
            f_api_base_url = f_api_base_url.replace(/<\/?[^>]+(>|$)/g, "");
            f_api_end_point = f_api_end_point.replace(/<\/?[^>]+(>|$)/g, "");



            // alert(f_api_end_point);


            var url = "";
                url = 'http://apidocs:9009/api/output?url='+ encodeURIComponent(f_api_base_url + f_api_end_point+'?1=1&'+f_api_extra_get_string)+ "&method=GET";

           // $('#url_to_run').html(url);


                $( "#run_output" ).load( url );
        }
        });



    </script>
@endsection
@section('css')
    <link href="{{ asset('/css/code_prettify.css') }}" rel="stylesheet">
@endsection

@section('content')
    <?php

    switch($api['method']) {
        case "PUT":
            $but_type = "warning";
            break;
        case "POST":
            $but_type = "primary";
            break;
        case "DELETE":
            $but_type = "danger";
            break;
        case "GET":
            $but_type = "success";
            break;
        default:
            $but_type = "default";
            break;

    }



    ?>


    <h3><span class="api_category_small">{{$api['category']}} Collection</span></h3>

   <h3> <div class="btn btn-<?php echo $but_type; ?> btn-xs"> {{$api['method']}}</div>  <span id="server_url1"></span><span class="api_title"><?php echo $api_endpoint; ?></span></h3>

    Function : {{$api['name']}} <br><br>

    <table class="table">
        <tr>
            <td class="col-md-6">


<form id="run_form">

    <input type="hidden" id="form_api_base_url" name="api_base_url" value="">

             <span class="invisible">   <span id="server_url"></span><span id="form_api_end_point"><?php echo $api_endpoint; ?></span></span>


                <h4 class="api_title">Please choose a Server to Run on</h4>
                <select name="server" id="server_list">
                    <option value="">Select an Environment</option>
                    @foreach ($servers as $server)
                        <option value="{{$server->asset_id}}">{{$server->asset_label}} : {{$server->asset_id}}</option>
                    @endforeach


                </select>
                <br><br>

    @if (count($replace_array) === 0)

        <span class="no_data"> No Parameters needed for this function</span>

    @endif


                <table class="table">
                    @foreach ($replace_array as $param)
                        <tr>
                            <td class="col-md-4"><strong>{ { {{$param}} } }</strong></td>
                            <td><input id="param_field" type="text" name="{{$param}}" value="" class="param_input"></td>


                        </tr>

                    @endforeach
                        <tr>
                            <td class="col-md-4"><strong>EXTRA GET STRING</strong></td>
                            <td><input id="extra_get_string" type="text" name="extra_get_string" value="token=iamsparefoot" class="param_input"></td>


                        </tr>


                </table>








    <a id="run_api" name="run_api" class="btn btn-primary btn-lg">RUN API</a>


</form>
                <h3 class="api_title">URL Constructs</h3>
                {{$api['example_call_construct']}}
                <br>
                @foreach ($servers as $server)
                    <strong  class="api_title">{{$server->asset_label}} : </strong>  {{$server->asset_id}}{{$api['api_endpoint']}}?token=iamsparefoot&pretty=1  <br><br>
                @endforeach


            </td>
            <td class="col-md-6">
                <h4>Web Service Output</h4>
                <span id="url_to_run" class=" prettyprint"></span>

<pre id="run_output" class="ws_output prettyprint">
OUTPUT
</pre>
            </td>
        </tr>

    </table>

@endsection


