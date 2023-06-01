<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\validator;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\position;

class EmployeeController extends Controller
{
    public function index()
    {
        $pageTitle = 'Employee List';

         // RAW SQL
        //       $pageTitle = 'Employee List';
        //     $employees = DB::select('
        //     select *, employees.id as employee_id, positions.name as position_name
        //     from employees
        //     left join positions on employees.position_id = positions.id
        // ');
        // ELOQUENT
        $employees = Employee::all();

        return view('employee.index', [
            'pageTitle' => $pageTitle,
            'employees' => $employees
        ]);
    }


    public function create()
    {
        $pageTitle = 'Create Employee';

        // RAW SQL
        //     $positions = DB::select('select *from positions');

        // QUERY BUILDER
        // $positions = DB::table('positions')->get();

        // ELOQUENT
        $positions = Position::all();

        return view('employee.create', compact('pageTitle', 'positions'));
    }

    public function store(Request $request)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
            'email' => 'Isi :attribute dengan format yang benar',
            'numeric' => 'Isi :attribute dengan angka'
        ];

        $validator = Validator::make($request->all(), [
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //       // INSERT QUERY
        //       DB::table('employees')->insert([
        //         'firstname' => $request->firstName,
        //         'lastname' => $request->lastName,
        //         'email' => $request->email,
        //         'age' => $request->age,
        //         'position_id' => $request->position,
        //     ]);

        // ELOQUENT
        $employee = New Employee;
        $employee->firstname = $request->firstName;
        $employee->lastname = $request->lastName;
        $employee->email = $request->email;
        $employee->age = $request->age;
        $employee->position_id = $request->position;
        $employee->save();

        return redirect()->route('employees.index');
    }

public function show(string $id)
{
    $pageTitle = 'Employee Detail';

     // ELOQUENT
     $employee = Employee::find($id);

     return view('employee.show', compact('pageTitle', 'employee'));
 }

public function edit(string $id)
{
    $pageTitle = 'Edit Employee';

    // QUERY BUILDER
    // $employee = employee::find($id)
    // $positions = DB::table('positions')->get();

    // $employee = DB::table('employees')
    //     ->select('employees.*', 'employees.id as employee_id',
    //     'positions.name as position_name')
    //     ->leftjoin('positions', 'employees.position_id', '=',
    //     'positions.id' )
    //     ->where('employees.id', $id)
    //     ->first();

    // ELOQUENT
    $positions = Position::all();
    $employee = Employee::find($id);

        return view('employee.edit', compact('pageTitle', 'positions',
    'employee'));
    }

public function update(Request $request, string $id)
{
    $messages = [
        'required' => ':Attribute harus diisi.',
        'email' => 'Isi :attribute dengan format yang benar',
        'numeric' => 'Isi :attribute dengan angka'
    ];
    $validator = Validator::make($request->all(), [
        'firstName' => 'required',
        'lastName' => 'required',
        'email' => 'required|email',
        'age' => 'required|numeric',
    ], $messages);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // QUERY BUILDER
    // DB::table('employees')
    //     ->where('id', $id)->update([
    //     'firstname' => $request->firstName,
    //     'lastname' => $request->lastName,
    //     'email' => $request->email,
    //     'age' => $request->age,
    //     'position_id' => $request->position,
    // ]);

    // ELOQUENT
    $employee = Employee::find($id);
    $employee->firstname = $request->firstName;
    $employee->lastname = $request->lastName;
    $employee->email = $request->email;
    $employee->age = $request->age;
    $employee->position_id = $request->position;
    $employee->save();

    return redirect()->route('employees.index');
}

public function destroy(string $id)
{
    //     QUERY BUILDER
    //     DB::table('employees')
    //         ->where('id', $id)
    //         ->delete();

//ELOQUENT
Employee::find($id)->delete();
    return redirect()->route('employees.index');
}
}




