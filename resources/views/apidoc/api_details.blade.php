@extends('app')
@section('javascript')
@endsection
@section('css')
@endsection
@section('content')

    <h2>Api Details for {{$api['url_endpoint']}}</h2>

    {{$api['category']}} : {{$api['name']}} : {{$api['short_code']}}  : {{$api['method']}} : {{$api['url_endpoint']}}
    <br><br>
    Description
    {{$api['description']}}
    <br><br>
    Relevant Return Values
    <br><br>
    <h3>Parameters</h3>
    <table class="table">

        @foreach ($parameters as $param)

<tr>
    <td>{{$param['name']}}</td>
    <td>{{$param['type']}}</td>
    <td>{{$param['desc']}}</td>
    <td>{{$param['max_length']}}</td>
    <td>{{$param['name']}}</td>
</tr>
        @endforeach

    </table>


    <h3>Exceptions</h3>
    <table class="table">
        <?php for ($a=0;$a<5;$a++)
        {
        ?>
        <tr>
            <td>Error Code</td>
            <td>Description</td>
        </tr>
        <?php

        }
        ?>
    </table>


    <h3>URL Construct</h3>
    {{$api['example_url_construct']}}


    <h3>Example Success</h3>
    <div class="well">
        {{$api['json_example_success']}}
    </div>

    <h3>Example Failure</h3>
    <div class="well">
        {{$api['json_example_failure']}}
    </div>


@endsection


