<?php namespace App\Http\Controllers;

use App\apidoc;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class ApiDocsController extends Controller {



    public function dashboard()
    {
        $num_apis_for_categories = DB::select('select distinct category,count(api_endpoint) as num_endpoints,max(updated_at) as last_date from apidocs GROUP by category order by num_endpoints desc');

        $num_pages_for_categories = DB::select('select distinct category,count(title) as num_pages,max(updated_at) as last_date from pages GROUP by category order by num_pages desc');

        for ($a=0;$a<count($num_apis_for_categories); $a++)
        {
            $api = $num_apis_for_categories[$a];
            $days_ago =  Carbon::createFromTimestamp(strtotime($api->last_date))->diffInDays();
            $api->days_ago = $days_ago;
            $num_apis_for_categories[$a] = $api;
        }

        $categories = array();

        for ($a=0;$a<count($num_pages_for_categories); $a++)
        {
            $page = $num_pages_for_categories[$a];

            $categories[$page->category] = $page->num_pages;
        }




        $data = array();
        $data['num_apis_for_categories'] = $num_apis_for_categories;
        $data['num_pages_for_categories'] = $categories;


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
            exit("Sorry API does not exist");
        }


        $parameters = ($api_details['json_parameters_needed']!="") ? json_decode($api_details['json_parameters_needed'],true) : array();
        $exceptions = ($api_details['json_exceptions']!="") ? json_decode($api_details['json_exceptions'],true) : array();
        $code_examples = ($api_details['json_example_code']!="") ? json_decode($api_details['json_example_code'],true) : array();

        $related_links = ($api_details['json_links']!="") ? json_decode($api_details['json_links'],true) : array();




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
        $data['related_links'] = $related_links;

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
        $related_links = ($api_details['json_links']!="") ? json_decode($api_details['json_links'],true) : array();





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

        $data['related_links'] = $related_links;

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
            $item_array['name'] = Input::get('param_name')[$a];
            $item_array['type'] = Input::get('param_type')[$a];
            $item_array['required'] = Input::get('param_required')[$a];
            $item_array['desc'] = Input::get('param_description')[$a];
            $item_array['location'] = Input::get('param_location')[$a];
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


    private function processRelatedLinksFromForm($form_data_array)
    {
        $number_items = count($form_data_array);
        $return_array = array();

        if ($number_items==0) { return $return_array; }

        for($a=0;$a<$number_items;$a++)
        {
            $item_array = array();
            $item_array['url'] = addslashes($_POST['related_link'][$a]);


            if (rtrim(ltrim($item_array['url']))!="") {
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

        $apidoc->name = Input::get('name','');
        $apidoc->description = Input::get('description');
        $apidoc->category = Input::get('category');

        $apidoc->api_endpoint = Input::get('url_endpoint');
        $apidoc->alias = Input::get('alias');

        $apidoc->method = Input::get('http_method');
        $apidoc->output_format = Input::get('output_type');
        $apidoc->json_example_success = $_POST['json_success'];
        $apidoc->example_call_construct = $_POST['example_call_construct'];

        $json_api_params = $this->processApiParamsFromForm($_POST['param_name']);
        $apidoc->json_parameters_needed = $json_api_params;

        $json_exceptions = $this->processApiExceptionsFromForm($_POST['exception_name']);
        $apidoc->json_exceptions = $json_exceptions;

        $json_codeexamples = $this->processApiCodeExamplesFromForm($request->input('code_example_code'));
        $apidoc->json_example_code = $json_codeexamples;

        $json_links = $this->processRelatedLinksFromForm($request->input('related_link'));
        $apidoc->json_links = $json_links;




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



        $api_id = Input::get('api_id');
        $apidoc = new apidoc();
        //$apidoc = new apidoc();
        $apidoc = $apidoc->find($api_id);





        $apidoc->name = Input::get('name');
        $apidoc->description = Input::get('description');
        $apidoc->category = Input::get('category');

        $apidoc->api_endpoint = Input::get('url_endpoint');
        $apidoc->alias = Input::get('alias');

        $apidoc->method = Input::get('http_method');
        $apidoc->output_format = Input::get('output_type');
        $apidoc->json_example_success = Input::get('json_success');
        $apidoc->example_call_construct = Input::get('example_call_construct');

        $json_api_params = $this->processApiParamsFromForm(Input::get('param_name'));
        $apidoc->json_parameters_needed = $json_api_params;

        $json_exceptions = $this->processApiExceptionsFromForm($_POST['exception_name']);
        $apidoc->json_exceptions = $json_exceptions;

        $json_codeexamples = $this->processApiCodeExamplesFromForm($request->input('code_example_code'));
        $apidoc->json_example_code = $json_codeexamples;

        $json_links = $this->processRelatedLinksFromForm($request->input('related_link'));
        $apidoc->json_links = $json_links;


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



    public function run_ws()
    {
        $this->middleware('tidy');

        $url = Input::get("url");
        $method = Input::get("method");



        $client = new GuzzleClient([
            'base_uri' => $url,
            'timeout'  => 5.0,
        ]);


        $x = $client->get('')->getBody()->getContents();



      $y = $this->indent($x);
echo $y;
    }



    /**
     * Indents a flat JSON string to make it more human-readable.
     *
     * @param string $json The original JSON string to process.
     *
     * @return string Indented version of the original JSON string.
     */
    function indent($json) {

        $result      = '';
        $pos         = 0;
        $strLen      = strlen($json);
        $indentStr   = '  ';
        $newLine     = "\n";
        $prevChar    = '';
        $outOfQuotes = true;

        for ($i=0; $i<=$strLen; $i++) {

            // Grab the next character in the string.
            $char = substr($json, $i, 1);

            // Are we inside a quoted string?
            if ($char == '"' && $prevChar != '\\') {
                $outOfQuotes = !$outOfQuotes;

                // If this character is the end of an element,
                // output a new line and indent the next line.
            } else if(($char == '}' || $char == ']') && $outOfQuotes) {
                $result .= $newLine;
                $pos --;
                for ($j=0; $j<$pos; $j++) {
                    $result .= $indentStr;
                }
            }

            // Add the character to the result string.
            $result .= $char;

            // If the last character was the beginning of an element,
            // output a new line and indent the next line.
            if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
                $result .= $newLine;
                if ($char == '{' || $char == '[') {
                    $pos ++;
                }

                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }

            $prevChar = $char;
        }

        return $result;
    }


}
