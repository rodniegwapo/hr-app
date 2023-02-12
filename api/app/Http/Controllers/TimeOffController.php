<?php

namespace App\Http\Controllers;

use App\Events\TimeOffProcessed;
use App\Mail\SendToUserNotification;
use App\Mail\UserRequestTimeOffMessage;
use App\Models\Role;
use App\Models\TimeOff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Stmt\Return_;

class TimeOffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $direction = "DESC";
        $user = auth()->user()->load('roles:id,name');
        if ($user->roles[0]->name == Role::ROLE_ADMIN) {
            return TimeOff::with(['user' => function ($query) use ($direction) {
                $query->orderBy('lastname', $direction);
            }, 'type',])->orderBy('created_at', 'DESC')->paginate(15);
        } else if ($user->roles[0]->name == Role::ROLE_MANAGER) {

            $time_off = TimeOff::whereHas('user', function ($q) {
                $q->where('manager_id', auth()->user()->id);
            })->where('is_approved', '!=', 3)
                ->orWhereNull('is_approved')
                ->with(['user', 'type'])->orderBy('created_at', 'DESC')->paginate(15);

            return $time_off;
        } else {
            return TimeOff::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->with(['user', 'type',])
                ->paginate(15);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'startDate' => 'required',
            'endDate' => 'required|after:startDate'
        ]);
        $time =  new TimeOff(
            [
                'user_id' => auth()->user()->id,
                'type_id' => $request->type,
                'start_date' => $request->startDate,
                'end_date' => $request->endDate,
                'notes' => $request->notes
            ]
        );
        $time->save();
        // return $time;
        event(new TimeOffProcessed($time));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TimeOff  $timeOff
     * @return \Illuminate\Http\Response
     */
    public function show(TimeOff $timeOff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TimeOff  $timeOff
     * @return \Illuminate\Http\Response
     */
    public function edit(TimeOff $timeOff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TimeOff  $timeOff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TimeOff $timeOff)
    {
        $timeOff = TimeOff::find($request->id);
        $timeOff->update([
            'is_approved' => $request->isApproved
        ]);
        return 'updated';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimeOff  $timeOff
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TimeOff::find($id)->delete();
    }
    public function requestTimeOff($id)
    {
        $time_off = TimeOff::where('id', $id)->with(['user', 'type'])->first();
        $manager = User::where('id', $time_off->user->manager_id)->with(['roles:id,name'])->first();

        if ($manager->id == auth()->user()->id) {
            return $time_off;
        }
    }
    public function declineOrApprove(Request $request)
    {
        $time_off = TimeOff::where('id', $request->id)->with('user')->first();

        $time_off->update([
            'is_approved' => $request->is_approved
        ]);

        $message = null;
        if ($request->is_approved == 0) {
            $message = "Your " . $time_off->type->name . " " . " request timeoff has been declined";
        } else {
            $message = "Your " . $time_off->type->name . " " . "request timeoff has been Approved";
        }

        Mail::to($time_off->user->email)->send(new SendToUserNotification($message));
    }
    public function approvedTimeOffs()
    {
        $time_off =  TimeOff::where('is_approved', '1')->with(['user', 'type'])->get();
        return $time_off;
    }
    public function managerTimeOffFromStaff()
    {
        $user = auth()->user()->load('roles:id,name');
        if ($user->roles[0]->name == Role::ROLE_MANAGER) {
            $time_off = TimeOff::whereHas('user', function ($q) {
                $q->where('manager_id', auth()->user()->id);
            })->where('is_approved', '!=', 3)
                ->orWhereNull('is_approved')
                ->with(['user', 'type'])->orderBy('created_at', 'DESC')->get();

            return $time_off;
        }
    }
    public function searchByName(Request $request)
    {

        if ($request->item) {
            return TimeOff::whereHas('user', function ($q) use ($request) {
                $q->where('firstname', 'like', '%' . $request->item . '%')
                    ->orWhere('lastname', 'like', '%' . $request->item . '%');
            })->with(['user', 'type'])->get();
        }
    }
}
