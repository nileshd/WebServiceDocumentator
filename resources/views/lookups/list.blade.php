@extends('app')

@section('javascript')
@endsection

@section('css')
@endsection

@section('content')
    <h3>List All Lookups</h3>

    <table class="table">




        @foreach ($unique_asset_types as $lookup)



        <tr>
            <td>

                <a href="/api/category/{{$lookup->asset_type}}">
                   <h3> {{$lookup->asset_type}}</h3>
                </a>
            </td>

<td>
            {{$lookup->num_lookup}}
</td>

            <td>
                <a href="/lookups/add/{{$lookup->asset_type}}">
                    Add More
                </a>
            </td>


        </tr>
        <tr>
           <td colspan="3">
               <table class="table table-condensed table-striped">

                           @foreach ($members[$lookup->asset_type] as $member)
                       <tr>

                           <td>
            {{$member->asset_id}}
                           </td>
                           <td>
                               {{$member->secondary_filter}}
                           </td>
                           <td>
                               {{$member->asset_label}}
                           </td>
                       </tr>

                           @endforeach




               </table>


           </td>

        </tr>

        @endforeach

    </table>

@endsection

