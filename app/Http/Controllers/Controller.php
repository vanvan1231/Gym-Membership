<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Checkin;
use App\Models\Membership;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function dashboard(){

        $memberCount = Member::count();
        $activeMembers = Checkin::whereBetween('checkin_date', [Carbon::now()->subMonth(), Carbon::now()])
        ->distinct('member_id')
        ->count();
        $expiredMembers = Membership::where('mem_status', 'expired')->count();

        return view('vendor/backpack/ui/dashboard', [
            'memberCount' => $memberCount,
            'activeMembers' => $activeMembers,
            'expiredMembers' => $expiredMembers
        ]);
    }
}
