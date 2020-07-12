<?php

namespace App\Http\Controllers;

use App\Duty;
use App\Employee;
use App\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DutyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $duties = Duty::orderBy('duty_date', 'DESC')->get();
        $employees = Employee::all();
        $shifts = DB::table('shift')->get();

        return view('duties.index', compact('duties', 'employees', 'shifts'));
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
        $data = request()->validate([
            'employee_id' => 'required',
            'duty_date' => 'required',
            'shift' => 'required',
            'hr_rendered' => 'required',
            'roso_no' => 'required'
        ]);

        $shift = DB::table('shift')->where('id', $data['shift'])->first();
        $earned = $data['hr_rendered'] * $shift->credit;
        
        $duty = new Duty([
            'employee_id' => $data['employee_id'],
            'duty_date' => \Carbon\Carbon::parse($data['duty_date'])->format('yy-m-d'),
            'shift' => $data['shift'],
            'hr_rendered' => $data['hr_rendered'],
            'earned' => $earned,
            'remaining' => $earned,
            'roso_no' => $data['roso_no'],
            'expiry_date' => \Carbon\Carbon::parse($data['duty_date'])->addYear()->format('yy-m-d')
        ]);
        
        $emp = Employee::where('id', $data['employee_id'])->first();
        $shift = DB::table('shift')->where('id', $data['shift'])->first();
        $particulars = $shift->desc . " (" . \Carbon\Carbon::parse($request->duty_date)->format('m-d-yy')  .") " . $data['roso_no'];

        $record = new Record([
            'employee_id' => $data['employee_id'],
            'particulars' => $particulars,
            'earned' => $earned,
            'availed' => '0',
            'availed_date' => "",
            'total_balance' => $emp->total_hrs + $earned,
        ]);

        $employee = Employee::where('id', $data['employee_id'])->update(
            array(
                'total_hrs' => $emp->total_hrs + $earned
            )
        );

        $record->save();
        
        $duty->save();

        $notification = array(
            'message' => 'Duty successfully Added!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Duty  $duty
     * @return \Illuminate\Http\Response
     */
    public function show(Duty $duty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Duty  $duty
     * @return \Illuminate\Http\Response
     */
    public function edit(Duty $duty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Duty  $duty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Duty $duty)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Duty  $duty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Duty $duty)
    {
        //
    }

    public function get_empduty(Request $request){
        $today = \Carbon\Carbon::today()->format('yy-m-d');

        $duties = Duty::where('employee_id', $request->empid)->whereDate('expiry_date', '>', $today)->where('remaining', '!=' , 0)->get();

        $output = "";
        foreach($duties as $duty){
            $output .="<option value='$duty->id'> $duty->duty_date , Remaining: $duty->remaining </option>";
        }

        return $output;
    }
}
