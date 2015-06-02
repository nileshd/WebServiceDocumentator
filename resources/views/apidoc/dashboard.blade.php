@extends('app')

@section('javascript')
@endsection

@section('css')
@endsection

@section('content')
    <h3>Dashboard</h3>

    <table class="table">


        @foreach ($num_apis_for_categories as $api_category)

            <tr>
                <td>

                    <a href="/api/category/{{$api_category->category}}">
                        <h3> {{$api_category->category}}</h3>
                    </a>
                </td>

                <td>
                  <h3>  {{$api_category->num_endpoints}} API endpoints </h3>
                </td>

                <td>

                    <h3>  {{$api_category->days_ago}} days ago </h3>
                </td>

            </tr>

        @endforeach

    </table>

@endsection

