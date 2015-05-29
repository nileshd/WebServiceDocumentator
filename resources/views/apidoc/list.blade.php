@extends('app')

@section('javascript')
@endsection

@section('css')
@endsection

@section('content')
    <h3>List All Apis</h3>

    <table class="table">




        @foreach ($apis as $api)
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


        <tr>
            <td>
                <a href="/api/category/{{$api['category']}}">
                    {{$api['category']}}
                </a>
            </td>
            <td>

                <div class="btn btn-<?php echo $but_type; ?> btn-small"> {{$api['method']}}</div>
            </td>
            <td>
                <a href="/api/{{$api['id']}}">
                    {{$api['url_endpoint']}}
                </a>
            </td>

            <td>
                <a href="/api/{{$api['id']}}">
                    {{$api['name']}} | {{$api['short_code']}}
                </a>
            </td>


        </tr>
        @endforeach

    </table>

@endsection

