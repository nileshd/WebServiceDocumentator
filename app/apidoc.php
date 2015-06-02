<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class apidoc extends Model {

    protected $table = 'apidocs';

    public function getDates()
    {
        return ['updated_at'];
    }

}
