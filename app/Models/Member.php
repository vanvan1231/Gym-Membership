<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'members';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'code',
        'fname',
        'lname',
        'contact',
        'email'
    ];
    // protected $hidden = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    protected static function boot(){
        parent::boot();
        static::created(function ($mem){
            $mem->update([
                'code' => now()->format('md').'-'.str_pad($mem->id, 4, '0', STR_PAD_LEFT)
            ]);
            $mem->membership()->create([
                'member_id' => $mem->id
            ]);
        });
     }
     public function getFullNameAttribute() {
        return $this->fname.' '.$this->lname;
    }
    public function getMemStatusAttribute() {
        return $this->membership->mem_status;
    }
    public function getSubStatusAttribute() {
        return $this->membership->sub_status;
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function membership(){
        return $this->hasOne(Membership::class);
    }
    public function payment(){
        return $this->hasMany(Payment::class);
    }
    public function checkin(){
        return $this->hasMany(Checkin::class);
    }
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
