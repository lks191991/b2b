<?php

namespace App\Http\Controllers;

use App\Models\CsvSearch;
use Illuminate\Http\Request;
use DB;


class CsvSearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$records = [];
        $data = $request->all();
        $perPage = 10;
		if(!empty($data)){
        $query = CsvSearch::where('id', '!=', '');
        if (isset($data['name']) && !empty($data['name'])) {
            $query->where('name', 'like', '%' . $data['name'] . '%');
        }
       if (isset($data['email']) && !empty($data['email'])) {
            $query->where('email', 'like', '%' . $data['email'] . '%');
        }
       
        if (isset($data['company']) && !empty($data['company'])) {
			$query->where('company', 'like', '%' . $data['company'] . '%');
        }
		
		 if (isset($data['mobile']) && !empty($data['mobile'])) {
            $query->where('mobile', 'like', '%' . $data['mobile'] . '%');
        }
		
		if (isset($data['city']) && !empty($data['city'])) {
			$query->where('city', 'like', '%' . $data['city'] . '%');
        }

		if (isset($data['state']) && !empty($data['state'])) {
			$query->where('state', 'like', '%' . $data['state'] . '%');
        }
		
        $records = $query->orderBy('name', 'ASC')->paginate($perPage);
		}

        return view('csvsearch.index', compact('records'));
    }


   	
}
