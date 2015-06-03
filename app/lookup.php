<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class lookup extends Model {

	//

    function getBaseServerUrlsByCategory($category)
    {

        $servers = DB::table('lookups')->where('asset_type', '=', "base_server_url")->where('secondary_filter', '=', $category)->orderBy('weight', 'asc')->get();

        return $servers;
    }



    function getCategories()
    {
        $categories =   DB::table('lookups')->where('asset_type', '=', "category")->orderBy('weight', 'asc')->get();

        return $categories;

    }

    function getLanguages()
    {
        $languages =   DB::table('lookups')->where('asset_type', '=', "languages")->orderBy('weight', 'asc')->get();

        return $languages;

    }



    function getOutputTypes()
    {
        $output_type =   DB::table('lookups')->where('asset_type', '=', "output_type")->orderBy('weight', 'asc')->get();

        return $output_type;

    }


    function getParamTypes()
    {
        $output_type =   DB::table('lookups')->where('asset_type', '=', "param_type")->orderBy('weight', 'asc')->get();

        return $output_type;

    }


    function getParamCategories()
    {
        $output_type =   DB::table('lookups')->where('asset_type', '=', "param_category")->orderBy('weight', 'asc')->get();

        return $output_type;

    }
}
