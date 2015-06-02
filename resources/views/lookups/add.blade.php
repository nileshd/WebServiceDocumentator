@extends('app')
@section('javascript')
@endsection
@section('css')
@endsection
@section('content')

    <form class="form-horizontal" method="POST" action="/lookups/insert">


        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">


        <fieldset>

            <!-- Form Name -->
<div class="instructions">
The Lookups table is a very generic key value table that stores all lookup information needed the app. Example of what is stores in there are the categories, base_url for servers, http methods etc.. The Lookup Category would be the grouping e.g category and the lookup value would be a member of that set.
</div>
            <h3 class="form_heading">Add New Lookup Data</h3>
            <!-- Select Basic -->
            <div class="form-group required-control">
                <label class="col-md-3 control-label"><strong>Lookup Category</strong></label>
                <div class="col-md-8">
                    <input id="asset_type" name="asset_type" type="text" placeholder="Lookup Category" class="form-control " required="" value="{{$asset_type}}">
                    <p class="help-block">put new or existing category</p>
                </div>
            </div>



            <!-- Text input-->
            <div class="form-group required-control">
                <label class="col-md-3 control-label" for=""><strong>Lookup Value</strong></label>
                <div class="col-md-8">
                    <input id="asset_id" name="asset_id" type="text" placeholder="" class="form-control " required="">

                </div>
            </div>


            <!-- Text input-->
            <div class="form-group required-control">
                <label class="col-md-3 control-label" for=""><strong>Lookup Secondary Filter Value (if any)</strong></label>
                <div class="col-md-8">
                    <input id="secondary_filter" name="secondary_filter" type="text" placeholder="" class="form-control " >

                </div>
            </div>



            <!-- Text input-->
            <div class="form-group required-control">
                <label class="col-md-3 control-label" for=""><strong>Lookup Label (if any)</strong></label>
                <div class="col-md-8">
                    <input id="asset_label" name="asset_label" type="text" placeholder="" class="form-control ">

                </div>
            </div>


            <!-- Button -->
            <div class="form-group">
                <label class="col-md-3 control-label" for="submit"></label>
                <div class="col-md-5">

                    <input type="submit" id="submit" name="submit" value=" >>>>>>>>>>>> ADD NEW LOOKUP <<<<<<<<<<<<<< " class="btn btn-success">

                </div>
            </div>

        </fieldset>
    </form>



@endsection