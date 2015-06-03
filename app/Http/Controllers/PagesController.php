<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\pages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller {

    public function add()
    {


        $categories = $this->lookupManager->getCategories();

        $data = array();
        $data['categories'] = $categories;
        return view("pages.add", $data);

    }



    public function insert(Request $request)
    {
        $page = new pages();
        $page->title = $_POST['title'];
        $page->description = $_POST['page_content'];
        $page->category = $_POST['category'];


        try {
            $page->save();

            $data = array();
            $data['title'] = $_POST['title'];
            $data['page_id'] = $page->id;
            $data['action_verb'] = "inserted";
            $data['category'] = $_POST['category'];

            return view("pages.add_successful", $data);
        }
        catch (\Exception $e)
        {
            $data = array();
            $data['error_message'] = $e->getMessage();
            return view("apidoc.add_failed", $data);
        }
    }


    public function getAll()
    {


        $apiList =   DB::table('pages')->orderBy('title', 'asc')->get();

        $data = array();
        $data['pages'] = $apiList;
        return view("pages.list", $data);
    }


    public function getByCategory($category)
    {
        $apiList =   DB::table('pages')->where('category', '=', $category)->orderBy('title', 'asc')->get();


        $data = array();
        $data['pages'] = $apiList;
        return view("pages.list", $data);
    }



    public function getById($id)
    {


        $pages = new pages();
        $page_details = $pages->find($id)->toArray();

        if (!$page_details)
        {
            exit("Page Not Found !");
        }

        $data = array();
        $data['page'] = $page_details;

        return view("pages.page", $data);

    }



    public function edit($id)
    {


        $pages = new pages();
        $page_details = $pages->find($id)->toArray();

        if (!$page_details)
        {
            exit("Page Not Found !");
        }


        $categories = $this->lookupManager->getCategories();


        $data = array();
        $data['page'] = $page_details;
        $data['categories'] = $categories;
        $data['page_id'] = $id;

        return view("pages.edit", $data);


    }



    public function update(Request $request)
    {
        $page_id = $_POST['page_id'];
        $page = new pages();
        $page = $page->find($page_id);

        $page->title = $_POST['title'];
        $page->description = $_POST['page_content'];
        $page->category = $_POST['category'];



        try {
            $page->save();

            $data = array();
            $data['category'] = $_POST['category'];
            $data['page_id'] = $page_id;
            $data['title'] = $_POST['title'];

            $data['page_content'] = $_POST['page_content'];
            $data['action_verb'] = " updated ";


            return view("pages.add_successful", $data);
        }
        catch (\Exception $e)
        {
            $data = array();
            $data['error_message'] = $e->getMessage();
            return view("pages.add_failed", $data);
        }



    }




}
