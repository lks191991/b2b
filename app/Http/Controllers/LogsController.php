<?php

namespace App\Http\Controllers;

use App\Models\RaynaBookingLog;
use Illuminate\Http\Request;
use DB;
use Image;
use App\Models\TicketDownloadLog;
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

        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);

       
        return view('logs.index', compact('records'));
    }

    public function ticketDownloadLogs(Request $request)
    {
        $data = $request->all();
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
        $query = TicketDownloadLog::with(['user', 'voucher', 'voucherActivity']);
        if (isset($data['from_date']) && !empty($data['from_date']) &&  isset($data['to_date']) && !empty($data['to_date'])) {
			$startDate = $data['from_date'];
			$endDate =  $data['to_date'];
				 $query->whereDate('created_at', '>=', $startDate);
				 $query->whereDate('created_at', '<=', $endDate);
				
		}

        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);

       
        return view('logs.ticket_download', compact('records'));
    }
   
}
