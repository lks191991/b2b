<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Mail\sendAPIRegisterToTechnicianMailable;
use App\Mail\sendForgotPasswordToUserMailable;
use App\Mail\RegisterToTechnicianAdminMailable;
use App\Models\User;
use App\Models\Company;
use App\Models\TeamId;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Validator;
use Hash;
use DB;
use Image;
use App\Http\Resources\Company as CompanyResource;
use jeremykenedy\LaravelRoles\Models\Role;

class SyncMainDataController extends BaseController
{
    
    /**
     * Companylist api
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        //$companies = Company::all(); 
        //$companies = Company::select('name AS title', 'id')->where(['status' => 1])->orderBy('title', 'ASC')->get(); 
        //pr($companies); die;  
        $companies=  DB::table('companies')
           ->select('id','name AS title')
           ->where(['status' => 1])->orderBy('title', 'ASC')->get();
        return $this->sendResponse($companies, 'Companies retrieved successfully.');

    }

}