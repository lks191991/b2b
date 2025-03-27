<?php

namespace App\Helpers;

use Ramsey\Uuid\Uuid;
use DB;
use Carbon\Carbon;
use Auth;
use App\Models\User;
use App\Models\VoucherActivity;
use App\Models\VoucherHotel;
use App\Models\ActivityPrices;
use App\Models\AgentPriceMarkup;
use App\Models\ActivityVariant;
use App\Models\VariantPrice;
use App\Models\Zone;
use App\Models\TransferData;
use App\Models\Variant;
use App\Models\Activity;
use App\Models\Voucher;
use SiteHelpers;

class ZoneReportHelper 
{
    
	public static function noOfServices($input, $zones)
	{
		$query = VoucherActivity::whereIn('zone', $zones);

		if (!empty($input['booking_type']) && !empty($input['from_date']) && !empty($input['to_date'])) {
			$startDate = $input['from_date'];
			$endDate = $input['to_date'];

			if ($input['booking_type'] == 2) {
				$query->whereBetween('tour_date', [$startDate, $endDate]);
			} elseif ($input['booking_type'] == 1) {
				$query->whereHas('voucher', function ($q) use ($startDate, $endDate) {
					$q->whereBetween('booking_date', [$startDate, $endDate]);
				});
			}
		}

		return $query->selectRaw('zone, COUNT(*) as no_ofServices')
			->groupBy('zone')
			->pluck('no_ofServices', 'zone')
			->toArray();
	}

	public static function noOfBkgs($input, $zones)
	{
		$query = VoucherActivity::whereIn('zone', $zones);

		if (!empty($input['booking_type']) && !empty($input['from_date']) && !empty($input['to_date'])) {
			$startDate = $input['from_date'];
			$endDate = $input['to_date'];

			if ($input['booking_type'] == 2) {
				$query->whereBetween('tour_date', [$startDate, $endDate]);
			} elseif ($input['booking_type'] == 1) {
				$query->whereHas('voucher', function ($q) use ($startDate, $endDate) {
					$q->whereBetween('booking_date', [$startDate, $endDate]);
				});
			}
		}

		return $query->selectRaw('zone, COUNT(DISTINCT voucher_id) as no_ofServices')
        ->groupBy('zone')
        ->pluck('no_ofServices', 'zone')
        ->toArray();
	}

	public static function totalAccountedSell($input, $zones)
	{
    $query = VoucherActivity::whereIn('zone', $zones)
        ->whereNotNull('actual_total_cost')  
        ->where('actual_total_cost', '>', 0)
        ->whereNotIn('status', [1, 2, 11, 12]);

    if (!empty($input['booking_type']) && !empty($input['from_date']) && !empty($input['to_date'])) {
        $startDate = $input['from_date'];
        $endDate = $input['to_date'];

        if ($input['booking_type'] == 2) {
            $query->whereBetween('tour_date', [$startDate, $endDate]);
        } elseif ($input['booking_type'] == 1) {
            $query->whereHas('voucher', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('booking_date', [$startDate, $endDate]);
            });
        }
    }

    return $query->selectRaw("zone, COALESCE(SUM(original_tkt_rate), 0) as totalAccountedSell")
        ->groupBy('zone')
        ->pluck('totalAccountedSell', 'zone')
        ->toArray();
	}

	public static function totalAccountedSellDis($input, $zones)
{
    $query = VoucherActivity::whereIn('zone', $zones)
        ->whereNotNull('actual_total_cost')  
        ->where('actual_total_cost', '>', 0)
        ->whereNotIn('status', [1, 2, 11, 12]);

    if (!empty($input['booking_type']) && !empty($input['from_date']) && !empty($input['to_date'])) {
        $startDate = $input['from_date'];
        $endDate = $input['to_date'];

        if ($input['booking_type'] == 2) {
            $query->whereBetween('tour_date', [$startDate, $endDate]);
        } elseif ($input['booking_type'] == 1) {
            $query->whereHas('voucher', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('booking_date', [$startDate, $endDate]);
            });
        }
    }

    return $query->selectRaw("
        zone, 
        SUM(CASE 
            WHEN CAST(actual_total_cost AS DECIMAL(10,2)) > 0 
            AND status NOT IN (1,2,11,12) 
            THEN CAST(discount_tkt AS DECIMAL(10,2)) 
            ELSE 0 
        END) AS totalAccountedSellDis
    ")
    ->groupBy('zone')
    ->pluck('totalAccountedSellDis', 'zone')
    ->toArray();
}

public static function totalUnAccountedSell($input, $zones)
{
    $query = VoucherActivity::whereIn('zone', $zones)
        ->whereNotNull('actual_total_cost') 
        ->where('actual_total_cost', '=', 0)
        ->whereNotIn('status', [1, 2, 11, 12]);

    if (!empty($input['booking_type']) && !empty($input['from_date']) && !empty($input['to_date'])) {
        $startDate = $input['from_date'];
        $endDate = $input['to_date'];

        if ($input['booking_type'] == 2) {
            $query->whereBetween('tour_date', [$startDate, $endDate]);
        } elseif ($input['booking_type'] == 1) {
            $query->whereHas('voucher', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('booking_date', [$startDate, $endDate]);
            });
        }
    }

    return $query->selectRaw("
        zone, 
        SUM(CASE 
            WHEN CAST(actual_total_cost AS DECIMAL(10,2)) = 0 
            AND status NOT IN (1,2,11,12) 
            THEN CAST(original_tkt_rate AS DECIMAL(10,2)) 
            ELSE 0 
        END) AS totalUnAccountedSell
    ")
    ->groupBy('zone')
    ->pluck('totalUnAccountedSell', 'zone')
    ->toArray();
}

public static function totalUnAccountedSellDis($input, $zones)
{
    $query = VoucherActivity::whereIn('zone', $zones)
        ->whereNotNull('actual_total_cost')  
        ->where('actual_total_cost', '=', 0)
        ->whereNotIn('status', [1, 2, 11, 12]);

    if (!empty($input['booking_type']) && !empty($input['from_date']) && !empty($input['to_date'])) {
        $startDate = $input['from_date'];
        $endDate = $input['to_date'];

        if ($input['booking_type'] == 2) {
            $query->whereBetween('tour_date', [$startDate, $endDate]);
        } elseif ($input['booking_type'] == 1) {
            $query->whereHas('voucher', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('booking_date', [$startDate, $endDate]);
            });
        }
    }

    return $query->selectRaw("
        zone, 
        SUM(CASE 
            WHEN CAST(actual_total_cost AS DECIMAL(10,2)) = 0 
            AND status NOT IN (1,2,11,12) 
            THEN CAST(discount_tkt AS DECIMAL(10,2)) 
            ELSE 0 
        END) AS totalUnAccountedSellDis
    ")
    ->groupBy('zone')
    ->pluck('totalUnAccountedSellDis', 'zone')
    ->toArray();
}

public static function totalSells($input, $zones)
{
    $query = VoucherActivity::whereIn('zone', $zones)
        ->whereNotIn('status', [1, 2, 11, 12]); // Filter status

    if (!empty($input['booking_type']) && !empty($input['from_date']) && !empty($input['to_date'])) {
        $startDate = $input['from_date'];
        $endDate = $input['to_date'];

        if ($input['booking_type'] == 2) {
            $query->whereBetween('tour_date', [$startDate, $endDate]);
        } elseif ($input['booking_type'] == 1) {
            $query->whereHas('voucher', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('booking_date', [$startDate, $endDate]);
            });
        }
    }

    return $query->selectRaw("
        zone, 
        SUM(CASE 
            WHEN status NOT IN (1,2,11,12) 
            THEN CAST(original_tkt_rate AS DECIMAL(10,2)) 
            ELSE 0 
        END) AS totalSells
    ")
    ->groupBy('zone')
    ->pluck('totalSells', 'zone')
    ->toArray();
}

public static function totalSellsDis($input, $zones)
{
    $query = VoucherActivity::whereIn('zone', $zones)
        ->whereNotIn('status', [1, 2, 11, 12]); // Filter status

    if (!empty($input['booking_type']) && !empty($input['from_date']) && !empty($input['to_date'])) {
        $startDate = $input['from_date'];
        $endDate = $input['to_date'];

        if ($input['booking_type'] == 2) {
            $query->whereBetween('tour_date', [$startDate, $endDate]);
        } elseif ($input['booking_type'] == 1) {
            $query->whereHas('voucher', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('booking_date', [$startDate, $endDate]);
            });
        }
    }

    return $query->selectRaw("
        zone, 
        SUM(CASE 
            WHEN status NOT IN (1,2,11,12) 
            THEN CAST(discount_tkt AS DECIMAL(10,2)) 
            ELSE 0 
        END) AS totalSellsDis
    ")
    ->groupBy('zone')
    ->pluck('totalSellsDis', 'zone')
    ->toArray();
}
public static function totalCost($input, $zones)
{
    $query = VoucherActivity::whereIn('zone', $zones)
        ->whereNotIn('status', [1, 2, 11, 12]); // Status Filter पहले ही लागू कर दिया

    if (!empty($input['booking_type']) && !empty($input['from_date']) && !empty($input['to_date'])) {
        $startDate = $input['from_date'];
        $endDate = $input['to_date'];

        if ($input['booking_type'] == 2) {
            $query->whereBetween('tour_date', [$startDate, $endDate]);
        } elseif ($input['booking_type'] == 1) {
            $query->whereHas('voucher', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('booking_date', [$startDate, $endDate]);
            });
        }
    }

    return $query->selectRaw("
        zone, 
        COALESCE(SUM(CAST(actual_total_cost AS DECIMAL(10,2))), 0) AS totalCost
    ")
    ->groupBy('zone')
    ->pluck('totalCost', 'zone')
    ->toArray();
}

public static function totalAccountedTransSell($input, $zones)
{
    $query = VoucherActivity::whereIn('zone', $zones)
        ->whereNotIn('status', [1, 2, 11, 12]);

    if (!empty($input['booking_type']) && !empty($input['from_date']) && !empty($input['to_date'])) {
        $startDate = $input['from_date'];
        $endDate = $input['to_date'];

        if ($input['booking_type'] == 2) {
            $query->whereBetween('tour_date', [$startDate, $endDate]);
        } elseif ($input['booking_type'] == 1) {
            $query->whereHas('voucher', function ($q) use ($startDate, $endDate) {
                $q->whereBetween('booking_date', [$startDate, $endDate]);
            });
        }
    }

    return $query->selectRaw("
        zone, 
        COALESCE(SUM(
            CASE 
                WHEN (COALESCE(CAST(actual_transfer_cost AS DECIMAL(10,2)), 0) 
                     + COALESCE(CAST(actual_transfer_cost2 AS DECIMAL(10,2)), 0)) > 0  
                     THEN CAST(original_trans_rate AS DECIMAL(10,2)) 
                ELSE 0 
            END
        ), 0) AS totalAccountedTransSell
    ")
    ->groupBy('zone')
    ->pluck('totalAccountedTransSell', 'zone')
    ->toArray();
}


}
