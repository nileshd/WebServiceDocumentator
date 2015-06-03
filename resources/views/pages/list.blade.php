@extends('app')

@section('javascript')
@endsection

@section('css')
@endsection

@section('content')
    <h3>List All Apis</h3>



    @if (count($pages) === 0)

        No Pages have been added yet.

    @else


    <table class="table">




        @foreach ($pages as $page)


        <tr>
            <td>
                <a href="/pages/category/{{$page->category}}">
                    {{$page->category}}
                </a>
            </td>

            <td>
                <a href="/pages/{{$page->id}}">
                    <?php echo $page->title; ?>
                </a>
            </td>

        </tr>
        @endforeach

    </table>
    @endif
@endsection

