@extends('app')

@section('javascript')
    <script src="/js/bootstrap-table/bootstrap-table.js"></script>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/bootstrap-table.css">
@endsection

@section('content')
    <h3>List {{$api_type}} Apis</h3>



    @if (count($apis) === 0)

        No APIs have been added yet.

    @else


    <table class="table" data-toggle="table" data-show-columns="true" data-search="true" >

<thead>
<tr>
    <th data-field="category" data-sortable="true">Category</th>
    <th data-field="method" data-sortable="true">Method</th>
    <th data-field="name" data-sortable="true">URL End Point</th>
    <th data-field="desc" data-sortable="true">Description</th>



</tr>


</thead>


        @foreach ($apis as $api)
            <?php

                switch($api->method) {
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
                <a href="/api/category/{{$api->category}}">
                    {{$api->category}}
                </a>
            </td>
            <td>

                <div class="btn btn-<?php echo $but_type; ?> btn-small"> {{$api->method}}</div>

            </td>
            <td>
                <a href="/api/{{$api->id}}">
                    <?php echo $api->api_endpoint; ?>
                </a>

                <a href="/api/edit/{{$api->id}}">(Edit)</a>
                <a href="/api/run/{{$api->id}}">(Run)</a>
            </td>

            <td>
                <a href="/api/{{$api->id}}">
                    {{$api->name}}
                </a>
            </td>


        </tr>
        @endforeach

    </table>
    @endif
@endsection

