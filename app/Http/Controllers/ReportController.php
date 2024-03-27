<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Checkin;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    public function showCheckin(Request $request)
    {
        function getCheckins($val, $request)
        {
            switch ($val) {
                case 'day':
                    return  Checkin::whereDate('checkin_date', Carbon::today())->orderBy('checkin_date', 'desc')->paginate(10);
                case 'week':
                    return  Checkin::whereBetween('checkin_date', [Carbon::now()->subWeek(), Carbon::now()])->orderBy('checkin_date', 'desc')->paginate(10);
                case 'month':
                    return  Checkin::whereBetween('checkin_date', [Carbon::now()->subMonth(), Carbon::now()])->orderBy('checkin_date', 'desc')->paginate(10);
                case 'year':
                    return  Checkin::whereYear('checkin_date', Carbon::now()->year)->orderBy('checkin_date', 'desc')->paginate(10);
                case 'custom':
                    $startDate = Carbon::parse($request->input('startDate'));
                    $endDate = Carbon::parse($request->input('endDate'));
                    if ($startDate->equalTo($endDate)) {
                        return Checkin::whereDate('created_at', $startDate)->orderBy('created_at', 'desc')->paginate(10);
                    }
                    return Checkin::whereBetween('checkin_date', [$startDate, $endDate])->orderBy('checkin_date', 'desc')->paginate(10);
                default:
                    return  Checkin::orderBy('checkin_date', 'desc')->paginate(10);
            }
        }

        $filter = $request['filter'];
        $checkins = getCheckins($filter, $request)->withQueryString();

        return view('vendor/backpack/ui/checkins', compact('checkins'));
    }
    public function showMember(Request $request)
    {
        function getMember($val, $request)
        {
            switch ($val) {
                case 'day':
                    return  Member::whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->paginate(10);
                case 'week':
                    return  Member::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->orderBy('created_at', 'desc')->paginate(10);
                case 'month':
                    return  Member::whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()])->orderBy('created_at', 'desc')->paginate(10);
                case 'year':
                    return  Member::whereYear('created_at', Carbon::now()->year)->orderBy('created_at', 'desc')->paginate(10);
                case 'custom':
                    $startDate = Carbon::parse($request->input('startDate'));
                    $endDate = Carbon::parse($request->input('endDate'));
                    if ($startDate->equalTo($endDate)) {
                        return Member::whereDate('created_at', $startDate)->orderBy('created_at', 'desc')->paginate(10);
                    }
                    return Member::whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc')->paginate(10);
                default:
                    return  Member::orderBy('created_at', 'desc')->paginate(10);
            }
        }

        $filter = $request['filter'];
        $members = getMember($filter, $request)->withQueryString();

        return view('vendor/backpack/ui/members', compact('members'));
    }
    public function showPayments(Request $request)
    {
        function getPayment($val, $request)
        {
            switch ($val) {
                case 'day':
                    return  Payment::whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->paginate(10);
                case 'week':
                    return  Payment::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->orderBy('created_at', 'desc')->paginate(10);
                case 'month':
                    return  Payment::whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()])->orderBy('created_at', 'desc')->paginate(10);
                case 'year':
                    return  Payment::whereYear('created_at', Carbon::now()->year)->orderBy('created_at', 'desc')->paginate(10);
                case 'custom':
                    $startDate = Carbon::parse($request->input('startDate'));
                    $endDate = Carbon::parse($request->input('endDate'));
                    if ($startDate->equalTo($endDate)) {
                        return Payment::whereDate('created_at', $startDate)->orderBy('created_at', 'desc')->paginate(10);
                    }
                    return Payment::whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc')->paginate(10);
                default:
                    return  Payment::orderBy('created_at', 'desc')->paginate(10);
            }
        }


        $filter = $request['filter'];
        $payments = getPayment($filter, $request)->withQueryString();

        return view('vendor/backpack/ui/payment', compact('payments'));
    }
    public function cashflow(Request $request)
    {

        function getCashflow($val, $request)
        {
            if ($val === 'cash' || $val === 'gcash') {
                $startDate = Carbon::parse($request->input('startDate'));
                $endDate = Carbon::parse($request->input('endDate'));

                if (!$request->input('startDate')) {
                    return [
                        'amount' => Payment::where('payment_type', $val)->sum('amount'),
                        'message' => 'Total ' . $val . ' payments'
                    ];
                }
                if ($startDate->isSameDay($endDate)) {
                    return [
                        'amount' => Payment::where('payment_type', $val)->whereDate('created_at', $startDate)->sum('amount'),
                        'message' => 'Total amount from ' . $startDate->format('F j, Y')
                    ];
                }
                return [
                    'amount' => Payment::where('payment_type', $val)->whereBetween('created_at', [$startDate, $endDate])->sum('amount'),
                    'message' => 'Total amount from ' . $startDate->format('F j, Y') . ' upto ' . $endDate->format('F j, Y')
                ];
            }
            switch ($val) {
                case 'day':
                    return  [
                        'amount' => Payment::whereDate('created_at', Carbon::today())->sum('amount'),
                        'message' => 'Total amount for this day'
                    ];
                case 'week':
                    return  [
                        'amount' => Payment::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->sum('amount'),
                        'message' => 'Total amount for this week'
                    ];
                case 'month':
                    return  [
                        'amount' => Payment::whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()])->sum('amount'),
                        'message' => 'Total amount for this month'
                    ];
                case 'year':
                    return  [
                        'amount' => Payment::whereYear('created_at', Carbon::now()->year)->sum('amount'),
                        'message' => 'Total amount for this year'
                    ];
                case 'custom':
                    $startDate = Carbon::parse($request->input('startDate'));
                    $endDate = Carbon::parse($request->input('endDate'));
                    if ($startDate->isSameDay($endDate)) {
                        return [
                            'amount' => Payment::whereDate('created_at', $startDate)->sum('amount'),
                            'message' => 'Total amount from ' . $startDate->format('F j, Y')
                        ];
                    }
                    return [
                        'amount' => Payment::whereBetween('created_at', [$startDate, $endDate])->sum('amount'),
                        'message' => 'Total amount from ' . $startDate->format('F j, Y') . ' upto ' . $endDate->format('F j, Y')
                    ];
                case 'session':
                    $startDate = Carbon::parse($request->input('startDate'));
                    $endDate = Carbon::parse($request->input('endDate'));

                    if (!$request->input('startDate')) {
                        return [
                            'amount' => Payment::where('payment_for', $val)->sum('amount'),
                            'message' => 'Total ' . $val . ' payments'
                        ];
                    }
                    if ($startDate->isSameDay($endDate)) {
                        return [
                            'amount' => Payment::where('payment_for', $val)->whereDate('created_at', $startDate)->sum('amount'),
                            'message' => 'Total session amount from ' . $startDate->format('F j, Y')
                        ];
                    }
                    return [
                        'amount' => Payment::where('payment_for', $val)->whereBetween('created_at', [$startDate, $endDate])->sum('amount'),
                        'message' => 'Total session amount from ' . $startDate->format('F j, Y') . ' upto ' . $endDate->format('F j, Y')
                    ];
                default:
                    return  [
                        'amount' => Payment::all()->sum('amount'),
                        'message' => 'Total amount'
                    ];
            }
        }

        $args = [
            'has_query' => false
        ];

        if ($request->query->count() === 0) {
            return view('vendor/backpack/ui/cashflow', $args);
        }

        $filter = $request['filter'];
        $cashflow = getCashflow($filter, $request);

        $args['has_query'] = true;
        $args['cashflow'] = $cashflow['amount'];
        $args['message'] = $cashflow['message'];



        return view('vendor/backpack/ui/cashflow', $args);
    }
}
