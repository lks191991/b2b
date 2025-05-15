<?php

namespace App\Http\Controllers;

use App\Models\RaynaBookingLog;
use Illuminate\Http\Request;
use DB;
use Image;
use App\Models\TicketDownloadLog;
use App\Models\TicketLog;
class LogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function raynaBookingLogs(Request $request)
    {
        $data = $request->all();
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
        $query = RaynaBookingLog::where('id','!=', null);
        if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				 $query->whereDate('created_at', '>=', $startDate);
				 $query->whereDate('created_at', '<=', $endDate);
				
		}

        if(isset($data['v_code']) && !empty($data['v_code'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['v_code']);
			});
		}

        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);

       
        return view('logs.index', compact('records'));
    }

    public function ticketDownloadLogs(Request $request)
    {
        $data = $request->all();
        $filter = 0;
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
        $query = TicketDownloadLog::with(['user', 'voucher', 'voucherActivity']);
        if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				 $query->whereDate('created_at', '>=', $startDate);
				 $query->whereDate('created_at', '<=', $endDate);
				 $filter = 1;
		}

        if(isset($data['v_code']) && !empty($data['v_code'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['v_code']);
			});
             $filter = 1;
		}

         if(isset($data['v_option']) && !empty($data['v_option'])) {
			$query->whereHas('voucherActivity', function($q)  use($data){
				$q->where('variant_name', 'like', '%' . $data['v_option']);
			});

             $filter = 1;
		}

        if (isset($data['apid']) && !empty($data['apid'])) {
        $query->where('voucher_activity_id', $data['apid']);
         $filter = 1;
        }

         $totalRecords = $query->count();
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);

       
        return view('logs.ticket_download', compact('records','filter','totalRecords'));
    }

     public function ticketGenerateLogs(Request $request)
    {
        $data = $request->all();
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
        $query = TicketLog::with(['voucher', 'voucherActivity']);
        if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				 $query->whereDate('created_at', '>=', $startDate);
				 $query->whereDate('created_at', '<=', $endDate);
				
		}

        if(isset($data['v_code']) && !empty($data['v_code'])) {
			$query->whereHas('voucher', function($q)  use($data){
				$q->where('code', 'like', '%' . $data['v_code']);
			});
		}
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);

       
        return view('logs.ticket_generate', compact('records'));
    }
   
}
