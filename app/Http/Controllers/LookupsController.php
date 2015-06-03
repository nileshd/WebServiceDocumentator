<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\lookup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LookupsController extends Controller {



    public function getAll()
    {
        $unique_asset_types = DB::select('select distinct asset_type,count(asset_id) as num_lookup from lookups GROUP by asset_type');


        $members = array();
        foreach($unique_asset_types as $asset)
        {
            $asset_type = $asset->asset_type;
            $members[$asset_type] = DB::select('select * from lookups where asset_type = ?',[$asset_type]);

        }



        $data = array();
        $data['unique_asset_types'] = $unique_asset_types;
        $data['members'] = $members;

        return view("lookups.list", $data);
    }


    public function add($asset_type)
    {
        $unique_asset_types = DB::select('select distinct asset_type,count(asset_id) as num_lookup from lookups GROUP by asset_type');



        $data = array();
        $data['unique_asset_types'] = $unique_asset_types;
        $data['asset_type'] = $asset_type;

        return view("lookups.add", $data);
    }



    public function insert(Request $request)
    {
        $lookup = new lookup();
        $lookup->asset_type = $_POST['asset_type'];
        $lookup->asset_id = $_POST['asset_id'];
        $lookup->secondary_filter = $_POST['secondary_filter'];
        $lookup->asset_label = $_POST['asset_label'];
        $lookup->weight = $_POST['weight'];
        try {
            $lookup->save();

            $data = array();
            $data['asset_type'] = $_POST['asset_type'];
            $data['asset_id'] = $_POST['asset_id'];

            return view("lookups.add_successful", $data);
        }
        catch (\Exception $e)
        {
            $data = array();
            $data['error_message'] = $e->getMessage();
            return view("lookups.add_failed", $data);
        }
    }



}
