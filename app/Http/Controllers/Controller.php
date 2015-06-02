<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\lookup;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;
    protected $lookupManager;
    protected $categories;

    public function __construct()
    {
        $this->lookupManager = new lookup();
        $this->categories = $this->lookupManager->getCategories();
    }



}
