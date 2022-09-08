<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $apps = Appointment::orderBy('created_at', 'DESC')->get();
        return view('home', ['apps' => $apps]);
    }

    public function postAppointment(Request $request)
    {
        $dateAvailable = true;
        $date = Carbon::parse($request->date)->format('Y-m-d H:i:s');
        $apps = Appointment::orderBy('created_at', 'DESC')->get();

        foreach ($apps as $a) {
            if($a->start_date == $date) return $dateAvailable = false;
            else if($date < Carbon::createFromDate($a->end_date)->addMinutes(30)) return $dateAvailable = false;
        }

        if($dateAvailable) {
            Appointment::create([
                'user_name' => Auth::user()->name,
                'start_date' => Carbon::createFromDate($date),
                'end_date' => Carbon::createFromDate($date)->addHour()
            ]);
        }

        return $dateAvailable;
    }
}
