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


    <h3> <div class="btn btn-<?php echo $but_type; ?> btn-small"> {{$api['method']}}</div>  <span class="api_title"><?php echo $endpoint; ?></span></h3>
    <strong>{{$api['name']}}</strong>   <br>
    Category : <strong>{{$api['category']}}</strong><br>
    Last Udpated on : <strong>{{$api['updated_at']}}</strong><br>


    <h3 class="api_title">Description</h3>
    {{$api['description']}}
    <br><br>
    <h3 class="api_title">Parameters</h3>

    @if (count($parameters) === 0)

        <span class="no_data"> No Parameters needed for this function</span>

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

    @if (count($servers) > 0)




    <h3 class="api_title">URL Construct</h3>

    <br>
    @foreach ($servers as $server)
        <strong>{{$server->asset_label}}</strong>  {{$server->asset_id}}{{$api['api_endpoint']}}?token=iamsparefoot&pretty=1  <br>
    @endforeach
    @endif

    @if (rtrim(ltrim($api['json_example_code'])) != "" )
        <h3 class="api_title">Example Client Code</h3>

        @if (count($code_examples) === 0)

            <span class="no_data">No Client Code exampple for this function</span>

        @else

        @foreach ($code_examples as $example)


            <h4 class="green">{{$example['language']}}</h4>
            <pre class=" prettyprint">
<br><?php echo stripslashes($example['code']); ?><br>
</pre>



        @endforeach


        @endif

    @endif


    <h3 class="api_title">Example Success</h3>
    @if (rtrim(ltrim($api['json_example_success'])) == "")

       <span class="no_data">No Success Example provided for this function</span>

    @else



<pre class=" prettyprint">
<br>{{$api['json_example_success']}}<br>
</pre>

    @endif

    @if ($api['json_example_failure'] != "" )
        <h3 class="api_title">Example Failure</h3>
        <div class="well">
            {{$api['json_example_failure']}}
        </div>

    @endif




    @if (count($related_links)>0)

        <h3 class="api_title">Related Links</h3>

        @foreach ($related_links as $link)
            <li><a href="{{$link['url']}}" target="_blank">{{$link['url']}}</a></li>
        @endforeach

    @endif




<hr>
<a href="/api/edit/{{$api['id']}}">Edit</a> | <a href="/api/run/{{$api['id']}}">Run</a>
@endsection


