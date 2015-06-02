<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class lookup extends Model {

	//

    function getBaseServerUrlsByCategory($category)
    {

        $servers = DB::table('lookups')->where('asset_type', '=', "base_server_url")->where('secondary_filter', '=', $category)->get();

        return $servers;
    }



    function getCategories()
    {
        $categories =   DB::table('lookups')->where('asset_type', '=', "category")->get();

        return $categories;

    }

}
