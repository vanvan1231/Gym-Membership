<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Checkin;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CheckinController extends Controller
{
    public function checkin(Request $request)
    {
        $data = $request->validate([
            'member_code' => 'required'
        ]);

        $member = Member::where('code', $data['member_code'])->first();
        $memberData = [
            'record_exist' => false,
            'has_submitted' => true
        ];
        if ($member) {
            $memberData['record_exist'] = true;
                $memberData['full_name'] = $member->full_name;
                $memberData['email'] = $member->email;
            if ($member->membership->mem_status === 'active' && $member->membership->sub_status === 'active') {

                $memberData['mem_status'] = 'Active';
                $memberData['sub_status'] = 'Active';

                $checkinData = [
                    'checkin_date' => Carbon::now(),
                    'member_id' => $member->membership->id
                ];
                $member->checkin()->create($checkinData);
            }else{
                $memberData['mem_status'] = 'Expired';
                $memberData['sub_status'] = 'Cancelled';
            }
        }

        return view('home', $memberData);
    }
}
