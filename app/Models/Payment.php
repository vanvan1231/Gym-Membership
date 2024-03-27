<?php

namespace App\Models;

use PgSql\Lob;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'payments';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'amount',
        'payment_type',
        'transaction_code',
        'payment_for',
        'member_id'
    ];
    // protected $hidden = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function member(){
        return $this->belongsTo(Member::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($payment) {
            function getSubscriptionFactor($value)
            {
                $valObj = [
                    'sub_monthly' => 1,
                    'sub_yearly' => 12,
                    'sub_quarterly' => 3,
                    'sub_half' => 6
                ];
                return $valObj[$value] ?? 0;
            }
            $membership = Membership::where('member_id', $payment->member_id)->first();
            if (!$membership) return;
            if ($payment->payment_for == 'annual_fee') {
                if ($membership->mem_status == 'active') {
                    $end_date = Carbon::parse($membership['mem_end_date']);
                    $membership['mem_end_date'] = $end_date->addYear()->toDateString();
                    $membership->save();
                    return;
                }
                $membership->mem_status= 'active';
                $membership['mem_start_date'] = now()->toDateString();
                $membership['mem_end_date'] = now()->addYear()->toDateString();
                $membership->save();
            }elseif($payment->payment_for == 'session'){

                $member = Member::where('id', $payment->member_id)->first();
                if ($member) {
                    $member->checkin()->create([
                        'checkin_date' => Carbon::now(),
                        'mem_status' => 'active',
                        'sub_status' => 'active',
                        'member_id' => $member->id
                    ]);
                }
                if ($membership->sub_status == 'active') {
                    $end_date = Carbon::parse($membership->sub_end_date);
                    $membership['sub_end_date'] = $end_date->addDay(1);
                    $membership->save();
                    return;
                }
                $membership->sub_status= 'active';
                $membership['sub_start_date'] = now()->startOfDay();
                $membership['sub_end_date'] = now()->endOfDay();
                $membership->save();

            }else{
                $sub_factor = getSubscriptionFactor($membership->payment_for);
                if ($membership->sub_status == 'active') {
                    $end_date = Carbon::parse($membership->sub_end_date);
                    $membership['sub_end_date'] = $end_date->addMonths($sub_factor);
                    $membership->save();
                    return;
                }
                $membership->sub_status= 'active';
                $membership['sub_start_date'] = now()->toDateString();
                $membership['sub_end_date'] = now()->addMonth($sub_factor)->toDateString();
                $membership->save();
            }

        });
    }
    public function getFullNameAttribute(){
        return $this->member->full_name;
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

}
