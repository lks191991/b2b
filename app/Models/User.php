<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;

class User extends Authenticatable
{   
    use HasApiTokens, HasFactory, Notifiable,HasRoleAndPermission;
	use HasRoleAndPermission;
	use SoftDeletes;
    use Uuids;
    protected $guarded = ['id'];
	protected $keyType = 'string';
	public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','lname', 'phone', 'city_id', 'country_id', 'state_id', 'postcode', 'image', 'email', 'password', 'role_id', 'is_active','code','mobile','company_name','department','address','activity_id','ticket_only','sic_transfer','pvt_transfer','agent_category','agent_credit_limit','sales_person','agent_amount_balance','pan_no','pan_no_file','trade_license_no','trade_license_no_file','trn_no','agency_mobile','agency_email','currency_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	protected $appends = ['full_name'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	public function getFullNameAttribute() // notice that the attribute name is in CamelCase.
	{
	return $this->name . ' ' . $this->lname;
	}

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    
	 public function role()
    {
        return $this->belongsTo(Role::class);
    }
	
	public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
