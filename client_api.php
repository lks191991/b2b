<?php
ini_set('max_execution_time', 0);
ini_set("display_errors",0);
ini_set('error_reporting',0);
ini_set('max_input_vars', 20000);
if (isset($_SERVER['HTTP_ORIGIN'])) {
   header("Access-Control-Allow-Origin:".$_SERVER['HTTP_ORIGIN']);
   header('Access-Control-Allow-Credentials: true');
   header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:".$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']);
     }
$common_class_url = "../classes/";
$db_url = "../config/";
require_once($db_url."general.php");  
require_once($common_class_url."class_common.php");
require_once($common_class_url."class_crm_api.php");
if (!function_exists('getallheaders')) { 
        function getallheaders() { 
            foreach($_SERVER as $key=>$value) { 
                if (substr($key,0,5)=="HTTPS_") { 
                    $key=str_replace(" ","-",ucwords(strtolower(str_replace("_"," ",substr($key,5))))); 
                    $out[$key]=$value; 
                }else{ 
                    $out[$key]=$value; 
        } 
            } 
            return $out; 
        } 
} 
$pvalues = $headers =  $val1 = $val2 = array();
$headers = getallheaders();
$jsondata['status'] ="0";
$val1hd =  $val2hd  =  $val3hd  = $val4hd = "";
$jsondata['message'] = 'Parameter Missing';
$jsondata['result'] = array();
//print_r($headers);
$pvalues_ar = array();
$pvalues_ar = $_POST;
$pvalues = new stdClass();
foreach($pvalues_ar as $key => $value)
{
    $pvalues->$key = $value;
}
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json);
//if(isset($headers['HTTP_API_KEY']))
//	$header['Api-Key'] = $header['HTTP_API_KEY'];
//print_r($headers);

	$ap_ty = "2";
	$file_name = "";
	//$path_request = "/home/wadigit/public_html/waapi";
	$path_media = "/home/wajscor/public_html/waapi/media/";
	// $fp = fopen($path.'request/'.$file_name, 'w');
	// fwrite($fp, json_encode($data));
	// fclose($fp);	
	$log_values = $data;
	//unset($log_values->base64File);
	$user_action = $_REQUEST['at'];  
if((isset($user_action)))
{
	// if(($headers['Api-Key'] != '4556678hgfnbvc0asdiasjo23u90u4239q08ue98jkkmb45465575Sdcxszfzv'))
	// {
	// 	$jsondata['status'] ="0";
	// 	$jsondata['msg'] = 'Invalid credential';
	// 	$jsondata['data'] = array();
	// }
	//else
	if((isset($user_action)))
	{
		@extract($_POST);
		$status = 0;
		$msg = "Invalid Request ";
		$sdata = array();
		//$common_obj->fun_app_log($ap_ty,$user_action,json_encode($data),"","","");
		
		if($user_action == 'incoming')
		{
			$user_key = $_REQUEST['uk'];
			
			$msg_ar = json_decode($pvalues->jsonData);
			if((strtolower($msg_ar->evt_message) == 'file_attached') && ($user_key != ''))
			{
				$read_incoming = $wa_status = 0;
				$read_incoming = $crm_api_obj->fun_get_user_value("u_wa_enable_incoming","","u_code = '".$user_key."'");
				//$wa_status = $crm_api_obj->fun_get_user_value("u_wa_status","","u_code = '".$user_key."'");
				if(($read_incoming == '1'))
				{
					$rec_no = $crm_api_obj->fun_get_user_value("u_wa_no","","u_code = '".$user_key."'");
					$sender_ar_ar_m = $sender_ar_ar = $sender_ar = array();
					$sender_ar = explode(":",$msg_ar->event->Info->Sender);
					$sender_ar_ar_m = explode("@",$sender_ar['0']);
					$sender_ar_ar = explode(":",$sender_ar_ar_m['0']);
					$incoming_msg_ar = array();
					$sender_mobile = 
					$sender_mobile = substr($sender_ar_ar['0'],2);
					$incoming_msg_ar['receiver_mobile_no'] = $rec_no;
					$incoming_msg_ar['sender_no'] = $sender_mobile;
					$incoming_msg_ar['group_id'] = $msg_ar->event->Info->Chat;
					$incoming_msg_ar['sender_name'] = $msg_ar->event->Info->PushName;
					$incoming_msg_ar['message'] = "File_Attachment";
					
					if($incoming_msg_ar['message']  != '')
					{
						$status = 1;
						$msg = "Success";
						$sdata = $incoming_msg_ar;
						$crm_api_obj->fun_save_incoming($user_key,$incoming_msg_ar);
						$url =  $crm_api_obj->fun_get_user_value("u_wa_incoming_url","","u_code = '".$user_key."'");
						if($url != '')
							$common_obj->fun_curl($url,$incoming_msg_ar);
					}
					else
					{
						$status = 0;
						$msg = "Unable to read msg";
						$sdata = array();
						$common_obj->fun_app_log($ap_ty,$user_action,$pvalues->jsonData,$user_key,"",$msg_ar->type." ".$read_incoming,$pvalues->lng,$pvalues->lat);	
					}
				}
			}
			elseif((strtolower($msg_ar->type) == 'message') && ($user_key != ''))
			{
				$read_incoming = $wa_status = 0;
				$read_incoming = $crm_api_obj->fun_get_user_value("u_wa_enable_incoming","","u_code = '".$user_key."'");
				//$wa_status = $crm_api_obj->fun_get_user_value("u_wa_status","","u_code = '".$user_key."'");
				if(($read_incoming == '1'))
				{
					$rec_no = $crm_api_obj->fun_get_user_value("u_wa_no","","u_code = '".$user_key."'");
					$sender_ar_ar = $sender_ar = array();
					$sender_ar = explode(".",$msg_ar->event->Info->Sender);
					$sender_ar_ar_m = explode("@",$sender_ar['0']);
					$sender_ar_ar = explode(":",$sender_ar_ar_m['0']);
					$incoming_msg_ar = array();
					$sender_mobile = 
					$sender_mobile = substr($sender_ar_ar['0'],2);
					$incoming_msg_ar['receiver_mobile_no'] = $rec_no;
					$incoming_msg_ar['sender_no'] = $sender_mobile;
					$incoming_msg_ar['group_id'] = $msg_ar->event->Info->Chat;
					$incoming_msg_ar['sender_name'] = $msg_ar->event->Info->PushName;
					$incoming_msg_ar['message'] = $msg_ar->event->Message->conversation;
					if($incoming_msg_ar['message'] == '')
						$incoming_msg_ar['message'] = $msg_ar->event->Message->extendedTextMessage->text;
					if($incoming_msg_ar['message'] == '')
						$incoming_msg_ar['message'] = $msg_ar->event->RawMessage->buttonsResponseMessage->Response->SelectedDisplayText;
					if($incoming_msg_ar['message'] == '')
						$incoming_msg_ar['message'] = $msg_ar->event->RawMessage->templateButtonReplyMessage->selectedDisplayText;
					if($incoming_msg_ar['message'] == '')
						$incoming_msg_ar['message'] = $msg_ar->event->RawMessage->ephemeralMessage->message->buttonsResponseMessage->Response->SelectedDisplayText;
					
					if($incoming_msg_ar['message']  != '')
					{
						$status = 1;
						$msg = "Success";
						$sdata = $incoming_msg_ar;
						$crm_api_obj->fun_save_incoming($user_key,$incoming_msg_ar);
						$url =  $crm_api_obj->fun_get_user_value("u_wa_incoming_url","","u_code = '".$user_key."'");
						if($url != '')
							$common_obj->fun_curl($url,$incoming_msg_ar);
						$common_obj->fun_app_log($ap_ty,$user_action,json_encode($incoming_msg_ar),$user_key,"",$url." ".$read_incoming,$pvalues->lng,$pvalues->lat);	
					}
					else
					{
						$status = 0;
						$msg = "Unable to read msg";
						$sdata = array();
						$common_obj->fun_app_log($ap_ty,$user_action,$pvalues->jsonData,$user_key,"",$headers['Api-Key']." ".$read_incoming,$pvalues->lng,$pvalues->lat);	
					}
				}
			}
			
		}
		elseif(($user_action == 'create_log')) 
		{
			$common_obj->fun_app_log($ap_ty,$user_action,json_encode($log_values).json_encode($_REQUEST).json_encode($_FILE),$pvalues->userEmail,"",$headers['Api-Key']);
		}  
		elseif(($user_action == 'sheet_activate')) 
		{
			$common_obj->fun_app_log($ap_ty,$user_action,json_encode($pvalues),$pvalues->userEmail,"",$headers['Api-Key']);
		}
		elseif($user_action == 'create_wa') // Send WA Message
		{
			//{"status":200,"message":"success","result":{"id":6426854074520061492,"groupId":6426854074520061492,"creationTime":"2022-09-24T12:19:56.775+0000"}}
			// $fun_data =  array();
			$msg ="Please Enter Correct Value";	
			$vemail = "";
			$status = 1;
			$ap_ty = "2";
			$file_name = "";
			
			$user_data = $crm_api_obj->fun_user_data("0",$data->username,$data->password);
		
			if(($user_data["id"] > 0) && ($user_data['wa_plan_status'] == '1'))
			{
				if($data->base64File != '')
				{
					$unique_no = $common_obj->fun_generate_unique_no("7",$user_data["access_code"]."_","_".date('Y_m_d_h_i_s'),1,0);
					$file_name = $unique_no.'.json';
					$file_name = str_replace(" ","_",$file_name);
					$fp = fopen($path_media.$file_name, 'w');
					fwrite($fp, json_encode($data->base64File));
					fclose($fp);
				}
			}
			$status = "200";
			$array_sdata = $sdata = array();
			$msg_type = $data->message_type;
			$array_sdata = $crm_api_obj->fun_create_whatsapp($msg_type,$data,$file_name);
			$status = $array_sdata['status'];
			$msg = $array_sdata['msg'];
			$sdata = $array_sdata['data'];	
			//$sdata = $fun_data['data'];		
			
		}
		elseif($_REQUEST['at'] == 'check_js_de') // Register Function
		{
		
			// sheetId:qwejqojwlenldncdn
			// userEmail:Shobhit.jhalani@gmail.com
			@extract($pvalues);
			$fun_data =  array();
			$msg ="Please Enter Correct Value";	
			$vemail = "";
			$status = 0;
			$fun_data = $crm_api_obj->fun_check_js_data_extractor($pvalues);
			echo trim($fun_data);
			exit;
		
		}
		elseif($_REQUEST['at'] == 'activate_js_de') // Register Function
		{
		
			// sheetId:qwejqojwlenldncdn
			// userEmail:Shobhit.jhalani@gmail.com
			@extract($pvalues);
			$fun_data =  array();
			$msg ="Please Enter Correct Value";	
			$vemail = "";
			$status = 0;
			$fun_data = $crm_api_obj->fun_activate_js_data_extractor($pvalues);
			echo trim($fun_data);
			exit;
		
		}
		elseif($_REQUEST['at'] == 'deactivate_js_de') // Register Function
		{
		
			// sheetId:qwejqojwlenldncdn
			// userEmail:Shobhit.jhalani@gmail.com
			@extract($pvalues);
			$fun_data =  array();
			$msg ="Please Enter Correct Value";	
			$vemail = "";
			$status = 0;
			$fun_data = $crm_api_obj->fun_deactivate_js_data_extractor($pvalues);
			echo trim($fun_data);
			exit;
		
		}
		if($user_action == 'create_wa_test') // Send WA Message
		{
			//{"status":200,"message":"success","result":{"id":6426854074520061492,"groupId":6426854074520061492,"creationTime":"2022-09-24T12:19:56.775+0000"}}
			// $fun_data =  array();
			$msg ="Please Enter Correct Value";	
			$vemail = "";
			$status = 1;
			$ap_ty = "2";
			$file_name = "";
			$user_data = $crm_api_obj->fun_user_data("0",$data->username,$data->password);
			if(($user_data["id"] > 0) && ($user_data['wa_plan_status'] == '1'))
			{
				if($data->base64File != '')
				{
					$file_name = $user_data["access_code"]."_".date('Y_m_d_h_i_s').'.json';
					$file_name = str_replace(" ","_",$file_name);
					$fp = fopen($path_media.$file_name, 'w');
					fwrite($fp, json_encode($data->base64File));
					fclose($fp);
				}
			}
			$status = "200";
			$array_sdata = $sdata = array();
			$msg_type = "1";
			$array_sdata = $crm_api_obj->fun_create_whatsapp_test($msg_type,$data,$file_name);
			$status = $array_sdata['status'];
			$msg = $array_sdata['msg'];
			$sdata = $array_sdata['data'];	
			//$sdata = $fun_data['data'];		
			
		}
		if($user_action == 'create_wa_reply') // Send WA Message
		{
			//{"status":200,"message":"success","result":{"id":6426854074520061492,"groupId":6426854074520061492,"creationTime":"2022-09-24T12:19:56.775+0000"}}
			// $fun_data =  array();
			$msg ="Please Enter Correct Value";	
			$vemail = "";
			$status = 1;
			$ap_ty = "2";
			$file_name = "";
			$user_data = $crm_api_obj->fun_user_data("0",$data->username,$data->password);
			if(($user_data["id"] > 0) && ($user_data['wa_plan_status'] == '1'))
			{
				if($data->base64File != '')
				{
					$file_name = $user_data["access_code"]."_".date('Y_m_d_h_i_s').'.json';
					$file_name = str_replace(" ","_",$file_name);
					$fp = fopen($path_media.$file_name, 'w');
					fwrite($fp, json_encode($data->base64File));
					fclose($fp);
				}
			}
			$status = "200";
			$array_sdata = $sdata = array();
			$msg_type = "1";
			$array_sdata = $crm_api_obj->fun_create_whatsapp($msg_type,$data,$file_name);
			$status = $array_sdata['status'];
			$msg = $array_sdata['msg'];
			$sdata = $array_sdata['data'];	
			//$sdata = $fun_data['data'];		
			
		}
		if($user_action == 'create_wa_reply_all') // Send WA Message
		{
			//{"status":200,"message":"success","result":{"id":6426854074520061492,"groupId":6426854074520061492,"creationTime":"2022-09-24T12:19:56.775+0000"}}
			// $fun_data =  array();
			$msg ="Please Enter Correct Value";	
			$vemail = "";
			$status = 1;
			$ap_ty = "2";
			$file_name = "";
			$user_data = $crm_api_obj->fun_user_data("0",$data->username,$data->password);
			if(($user_data["id"] > 0) && ($user_data['wa_plan_status'] == '1'))
			{
				if($data->base64File != '')
				{
					$file_name = $user_data["access_code"]."_".date('Y_m_d_h_i_s').'.json';
					$file_name = str_replace(" ","_",$file_name);
					$fp = fopen($path_media.$file_name, 'w');
					fwrite($fp, json_encode($data->base64File));
					fclose($fp);
				}
			}
			$status = "200";
			$array_sdata = $sdata = array();
			$msg_type = "3";
			$array_sdata = $crm_api_obj->fun_create_whatsapp_reply($msg_type,$data,$file_name);
			$status = $array_sdata['status'];
			$msg = $array_sdata['msg'];
			$sdata = $array_sdata['data'];	
			//$sdata = $fun_data['data'];		
			
		}
		elseif($user_action == 'create_group') // Latest Products
		{
			$sdata = array();
			//$featured_products = $frontend_obj->fun_get_products_index("2","","10","","1");
			$sdata = array();
			
			$sdata = $crm_api_obj->fun_create_group("2",$data);
			$msg = $sdata['message'];
			$status = $sdata['status'];
		}
		elseif($user_action == 'update_profile') // Update Profile
		{
			
			
		}
		elseif($user_action == 'get_group') // get Group
		{
			
			$sdata = array();
			$sdata = array();
			
			$sdata = $crm_api_obj->fun_get_group("3",$data);
			$msg = $sdata['message'];
			$status = $sdata['status'];
		}
		elseif($user_action == 'update_group') // Update Group
		{
			
			$sdata = array();
			$sdata = array();
			
			$sdata = $crm_api_obj->fun_update_group("4",$data);
			$msg = $sdata['message'];
			$status = $sdata['status'];
		}
		elseif($user_action == 'sheet_activate') // Register Function
		{
			// sheetId:qwejqojwlenldncdn
			// userEmail:Shobhit.jhalani@gmail.com
			@extract($pvalues);
			$fun_data =  array();
			$msg ="Please Enter Correct Value";	
			$vemail = "";
			$status = 1;
			
			$vemail = filter_var($pvalues->userEmail, FILTER_VALIDATE_EMAIL);
			if(($vemail == ''))
			{
				$status = 1001;
				$msg ="Invalid Email ID";	
			}
			else
			{
				//$status = 1001;
				$fun_data = $crm_api_obj->fun_register_sheet($pvalues);
				$status = $fun_data['status'];
				$msg = $fun_data['msg'];
				$sdata = $fun_data['data'];		
			}
		}
		elseif($user_action == 'sheet_status') // Register Function
		{
			// sheetId:qwejqojwlenldncdn
			// userEmail:Shobhit.jhalani@gmail.com
			@extract($pvalues);
			$fun_data =  array();
			$msg ="Please Enter Correct Value";	
			$vemail = "";
			$status = 0;
			$vemail = filter_var($pvalues->userEmail, FILTER_VALIDATE_EMAIL);
			if(($vemail == ''))
			{
				$status = 1001;
				$msg ="Unable to read Email ID";	
			}
			else
			{
				if($pvalues->sheetId != '')
				{
					$fun_data = $crm_api_obj->fun_sheet_status($pvalues);
					$status = $fun_data['status'];
					$msg = $fun_data['msg'];
					$sdata = $fun_data['data'];		
				}
			}
		}
			
		
		$jsondata['status'] =$status;
		$jsondata['message'] = $msg;
		$jsondata['result'] = $sdata;
		
		if($val1hd != '')
		{
			$jsondata[$val1hd] = $val1;
		}
		if($val2hd != '')
		{
			$jsondata[$val2hd] = $val2;
		}
		if($val3hd != '')
		{
			$jsondata[$val3hd] = $val3;
		}
		
	}
}
//{"status":200,"message":"success","result":{"id":7814549361133766796,"groupId":7814549361133766796,"creationTime":"2022-04-04T11:49:48.130+0000"}}


echo json_encode($jsondata);
exit;

"ALTER TABLE `voucher_activity` ADD `isRayna` BOOLEAN NOT NULL DEFAULT FALSE AFTER `org_refund_trans_amt`, ADD `rayna_bookingId` INT NOT NULL DEFAULT '0' AFTER `isRayna`, ADD `rayna_booking_details` JSON NOT NULL AFTER `rayna_bookingId`;";

?>
