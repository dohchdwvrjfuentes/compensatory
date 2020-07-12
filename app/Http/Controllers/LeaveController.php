<?php

namespace App\Http\Controllers;

use App\Leave;
use App\Employee;
use App\Duty;
use App\Record;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leaves = Leave::orderBy('created_at', 'DESC')->get();
        $employees = Employee::all();

        return view('leaves.index', compact('leaves', 'employees'));
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
        $hrs = intval($request->duration);
        $duration = $request->apply_date;
        $duties = array();
        $avail_dates = array();
        $diff = 0;
        
        
        // // loop each selected duty dates
        for($i = 0; $i < count($duration); $i++){
            $d = Duty::where('id', $duration[$i])->first();
            $diff = $hrs - $d->remaining;

            if($diff > 0){
                $r = 0.00;
                $hrs = $diff;
            }else if($diff < 0){
                $r = abs($diff);
            }

            
            Duty::where('id', $duration[$i])->update(
                array(
                    'remaining' => $r
                )
            );
            $avail_dates[] = \Carbon\Carbon::parse($d->duty_date)->format('m-d-yy');
        }
        $leave = new Leave([
            'employee_id' => $request->employee_id,
            'date' => \Carbon\Carbon::parse($request->leave_date)->format('yy-m-d'),
            'apply_date' => implode(', ', $avail_dates),
            'duration' => $request->duration,
            'used' => $request->duration
        ]);
        
        $emp = Employee::where('id', $request->employee_id)->first();

        $record = new Record([
            'employee_id' => $request->employee_id,
            'particulars' => \Carbon\Carbon::parse($request->leave_date)->format('m-d-yy'),
            'earned' => '0',
            'availed' => $request->duration,
            'availed_date' => implode(', ', $avail_dates),
            'total_balance' => $emp->total_hrs - $request->duration,
        ]);

        $employee = Employee::where('id', $request->employee_id)->update(
            array(
                'total_hrs' => $emp->total_hrs - $request->duration
            )
        );

        $leave->save();
        
        $record->save();
        
        $notification = array(
            'message' => 'Leave successfully Added!',
            'alert-type' => 'success'
        );


        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function show(Leave $leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function edit(Leave $leave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Leave $leave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leave $leave)
    {
        //
    }
}
