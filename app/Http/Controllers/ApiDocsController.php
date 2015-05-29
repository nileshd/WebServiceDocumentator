<?php namespace App\Http\Controllers;

use App\apidoc;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\lookup;
use Illuminate\Http\Request;

class ApiDocsController extends Controller {

    public function getAll()
    {
        $apidoc = new apidoc();
        $all_apis = $apidoc->all()->toArray();


        for ($a=0;$a<count($all_apis);$a++)
        {

            $api = $all_apis[$a];
            $api_endpoint = $api['api_endpoint'];

            // Adding colorized labels to URL endpoints
            preg_match_all('/{(.*?)}/', $api_endpoint, $matches);
            foreach($matches[1] as $match)
            {
                $search = "{".$match."}";
                $to_replace = "<span class=\"api_endpoint_parts\">$search</span>";
                $api_endpoint = str_replace($search,$to_replace,$api_endpoint);
            }

            $api['api_endpoint'] = $api_endpoint;

            $all_apis[$a] = $api;

        }


        $data = array();
        $data['apis'] = $all_apis;
        return view("apidoc.list", $data);
    }

    public function getById($id)
    {
        $apidoc = new apidoc();
        $api_details = $apidoc->find($id)->toArray();
        $parameters = ($api_details['json_parameters_needed']!="") ? json_decode($api_details['json_parameters_needed'],true) : array();
        $exceptions = ($api_details['json_exceptions']!="") ? json_decode($api_details['json_exceptions'],true) : array();


         // Adding colorized labels to URL endpoints
         $api_end_point = $api_details['api_endpoint'];
preg_match_all('/{(.*?)}/', $api_end_point, $matches);
foreach($matches[1] as $match)
{
    $search = "{".$match."}";
    $to_replace = "<span class=\"api_endpoint_parts\">$search</span>";
    $api_end_point = str_replace($search,$to_replace,$api_end_point);
}

        $data = array();
        $data['api'] = $api_details;
        $data['parameters'] = $parameters;
        $data['exceptions'] = $exceptions;
        $data['endpoint'] = $api_end_point;
        return view("apidoc.api_details", $data);

    }


    public function getByCategory($category)
    {

        $apidoc = new apidoc();
        //$all_apis = $apidoc->query()  all()->toArray();
       // $all_apis =   DB::table('apidocs')->where('category', '=', $category)->get();
//$apidoc->all()

        for ($a=0;$a<count($all_apis);$a++)
        {

            $api = $all_apis[$a];
            $api_endpoint = $api['api_endpoint'];

            // Adding colorized labels to URL endpoints
            preg_match_all('/{(.*?)}/', $api_endpoint, $matches);
            foreach($matches[1] as $match)
            {
                $search = "{".$match."}";
                $to_replace = "<span class=\"api_endpoint_parts\">$search</span>";
                $api_endpoint = str_replace($search,$to_replace,$api_endpoint);
            }

            $api['api_endpoint'] = $api_endpoint;

            $all_apis[$a] = $api;

        }


        $data = array();
        $data['apis'] = $all_apis;
        return view("apidoc.list", $data);




    }

    public function add()
    {

        $categories =   DB::table('lookups')->where('asset_type', '=', "category")->get();


        $data = array();
        $data['categories'] = $categories;
        return view("apidoc.add", $data);

    }

    public function insert()
    {

        //echo "<pre>";
        //print_r($_POST);

        $apidoc = new apidoc();
        $apidoc->name = $_POST['name'];
        $apidoc->description = $_POST['description'];
        $apidoc->category = $_POST['category'];

        $apidoc->api_endpoint = $_POST['url_endpoint'];
        $apidoc->method = $_POST['http_method'];
        $apidoc->output_format = $_POST['output_type'];
        $apidoc->json_example_success = $_POST['json_success'];
        $apidoc->example_call_construct = $_POST['example_url'];


        $params_from_request = $_POST['param_name'];
        $number_params = count($params_from_request);

        $params = array();
        for($a=0;$a<$number_params;$a++)
        {
            $param_array = array();
            $param_array['name'] = $_POST['param_name'][$a];
            $param_array['type'] = $_POST['param_type'][$a];
            $param_array['required'] = $_POST['param_required'][$a];
            $param_array['desc'] = $_POST['param_description'][$a];

            if ($param_array['name']!="") {
                $params[] = $param_array;
            }
        }

        $json_params = json_encode($params);
        $apidoc->json_parameters_needed = $json_params;

       try {
        $apidoc->save();

        $data = array();
        $data['category'] = $_POST['category'];
        $data['url_endpoint'] = $_POST['url_endpoint'];

        return view("apidoc.add_successful", $data);
       }
       catch (\Exception $e)
       {
           $data = array();
           $data['error_message'] = $e->getMessage();
           return view("apidoc.add_failed", $data);
       }
    }


    public function update()
    {
        $data = array();
        return view("apidoc.edit", $data);

    }


}
