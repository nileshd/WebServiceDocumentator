<?php namespace App\Http\Controllers;

use App\apidoc;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ApiDocsController extends Controller {



    public function dashboard()
    {
        $num_apis_for_categories = DB::select('select distinct category,count(api_endpoint) as num_endpoints,max(updated_at) as last_date from apidocs GROUP by category order by num_endpoints desc');

        for ($a=0;$a<count($num_apis_for_categories); $a++)
        {
            $api = $num_apis_for_categories[$a];
            $days_ago =  Carbon::createFromTimestamp(strtotime($api->last_date))->diffInDays();
            $api->days_ago = $days_ago;
            $num_apis_for_categories[$a] = $api;
        }



        $data = array();
        $data['num_apis_for_categories'] = $num_apis_for_categories;

        return view("apidoc.dashboard", $data);
    }

    public function about()
    {

        $data = array();
        return view("about", $data);
    }



    public function getAll()
    {


        $apiList =   DB::table('apidocs')->where('flag_on', '=', 1)->orderBy('api_endpoint', 'asc')->get();
        $apiList = $this->processAPIList($apiList);
        $data = array();
        $data['apis'] = $apiList;
        $data['api_type'] = " All ";
        return view("apidoc.list", $data);
    }


    public function getByCategory($category)
    {
        $apiList =   DB::table('apidocs')->where('category', '=', $category)->where('flag_on', '=', 1)->orderBy('api_endpoint', 'asc')->get();
        $apiList = $this->processAPIList($apiList);

        $data = array();
        $data['apis'] = $apiList;
        $data['api_type'] = $category;
        return view("apidoc.list", $data);
    }



    public function getApis($category=null)
    {
        $apiList =   DB::table('apidocs')->where('flag_on', '=', 1)->get();
        $apiList = $this->processAPIList($apiList);

        $data = array();
        $data['apis'] = $apiList;
        return view("apidoc.list", $data);
    }


    private function processAPIList($apiList)
    {
        for ($a=0;$a<count($apiList);$a++)
        {
            $api = $apiList[$a];
            $api_endpoint = $api->api_endpoint;
            // Adding colorized labels to URL endpoints
            preg_match_all('/{(.*?)}/', $api_endpoint, $matches);
            foreach($matches[1] as $match)
            {
                $search = "{".$match."}";
                $to_replace = "<span class=\"api_endpoint_parts\">$search</span>";
                $api_endpoint = str_replace($search,$to_replace,$api_endpoint);
            }
            $api->api_endpoint = $api_endpoint;
            $apiList[$a] = $api;
        }
        return $apiList;
    }



    public function run($id)
    {

        $apidoc = new apidoc();
        $api_details = $apidoc->find($id)->toArray();
        $parameters = ($api_details['json_parameters_needed']!="") ? json_decode($api_details['json_parameters_needed'],true) : array();
        $exceptions = ($api_details['json_exceptions']!="") ? json_decode($api_details['json_exceptions'],true) : array();



        $category = $api_details['category'];

        $servers = $this->lookupManager->getBaseServerUrlsByCategory($category);

        $api_endpoint = $api_details['api_endpoint'];
        // Adding colorized labels to URL endpoints
        preg_match_all('/{(.*?)}/', $api_endpoint, $matches);


        $replace_array = array();
        $i = 0;
        foreach($matches[1] as $match)
        {
            $search_term = "{".$match."}";
            $replace_array[$i] = $match;

            $to_replace = "<span class=\"param_{$match}\">$search_term</span>";

            $api_endpoint = str_replace($search_term,$to_replace,$api_endpoint);
            $i++;
        }



        $data = array();
        $data['api'] = $api_details;
        $data['parameters'] = $parameters;
        $data['exceptions'] = $exceptions;
        $data['replace_array'] = $replace_array;
        $data['servers'] = $servers;
        $data['api_endpoint'] = $api_endpoint;


        return view("apidoc.run", $data);

    }





    public function getById($id)
    {


        $apidoc = new apidoc();
        $api_details = $apidoc->find($id)->toArray();

        if (!$api_details)
        {
            exit("NIL");
        }


        $parameters = ($api_details['json_parameters_needed']!="") ? json_decode($api_details['json_parameters_needed'],true) : array();
        $exceptions = ($api_details['json_exceptions']!="") ? json_decode($api_details['json_exceptions'],true) : array();
        $code_examples = ($api_details['json_example_code']!="") ? json_decode($api_details['json_example_code'],true) : array();


        $category = $api_details['category'];


        $servers =  $this->lookupManager->getBaseServerUrlsByCategory($category);

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
        $data['code_examples'] = $code_examples;
        $data['endpoint'] = $api_end_point;
        $data['servers'] = $servers;

        return view("apidoc.api_details", $data);

    }





    public function add()
    {


        $languages = $this->lookupManager->getLanguages();
        $outputTypes = $this->lookupManager->getOutputTypes();
        $paramTypes = $this->lookupManager->getParamTypes();
        $paramCategories = $this->lookupManager->getParamCategories();

        $data = array();
        $data['categories'] = $this->categories;
        $data['languages'] = $languages;
        $data['outputTypes'] = $outputTypes;

        $data['paramTypes'] = $paramTypes;
        $data['paramCategories'] = $paramCategories;

        return view("apidoc.add", $data);

    }

    public function edit($id)
    {

        $apidoc = new apidoc();
        $api_details = $apidoc->find($id)->toArray();

        $parameters = ($api_details['json_parameters_needed']!="") ? json_decode($api_details['json_parameters_needed'],true) : array();
        $exceptions = ($api_details['json_exceptions']!="") ? json_decode($api_details['json_exceptions'],true) : array();
        $code_examples = ($api_details['json_example_code']!="") ? json_decode($api_details['json_example_code'],true) : array();



        $languages = $this->lookupManager->getLanguages();
        $outputTypes = $this->lookupManager->getOutputTypes();
        $paramTypes = $this->lookupManager->getParamTypes();
        $paramCategories = $this->lookupManager->getParamCategories();


        $data = array();
        $data['api'] = $api_details;
        $data['api_id'] = $id;
        $data['parameters'] = $parameters;
        $data['exceptions'] = $exceptions;
        $data['code_examples'] = $code_examples;
        $data['categories'] = $this->categories;

        $data['languages'] = $languages;
        $data['outputTypes'] = $outputTypes;

        $data['paramTypes'] = $paramTypes;
        $data['paramCategories'] = $paramCategories;

        return view("apidoc.edit", $data);

    }

    private function processApiParamsFromForm($form_data_array)
    {
        $number_items = count($form_data_array);
        $return_array = array();

        if ($number_items==0) { return $return_array; }

        for($a=0;$a<$number_items;$a++)
        {
            $item_array = array();
            $item_array['name'] = $_POST['param_name'][$a];
            $item_array['type'] = $_POST['param_type'][$a];
            $item_array['required'] = $_POST['param_required'][$a];
            $item_array['desc'] = $_POST['param_description'][$a];
            $item_array['location'] = $_POST['param_location'][$a];
            $item_array['length'] = "";


            if ($item_array['name']!="") {
                $return_array[] = $item_array;
            }
        }

        $massaged_json_data = json_encode($return_array);
        return $massaged_json_data;
    }

    private function processApiExceptionsFromForm($form_data_array)
    {
        $number_items = count($form_data_array);
        $return_array = array();

        if ($number_items==0) { return $return_array; }

        for($a=0;$a<$number_items;$a++)
        {
            $item_array = array();
            $item_array['name'] = $_POST['exception_name'][$a];
            $item_array['desc'] = $_POST['exception_description'][$a];
            $item_array['code'] = $_POST['exception_code'][$a];


            if ($item_array['name']!="") {
                $return_array[] = $item_array;
            }
        }

        $massaged_json_data = json_encode($return_array);
        return $massaged_json_data;
    }

    private function processApiCodeExamplesFromForm($form_data_array)
    {
        $number_items = count($form_data_array);
        $return_array = array();

        if ($number_items==0) { return $return_array; }

        for($a=0;$a<$number_items;$a++)
        {
            $item_array = array();
            $item_array['language'] = addslashes($_POST['code_example_language'][$a]);
            $item_array['code'] = addslashes($_POST['code_example_code'][$a]);


            if (rtrim(ltrim($item_array['code']))!="") {
                $return_array[] = $item_array;
            }
        }

        $massaged_json_data = json_encode($return_array);
        return $massaged_json_data;
    }

    public function insert(Request $request)
    {
        $apidoc = new apidoc();
        $apidoc->name = $_POST['name'];
        $apidoc->description = $_POST['description'];
        $apidoc->category = $_POST['category'];

        $apidoc->api_endpoint = $_POST['url_endpoint'];
        $apidoc->alias = $_POST['alias'];

        $apidoc->method = $_POST['http_method'];
        $apidoc->output_format = $_POST['output_type'];
        $apidoc->json_example_success = $_POST['json_success'];
        $apidoc->example_call_construct = $_POST['example_call_construct'];

        $json_api_params = $this->processApiParamsFromForm($_POST['param_name']);
        $apidoc->json_parameters_needed = $json_api_params;

        $json_exceptions = $this->processApiExceptionsFromForm($_POST['exception_name']);
        $apidoc->json_exceptions = $json_exceptions;

        $json_codeexamples = $this->processApiCodeExamplesFromForm($request->input('code_example_code'));
        $apidoc->json_example_code = $json_codeexamples;



        try {
            $apidoc->save();

            $data = array();
            $data['category'] = $_POST['category'];
            $data['url_endpoint'] = $_POST['url_endpoint'];
            $data['api_id'] = $apidoc->id;
            $data['api_method'] = $_POST['http_method'];
            $data['action_verb'] = "inserted";

            return view("apidoc.add_successful", $data);
        }
        catch (\Exception $e)
        {
            $data = array();
            $data['error_message'] = $e->getMessage();
            return view("apidoc.add_failed", $data);
        }
    }


    public function update(Request $request)
    {

        $api_id = $_POST['api_id'];
        $apidoc = new apidoc();
        //$apidoc = new apidoc();
        $apidoc = $apidoc->find($api_id);





        $apidoc->name = $_POST['name'];
        $apidoc->description = $_POST['description'];
        $apidoc->category = $_POST['category'];

        $apidoc->api_endpoint = $_POST['url_endpoint'];
        $apidoc->alias = $_POST['alias'];

        $apidoc->method = $_POST['http_method'];
        $apidoc->output_format = $_POST['output_type'];
        $apidoc->json_example_success = $_POST['json_success'];
        $apidoc->example_call_construct = $_POST['example_call_construct'];

        $json_api_params = $this->processApiParamsFromForm($_POST['param_name']);
        $apidoc->json_parameters_needed = $json_api_params;

        $json_exceptions = $this->processApiExceptionsFromForm($_POST['exception_name']);
        $apidoc->json_exceptions = $json_exceptions;

        $json_codeexamples = $this->processApiCodeExamplesFromForm($request->input('code_example_code'));
        $apidoc->json_example_code = $json_codeexamples;



        try {
            $apidoc->save();

            $data = array();
            $data['category'] = $_POST['category'];
            $data['url_endpoint'] = $_POST['url_endpoint'];
            $data['api_id'] = $api_id;
            $data['api_method'] = $_POST['http_method'];
            $data['action_verb'] = "updated";

            return view("apidoc.add_successful", $data);
        }
        catch (\Exception $e)
        {
            $data = array();
            $data['error_message'] = $e->getMessage();
            return view("apidoc.add_failed", $data);
        }



    }


}
