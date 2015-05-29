<?php namespace App\Http\Controllers;

use App\apidoc;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ApiDocsController extends Controller {

    public function getAll()
    {
        $apidoc = new apidoc();
        $all_apis = $apidoc->all()->toArray();


        $data = array();
        $data['apis'] = $all_apis;
        return view("apidoc.list", $data);
    }

    public function getById($id)
    {
        $apidoc = new apidoc();
        $api_details = $apidoc->find($id)->toArray();
        $parameters = json_decode($api_details['json_parameters_needed'],true);

        $data = array();
        $data['api'] = $api_details;
        $data['parameters'] = $parameters;
        return view("apidoc.api_details", $data);

    }


    public function getByCategory($category)
    {
        $data = array();
        return view("apidoc.list", $data);

    }

    public function add()
    {
        $data = array();
        return view("apidoc.add", $data);

    }

    public function insert()
    {

echo "<pre>";
        print_r($_POST);

        $apidoc = new apidoc();
        $apidoc->name = $_POST['name'];
        $apidoc->description = $_POST['description'];
        $apidoc->category = $_POST['category'];
        //$apidoc->short_code  = $_POST['shortcode'];
        $apidoc->url_endpoint = $_POST['url_endpoint'];
        $apidoc->method = $_POST['http_method'];
        $apidoc->output_format = $_POST['output_type'];
        $apidoc->json_example_success = $_POST['json_success'];
        $apidoc->example_url_construct = $_POST['example_url'];


        $params_from_request = $_POST['param_name'];
        $number_params = count($params_from_request);

        $params = array();
        for($a=0;$a<$number_params;$a++)
        {
            $param_array = array();
            $param_array['name'] = $_POST['param_name'][$a];
            $param_array['type'] = $_POST['param_type'][$a];
            $param_array['max_length'] = $_POST['param_max_length'][$a];
            $param_array['desc'] = $_POST['param_description'][$a];
            $params[] = $param_array;
        }

        $json_params = json_encode($params);

        $apidoc->json_parameters_needed = $json_params;

        $apidoc->save();

        $data = array();
        return view("apidoc.add", $data);

    }


    public function update()
    {
        $data = array();
        return view("apidoc.edit", $data);

    }


}
