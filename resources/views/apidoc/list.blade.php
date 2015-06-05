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
    <th data-field="z" data-sortable="true"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Has example Success Response?"></span></th>
    <th data-field="a" data-sortable="true"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Has Consumer Services Client Code?"></span></th>
    <th data-field="category" data-sortable="true">Category</th>
    <th data-field="method" data-sortable="true">Method</th>
    <th data-field="name" data-sortable="true">URL End Point</th>
    <th data-field="desc" data-sortable="false">Description</th>
    <th data-field="x" data-sortable="false"></th>
    <th data-field="y" data-sortable="false"></th>




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

                <?php
                if ($api->json_example_success!="") { ?>

                <span class="glyphicon  glyphicon-ok green" ></span>

                <? } else { ?>
                <span class="glyphicon   glyphicon-remove red"></span>

                <?php } ?>

            </td>

            <td>
                <?php

                $json_code = $api->json_example_code;

                $code = json_decode($json_code);

                if (count($code) == 0) { ?>

                <span class="glyphicon  glyphicon-remove-circle red" aria-hidden="true"></span>

                <? } else { ?>
                <span class="glyphicon  glyphicon-ok-circle green" aria-hidden="true"></span>

                <?php } ?>



            </td>


            <td>
                <a href="/api/category/{{$api->category}}">
                    {{$api->category}}
                </a>
            </td>


            <td>

                <div class="btn btn-<?php echo $but_type; ?> btn-sm"> {{$api->method}}</div>

            </td>
            <td>
                <a href="/api/{{$api->id}}">
                    <?php echo $api->api_endpoint; ?>
                </a>

            </td>

            <td>
                <a href="/api/{{$api->id}}">
                    {{$api->name}}
                </a>
            </td>




            <td>
<a href="/api/edit/{{$api->id}}">
                <span class="glyphicon glyphicon-pencil blue" aria-hidden="true"></span></a>
            </td>
            <td>
                <a href="/api/run/{{$api->id}}">
                    <span class="glyphicon glyphicon-play blue" aria-hidden="true"></span></a>
            </td>


        </tr>
        @endforeach

    </table>
    @endif
@endsection

