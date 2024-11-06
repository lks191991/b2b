<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class DateRange implements Rule
{
    protected $activityVariantId;
    protected $recordId;

    public function __construct($activityVariantId, $recordId)
    {
        $this->activityVariantId = $activityVariantId;
        $this->recordId = $recordId;
    }

    public function passes($attribute, $value)
    {
        // Check if the date falls within any existing range for the given activity_variant_id
        $existingRanges = DB::table('variant_prices')
            ->where('activity_variant_id', $this->activityVariantId)
            ->where('rate_valid_from', '<=', $value)
            ->where('rate_valid_to', '>=', $value)
            ->when($this->recordId, function ($query) {
                // Exclude the current record being edited (update case)
                $query->where('id', '!=', $this->recordId);
            })
            ->count();

        return $existingRanges == 0;
    }

    public function message()
    {
        return 'The :attribute must not fall within any existing date range for the given activity variant.';
    }
}