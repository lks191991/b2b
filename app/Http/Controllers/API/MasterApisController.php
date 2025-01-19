<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use App\Models\Voucher;
use App\Models\Activity;
use App\Models\Variant;
use App\Models\ActivityVariant;
use App\Models\VoucherActivity;
use App\Models\VariantCanellation;
use App\Models\VariantPrice;
use Illuminate\Support\Facades\Auth;
use PriceHelper;
use SiteHelpers;
use Validator;
use App\Models\Ticket;
use Hash;
use DB;
use Exception;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\VariantResource;
use App\Http\Resources\ActivityVariantResource;
use Carbon\Carbon;
use App\Models\Customer;
use App\Traits\APITrate;
class MasterApisController extends BaseController
{
	use APITrate;
	public function getActivityList(Request $request)
	{
		try {
			$activity = Activity::where('status', 1)->get();
			$data = ActivityResource::collection($activity);
			$result = $this->sendResponse($data, 'Activity List featch successfully.');
		} catch (Exception $e) {
			$result = $this->sendError([], $e->getMessage());
		}

		return $result;
	}

	public function getVariantList(Request $request)
	{
		try {
			$variant = Variant::where('status', 1)->get();
			$data = VariantResource::collection($variant);
			$result = $this->sendResponse($data, 'Variant List featch successfully.');
		} catch (Exception $e) {
			$result = $this->sendError([], $e->getMessage());
		}

		return $result;
	}

	public function getActivityVariantList(Request $request)
	{
		try {
			$activityVariant = ActivityVariant::get();
			$data = ActivityVariantResource::collection($activityVariant);
			$result = $this->sendResponse($data, 'Variant List featch successfully.');
		} catch (Exception $e) {
			$result = $this->sendError([], $e->getMessage());
		}

		return $result;
	}

	public function login(Request $request)
	{
		try {
			$request->validate([
				'email' => 'required|email',
				'password' => 'required',
			]);

			$user = User::select('id', 'name', 'email', 'phone', 'role', 'password')
				->where('email', $request->email)
				->where('is_active', 1)
				->first();

			if (!$user || !Hash::check($request->password, $user->password)) {
				throw ValidationException::withMessages([
					'email' => ['The provided credentials are incorrect.'],
				]);
			}

			$token = $user->createToken('auth_token')->plainTextToken;

			// Remove password from the response
			unset($user->password);

			return $this->sendResponse([
				'user' => $user,
				'token' => $token
			], 'User logged in successfully.');
		} catch (ValidationException $e) {
			return $this->sendError($e->errors(), 'Validation Error', 422);
		} catch (Exception $e) {
			return $this->sendError([], $e->getMessage());
		}
	}


	public function createVoucher(Request $request)
{
    $validator = Validator::make($request->all(), [
        'tours' => 'required|array|min:1',
        'customer' => 'required|array|min:1',
        'agent_id' => 'required',
    ]);

    if ($validator->fails()) {
        return $this->errorResponse($validator->errors()->first(), 'Error', 203);
    }

    DB::beginTransaction();
    try {
				$tourData = $request->input('tours');
				$customerData = $request->input('customer');
				$travelFromDate = Carbon::parse($request->input('travel_from_date'));
				$travelToDate = Carbon::parse($request->input('travel_to_date'));
				$agentId = $request->input('agent_id');
				$agent = User::findOrFail($agentId);

				$customer = Customer::firstOrCreate(
					['mobile' => $customerData['phone']],
					[
						'name' => $customerData['name'] . ' ' . $customerData['lname'],
						'email' => $customerData['email']
					]
				);

				$voucher = new Voucher();
				$voucher->agent_id = $agentId;
				$voucher->zone = $agent->zone;
				$voucher->country_id = 1;
				$voucher->customer_id = $customer->id;
				$voucher->guest_name = $customerData['name'].' '.$customerData['lname'];
				$voucher->guest_email = $customerData['email'];
				$voucher->guest_phone = $customerData['phone'];
				$voucher->is_hotel = 0;
				$voucher->is_flight = 0;
				$voucher->is_activity = 1;
				$voucher->booking_date =now();
				$voucher->payment_date = now();
				$voucher->arrival_date = now();
				$voucher->travel_from_date = $travelFromDate;
				$voucher->travel_to_date = $travelToDate;
				$voucher->nof_night = 0;
				$voucher->vat_invoice = 1;
				$voucher->status = 1;
				$voucher->adults = 1;
				$voucher->childs = 0;
				$voucher->create_from = 'other';
				$voucher->save();
				$code = 'ABTB2C-' . now()->year . '-00' . $voucher->id;
				$voucher->code = $code;
				$voucher->save();


        $activityResult = $this->activitySaveInVoucher($tourData, $voucher);

        if ($activityResult['success']) {
			$vouncherData['voucher'] = [
				"code"=>$voucher->code
			];
			$vouncherData['tickets'] = $activityResult['tickets'];
            DB::commit();
            return $this->successResponse($vouncherData, $voucher->code . " Voucher created successfully.", 200);
        } else {
            DB::rollBack();
            return $this->errorResponse($activityResult['message'], 'Error', 203);
        }
     } catch (\Exception $e) {
        DB::rollBack();
        return $this->errorResponse('Something went wrong.', 'Error', 203);
    } 
}

   
public function activitySaveInVoucher($tourData, $voucher)
{
    $discount = 0;
    $voucher_id = $voucher->id;

    $startDate = $voucher->travel_from_date;
    $endDate = $voucher->travel_to_date;
    $returnData = [];

    $data = [];
    $total_activity_amount = 0;
	$tickets = [];
    if (!empty($tourData)) {
        foreach ($tourData as $tour) {
            $activity_id = $tour['activity_id'];
            $activity_variant_id = $tour['activity_variant_id'];
            $timeslot = $tour['time_slot'];
            $transfer_option = $tour['transfer_option'];
            $tour_date = $tour['tour_date'];
            $transfer_zone = 1;
            $adult = $tour['adult'] ?? 1;
            $child = $tour['child'] ?? 0;
            $infant = $tour['infant'] ?? 0;
            $pickupLocation = $tour['pickup_location'] ?? '';
            $dropoffLocation = $tour['dropoff_location'] ?? '';
            $pickupTime = isset($tour['pickup_time']) 
                ? "{$tour['pickup_time']['hour']}:{$tour['pickup_time']['minute']}:{$tour['pickup_time']['second']}" 
                : '';
            $dropoffTime = isset($tour['dropoff_time']) 
                ? "{$tour['dropoff_time']['hour']}:{$tour['dropoff_time']['minute']}:{$tour['dropoff_time']['second']}" 
                : '';

            $activityVariant = ActivityVariant::with('variant', 'activity')->find($activity_variant_id);

            if (!$activityVariant) {
                continue;
            }
			$tickets = [];
            $activity = $activityVariant->activity;
            $variant = $activityVariant->variant;

            $todayDate = date('Y-m-d');
            $tour_dt = date("Y-m-d", strtotime($tour_date));
            $priceCal = $this->getActivityPriceSaveInVoucher(
                $transfer_option,
                $activity_variant_id,
                0,
                $voucher,
                $activityVariant->ucode,
                $adult,
                $child,
                $infant,
                0,
                $tour_dt
            );

            if ($tour_dt >= $todayDate) {
                $cancellation = VariantCanellation::where('varidCode', $variant->ucode)->get();

                $data[] = [
                    'voucher_id' => $voucher_id,
                    'activity_id' => $activity_id,
                    'activity_vat' => $priceCal['activity_vat'],
                    'variant_unique_code' => $activityVariant->ucode,
                    'variant_name' => $variant->title,
                    'variant_code' => $variant->ucode,
                    'cancellation_time_data' => json_encode($cancellation),
                    'activity_entry_type' => $activity->entry_type,
                    'variant_pvt_TFRS' => $variant->pvt_TFRS,
                    'variant_pick_up_required' => $variant->pick_up_required,
                    'activity_title' => $activity->title,
                    'variant_zones' => $variant->zones,
                    'variant_pvt_TFRS_text' => $variant->pvt_TFRS_text,
                    'transfer_option' => $transfer_option,
                    'tour_date' => $tour_dt,
                    'pvt_traf_val_with_markup' => $priceCal['pvt_traf_val_with_markup'],
                    'transfer_zone' => '',
                    'zonevalprice_without_markup' => $priceCal['zonevalprice_without_markup'],
                    'adult' => $adult,
                    'child' => $child,
                    'infant' => $infant,
                    'markup_p_ticket_only' => $priceCal['markup_p_ticket_only'],
                    'markup_p_sic_transfer' => $priceCal['markup_p_sic_transfer'],
                    'markup_p_pvt_transfer' => $priceCal['markup_p_pvt_transfer'],
                    'adultPrice' => $priceCal['adultPrice'],
                    'childPrice' => $priceCal['childPrice'],
                    'infPrice' => $priceCal['infPrice'],
                    'pickup_location' => $pickupLocation,
                    'dropoff_location' => $dropoffLocation,
                    'actual_pickup_time' => !empty($pickupLocation) && !empty($pickupTime) 
                        ? date('h:i:s A', strtotime($pickupTime)) 
                        : '',
                    'dropoff_time' => !empty($dropoffLocation) && !empty($dropoffTime) 
                        ? date('h:i:s A', strtotime($dropoffTime)) 
                        : '',
                    'original_tkt_rate' => $priceCal['ticketPrice'],
                    'original_trans_rate' => $priceCal['transferPrice'],
                    'vat_percentage' => $priceCal['vat_per'],
                    'discountPrice' => 0,
                    'time_slot' => $timeslot,
                    'totalprice' => number_format($priceCal['totalprice'], 2, '.', ''),
                    'created_by' => '',
                    'updated_by' => '',
                ];

                $total_activity_amount += $priceCal['totalprice'];
							
            }
        }

        if (count($data) > 0) {
            VoucherActivity::insert($data);
            $voucher = Voucher::find($voucher_id);
            $voucher->total_activity_amount = $total_activity_amount;

            // Optimized vat_invoice logic
            $vatInvoice = $voucher->vat_invoice == 1 ? 1 : 0;
            $prefix = $vatInvoice ? 'BIN-1100001' : 'BCIN-1100001';

            $voucherCount = Voucher::where('status_main', 5)
                ->where('vat_invoice', $vatInvoice)
                ->whereDate('booking_date', '>', '2023-11-30')
                ->count();

            $voucherCountNumber = $voucherCount + 1;
            $code = $prefix . $voucherCountNumber;

            $voucher->booking_date = Carbon::now();
            $voucher->invoice_number = $code;
            $voucher->status_main = 5;
            $voucher->save();

			$ticketGenerateResponse = $this->ticketGenerate($voucher);
        } else {
            return [
                'success' => false,
				'tickets' => [],
                'message' => 'No valid activities to create voucher.',
            ];
        }
    } else {
        return [
            'success' => false,
			'tickets' => [],
            'message' => 'Please Select Tour Option.',
        ];
    }

    return [
        'success' => true,
		'tickets' => $ticketGenerateResponse,
        'message' => "Voucher created successfully.",
    ];
}

public function ticketGenerate($voucher)
{
    $responseData = []; // Initialize an array to hold all ticket data.

    try { 
        // Get all VoucherActivity records associated with the voucher
        $voucherActivities = VoucherActivity::where('voucher_id', $voucher->id)->get();

        // Check if voucher activities exist
        if ($voucherActivities->isEmpty()) {
            return $this->errorResponse('No Voucher Activities found.', 'Error', 404);
        }

        // Loop through each voucher activity and generate tickets
        foreach ($voucherActivities as $voucherActivity) {
            // Skip if tickets have already been generated for this voucher activity
            if ($voucherActivity->ticket_generated == 1) {
                continue; // Skip this activity if tickets are already generated
            }

            $adult = $voucherActivity->adult;
            $child = $voucherActivity->child;
            $totalTicketNeed = $adult + $child;

            // Query for available tickets based on the voucher activity's details
            $ticketQuery = Ticket::where('ticket_generated', '0')
                ->where('activity_variant', $voucherActivity->variant_code)
                ->whereDate('valid_from', '<=', $voucherActivity->tour_date)
                ->whereDate('valid_till', '>=', $voucherActivity->tour_date)
                ->orderBy("valid_till", "ASC");

            // Get the available tickets
            $totalTickets = $ticketQuery->get();
            $tcArray = [];

            // Assign tickets based on the requirements for adult/child
            foreach ($totalTickets as $ticket) {
                if ($ticket->ticket_for === 'Adult' && $adult > 0) {
                    $tcArray[] = $ticket;
                    $adult--;
                    $totalTicketNeed--;
                } elseif ($ticket->ticket_for === 'Child' && $child > 0) {
                    $tcArray[] = $ticket;
                    $child--;
                    $totalTicketNeed--;
                } elseif ($ticket->ticket_for === 'Both' && $totalTicketNeed > 0) {
                    $tcArray[] = $ticket;
                    if ($adult > 0) {
                        $adult--;
                    } elseif ($child > 0) {
                        $child--;
                    }
                    $totalTicketNeed--;
                }

                // Stop if all required tickets are assigned
                if ($totalTicketNeed == 0) break;
            }

            // If all required tickets are assigned, update their status
            if ($totalTicketNeed == 0 && count($tcArray) == ($voucherActivity->adult + $voucherActivity->child)) {
                foreach ($tcArray as $ticket) {
                    $ticket->voucher_activity_id = $voucherActivity->id;
                    $ticket->ticket_generated = 1;
                    $ticket->generated_time = now();
                    $ticket->voucher_id = $voucherActivity->voucher_id;
                    $ticket->downloaded_time = now();
                    $ticket->ticket_downloaded = 1;
                    $responseData[] = $ticket; // Add ticket data to response
                    $ticket->save();
                }

                // Mark the voucher activity as having generated and downloaded tickets
                $voucherActivity->ticket_generated = 1;
                $voucherActivity->ticket_downloaded = 1;
                $voucherActivity->save();
            } else {
                return 'Insufficient tickets available for some activities.';
            }
        }

        // Return success response with ticket data
        return [
            'tickets' => $responseData // Include all generated ticket data
        ];

    } catch (Exception $e) {
        // Catch any errors and return an error response
        return 'Something went wrong: ' . $e->getMessage();
    }
}


}