<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Jobs\ProcessTourData;
use App\Jobs\ProcessTourOptionData;

use Illuminate\Support\Facades\Log;


class JobsController extends Controller
{
    
	public function tourJobsView(Request $request)
	{
		return view('jobs.index');
	}
	
	public function processTourJobs(Request $request)
	{
		try {
			ProcessTourData::dispatch();
			ProcessTourOptionData::dispatch();

			return response()->json(['success' => true, 'message' => 'Jobs dispatched successfully. Data will sync after 5 minutes.']);
		} catch (\Exception $e) {
			Log::error('Error dispatching jobs: ' . $e->getMessage());
			return response()->json(['success' => false, 'message' => 'Failed to dispatch jobs.']);
		}
	}

	
}
