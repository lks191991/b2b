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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Validator;
use Hash;
use DB;
use Image;
use App\Http\Resources\Company as CompanyResource;
use jeremykenedy\LaravelRoles\Models\Role;

class RegisterController extends BaseController
{
    
    /**
     * Companylist api
     *
     * @return \Illuminate\Http\Response
     */
    public function companylist()
    {
        //$companies = Company::all(); 
        //$companies = Company::select('name AS title', 'id')->where(['status' => 1])->orderBy('title', 'ASC')->get(); 
        //pr($companies); die;  
        $companies=  DB::table('companies')
           ->select('id','name AS title')
           ->where(['status' => 1])->orderBy('title', 'ASC')->get();
        return $this->sendResponse($companies, 'Companies retrieved successfully.');

    }
    public function teamIdList()
    {
        $teams = TeamId::select('team_id')->orderBy('team_id', 'ASC')->get(); 
        
        return $this->sendResponse($teams, 'Teams retrieved successfully.');

    }
    
    
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $options['allow_img_size'] = 10;
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|sanitizeScripts',
            'lname' => 'nullable|max:255|sanitizeScripts',
            //'phone' => 'nullable|max:20|sanitizeScripts',
            'job_title' => 'nullable|max:255|sanitizeScripts',
            'company_id' => 'required',
            'delivery_address' => 'nullable|sanitizeScripts',
            'delivery_address2' => 'nullable|sanitizeScripts',
            'city' => 'nullable|sanitizeScripts',
            'country' => 'nullable|sanitizeScripts',
            'postcode' => 'nullable|max:20|sanitizeScripts',
            'email' => 'required|max:255|sanitizeScripts|email|unique:users|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            //'password' => 'required|max:255|sanitizeScripts|min:8|regex:/^(?=.*\d)(?=.*[A-Z])[\w\W]{8,}$/',
           'password' => 'required|max:255|sanitizeScripts|min:8',
            'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024),
            //'c_password' => 'required|same:password',
        ],
        [
            'name.sanitize_scripts' => 'Invalid value entered for Name field.',
            'company_id.sanitize_scripts' => 'Invalid value entered for Name field.',
            'lname.sanitize_scripts' => 'Invalid value entered for Last Name field.',
            'lname.required' => 'Last name required.',
            'company_id.required' => 'Organisation Name required.',
            'delivery_address2.sanitize_scripts' => 'Invalid value entered for delivery address 2.',
            'job_title.sanitize_scripts' => 'Invalid value entered for Job Title field.',
            'delivery_address.sanitize_scripts' => 'Invalid value entered for Delivery Address field.',
            'city.sanitize_scripts' => 'Invalid value entered for city field.',
            'country.sanitize_scripts' => 'Invalid value entered for country field.',
            'postcode.sanitize_scripts' => 'Invalid value entered for Postcode field.',
            'email.sanitize_scripts' => 'Invalid value entered for Email Address field.',
            'email.regex' => 'The email must be a valid email address.',
            'password.sanitize_scripts' => 'Invalid value entered for Password field.',
            'password.regex' => "Password contains At least one uppercase, At least one digit and At least it should have 8 characters long."
        ]);
   
        if($validator->fails()){
           //return $this->sendError('Validation Error.', $validator->errors()); 
           $errors = $validator->errors();
           $errorMsg = '';
           if($errors->first('name'))
                $errorMsg = $errors->first('name');
           elseif($errors->first('phone'))
               $errorMsg = $errors->first('phone'); 
           elseif($errors->first('job_title'))
               $errorMsg = $errors->first('job_title'); 
           elseif($errors->first('delivery_address'))
               $errorMsg = $errors->first('delivery_address'); 
           elseif($errors->first('postcode'))
               $errorMsg = $errors->first('postcode'); 
           elseif($errors->first('email'))
               $errorMsg = $errors->first('email');               
           elseif($errors->first('password'))
               $errorMsg = $errors->first('password'); 
           elseif($errors->first('image'))
               $errorMsg = $errors->first('image');       

           return $this->sendError($errorMsg); 
           
        }

        $input = $request->all();
        /** Below code for save image **/
		$destinationPath = public_path('/uploads/users/');
		$newName = '';
		if ($request->hasFile('image')) {
           
			$fileName = $input['image']->getClientOriginalName();
			$file = request()->file('image');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			
			$file->move($destinationPath, $newName);
			
			//$user_config = json_decode($options['user'],true);
			
			$img = Image::make(public_path('/uploads/users/'.$newName));
						
            $img->resize(100, 100, function($constraint) {
				$constraint->aspectRatio();
			});
			

			$img->save(public_path('/uploads/users/thumb/'.$newName));
		}
        $team_id = '';
        $input['image'] = $newName;
        $input['password'] = bcrypt($input['password']);
        $input['role_id'] = '4';
        $input['is_active'] = 1;
        $input['job_title'] = $input['job_title'];
        $input['delivery_address'] = $input['delivery_address'];
        $input['delivery_address2'] = $input['delivery_address2'];
        $input['city'] = $input['city'];
        $input['country'] = $input['country'];
        $input['postcode'] = $input['postcode'];
        
        if (!empty($request->input('team_id'))) {
            $team = TeamId::where('team_id', $request->input('team_id'))->first();
            if (isset($team)) {
                $team_id = $team->id;
            }
        }

        $input['team_id'] = $team_id;

        if($input['company_id']!=='')
        {
            $company = Company::where("name",$input['company_id'])->first();
            if(isset($company))
            {
                $companyId = $company->id;
            }
            // else
            // {
            //     $company = new Company();
            //     $company->name = $input['company_id'];
            //     $company->save();
            //     $companyId = $company->id;
            // }

            $input['company_id'] = $companyId;
        }

        //pr($input); die;
        $user = User::with('team')->create($input);
        $user->attachRole(4);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        $success['lname'] =  $user->lname;
        $success['company'] =  $user->company->name;
       if(isset($user->team)){  $success['team_id'] =  $user->team['team_id'];}else { $success['team_id'] =  '';};
        $success['job_title'] =  $user->job_title;
        $success['delivery_address'] =  $user->delivery_address;
        $success['delivery_address2'] =  $user->delivery_address2;
        $success['city'] =  $user->city;
        $success['country'] =  $user->country;
        $success['postcode'] =  $user->postcode;
        $success['name'] =  $user->name;
        $success['image'] =  url('/uploads/users/'.$user->image);
        $success['email'] =  $user->email;
        
        Mail::to($input['email'],'Registration Email')->send(new sendAPIRegisterToTechnicianMailable($input)); 

        $admin = User::where("role_id",1)->first();
        $tm = User::where("id",$user->company->owner)->first();
        $emails = [$admin->email, $tm->email];
        Mail::to($emails,'New Technician Registered')->send(new RegisterToTechnicianAdminMailable($success));

        return $this->sendResponse($success, 'User has been registered successfully.');
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255|sanitizeScripts|email',
            'password' => 'required|max:255|sanitizeScripts',

        ],
        [
            'email.sanitize_scripts' => 'Invalid value entered for Email Address field.',
            'password.sanitize_scripts' => 'Invalid value entered for Password field.'
        ]);
   
        if($validator->fails()){
           //return $this->sendError('Validation Error.', $validator->errors()); 
           $errors = $validator->errors();
           $errorMsg = '';
           if($errors->first('email'))
               $errorMsg = $errors->first('email');           
           elseif($errors->first('password'))
               $errorMsg = $errors->first('password');  

            //echo $errorMsg;
           //return $this->sendError('Please enter login details correctly.');  
           return $this->sendError($errorMsg);        
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1, 'role_id' => 4])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            $success['name'] =  $user->name;
            $success['email'] =  $user->email;
   
            return $this->sendResponse($success, 'User login successfully.');
        }elseif(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            return $this->sendError('Oops!  Your account is inactive.');
        }else{ 
            return $this->sendError('Invalid login details.');
        } 
    }

    /**
     * forgot password api
     *
     * @return \Illuminate\Http\Response
     */
    public function forgotpassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255|sanitizeScripts|email'
        ],
        [
            'email.sanitize_scripts' => 'Invalid value entered for Email Address field.'
        ]);
   
        if($validator->fails()){
           $errors = $validator->errors();
           $errorMsg = '';
           if($errors->first('email'))
               $errorMsg = $errors->first('email');           

           return $this->sendError($errorMsg);        
        }

        $data = $request->all();
        $admin_details = DB::table('users')->where('email', $data['email'])->get();
		//print_r($admin_details); die('test');
		if(isset($admin_details[0]->id) && !empty($admin_details[0]->id)) {

            $token = Str::random(60);
            $update_pass = DB::table('users')->where('id', $admin_details[0]->id)->update(['remember_token' => $token]);

            $success = (object)array();
            $success->email = $request->email;
            //if(Auth::attempt(['email' => $request->email]))
            /*if(Auth::attempt(['email' => $data['email']])){
                $user = Auth::user(); 
                $success['token'] =  $user->createToken('MyApp')->accessToken; 
                $success['name'] =  $user->name;
                $success['email'] =  $user->email;
            }*/
            Mail::to($data['email'],'Password Reset Link')->send(new sendForgotPasswordToUserMailable($admin_details[0], $token));

            return $this->sendResponse($success, 'Success! password reset link has been sent to your email.');
           
		} else {
            return $this->sendError('Email does not exists.');
		}
    }

    
	
	/**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function emailValidat(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255|sanitizeScripts|email',
        ],
        [
            'email.sanitize_scripts' => 'Invalid value entered for Email Address field.',
            'password.sanitize_scripts' => 'Invalid value entered for Password field.'
        ]);
   
        if($validator->fails()){
           $errors = $validator->errors();
           $errorMsg = '';
           if($errors->first('email'))
               $errorMsg = $errors->first('email');           
           return $this->sendError($errorMsg);        
        }

		$users = User::where('email', $request->email)->count();
		if($users > 0)
		{
			$errorMsg = 'This email id is already registered.';
			return $this->sendError($errorMsg);
		}
		else
		{
			$success = [];
			 return $this->sendResponse($success, '');
		}

        
    }

    public function teamidValidate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'team_id' => 'required',
            'company_id' => 'required',
        ],
        [
        ]);
   
        if($validator->fails()){
           $errors = $validator->errors();
           $errorMsg = '';
           if($errors->first('team_id'))
               $errorMsg = $errors->first('team_id');   
           if($errors->first('company_id'))
               $errorMsg = $errors->first('company_id');        
           return $this->sendError($errorMsg);        
        }

		$users = TeamId::where('team_id', $request->team_id)->where('company_id', $request->company_id)->count();
		if($users== 0)
		{
			$errorMsg = 'Invalid team ID';
			return $this->sendError($errorMsg);
		}
		else
		{
			$success = [];
			 return $this->sendResponse($success, '');
		}

        
    }

    
}