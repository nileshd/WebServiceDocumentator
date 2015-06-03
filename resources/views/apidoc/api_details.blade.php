@extends('app')
@section('javascript')
    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
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


    <h3><span class="api_category_small">{{$api['category']}}</span>  :: <div class="btn btn-<?php echo $but_type; ?> btn-small"> {{$api['method']}}</div>  <span class="api_title"><?php echo $endpoint; ?></span></h3>

    Function : {{$api['name']}} <br><br>


    <h3 class="api_title">Description</h3>
    {{$api['description']}}
    <br><br>
    <h3 class="api_title">Parameters</h3>

    @if (count($parameters) === 0)

        No Parameters needed for this function

    @else

        <table class="table">

            @foreach ($parameters as $param)

                <tr>
                    <td class="api_param_name">{{$param['name']}}</td>
                    <td>{{$param['location']}}</td>
                    <td>{{$param['required']}}</td>
                    <td>{{$param['type']}}</td>
                    <td>{{$param['desc']}}</td>


                </tr>
            @endforeach

        </table>
    @endif


    @if (count($exceptions) > 0)
        <h3 class="api_title">Exceptions</h3>

        <table class="table">
            @foreach ($exceptions as $exception)
                <tr>
                    <td>{{$exception['code']}}</td>
                    <td>{{$exception['name']}}</td>
                    <td>{{$exception['desc']}}</td>
                </tr>
            @endforeach
        </table>
    @endif

    <h3 class="api_title">URL Construct</h3>
    {{$api['example_call_construct']}}
    <br>
    @foreach ($servers as $server)
        <strong>{{$server->asset_label}}</strong>  {{$server->asset_id}}{{$api['api_endpoint']}}?token=iamsparefoot&pretty=1  <br>
    @endforeach

    @if (rtrim(ltrim($api['json_example_code'])) != "" )
        <h3 class="api_title">Example Client Code</h3>



        @foreach ($code_examples as $example)


            <h4>{{$example['language']}}</h4>
            <pre class=" prettyprint">
<?php echo stripslashes($example['code']); ?>
</pre>



        @endforeach




    @endif


    <h3 class="api_title">Example Success</h3>

    <pre class=" prettyprint">
{{$api['json_example_success']}}
</pre>



    @if ($api['json_example_failure'] != "" )
        <h3 class="api_title">Example Failure</h3>
        <div class="well">
            {{$api['json_example_failure']}}
        </div>

    @endif





@endsection


