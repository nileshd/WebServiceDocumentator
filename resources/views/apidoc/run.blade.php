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

            $('#server_url').html('<span class=\'api_endpoint\'>'+this.value+'</span>');
            $('#form_api_base_url').val(this.value);
        });

        $( "#run_api" ).click(function() {


            var f_api_base_url = $('#form_api_base_url').val();
            var f_api_end_point = $('#form_api_end_point').html();

            if (f_api_base_url == "") {
                alert("Please pick a server before proceeding");
            }
            else {



            // Removing HTML
            f_api_base_url = f_api_base_url.replace(/<\/?[^>]+(>|$)/g, "");
            f_api_end_point = f_api_end_point.replace(/<\/?[^>]+(>|$)/g, "");


            // alert(f_api_end_point);

            $('#run_output').html(f_api_base_url + f_api_end_point);
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

   <h3> <div class="btn btn-<?php echo $but_type; ?> btn-small"> {{$api['method']}}</div>  <span class="api_title"><?php echo $api_endpoint; ?></span></h3>

    Function : {{$api['name']}} <br><br>

    <table class="table">
        <tr>
            <td class="col-md-6">


<form id="run_form">

    <input type="hidden" id="form_api_base_url" name="api_base_url" value="">


                <span id="server_url"></span><span id="form_api_end_point"><?php echo $api_endpoint; ?></span>

                <br>    <br>

                Server to Run on :
                <select name="server" id="server_list">
                    <option value="">Select an Environment</option>
                    @foreach ($servers as $server)
                        <option value="{{$server->asset_id}}">{{$server->asset_label}} : {{$server->asset_id}}</option>
                    @endforeach


                </select>
                <br><br>
                <table class="table">
                    @foreach ($replace_array as $param)
                        <tr>
                            <td class="col-md-4"><strong>{ { {{$param}} } }</strong></td>
                            <td><input id="param_field" type="text" name="{{$param}}" value="" class="param_input"></td>


                        </tr>

                    @endforeach
                </table>


    <a id="run_api" name="run_api" class="btn btn-primary">RUN API</a>


</form>
                <h3 class="api_title">URL Construct</h3>
                {{$api['example_call_construct']}}
                <br>
                @foreach ($servers as $server)
                    <strong>{{$server->asset_label}}</strong>  {{$server->asset_id}}{{$api['api_endpoint']}}?token=iamsparefoot&pretty=1  <br>
                @endforeach


            </td>
            <td class="col-md-6">
                <h4>Web Service Output</h4>
                <div id="run_output" class="ws_output">


                    OUTPUT

                </div>
            </td>
        </tr>

    </table>

@endsection


