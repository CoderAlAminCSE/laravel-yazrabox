<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\User;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::all();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                            $btn = '
                            <a href="#"  class="btn btn-primary btn-sm">Edit</a>
                            <button type="button" onclick="deleteUser(' . $data->id . ')" class="btn btn-danger btn-sm">Delete</button>
                            ';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('users');
    }


    // this function will export data 
    public function export() 
    {
        return Excel::download(new UsersExport, 'users.csv', \Maatwebsite\Excel\Excel::CSV);
        // return Excel::download(new UsersExport, 'users.xlsx');
    }


    public function import(Request $request) 
    {
        // return "hello";
        
        $file = $request->file('file');
        $rows = array_map('str_getcsv', file($file));
        array_shift($rows); // remove header row
        foreach ($rows as $row) {
            // return $row[3];
            User::create([
                'name' => $row[1],
                'email' => $row[2],
                'image' => $row[3],
                'email_verified_at' => $row[4],
                'password' => $row[5],
                'remember_token' => $row[6],
                // add any other fields as needed
            ]);
        }
        
        return back();
    }
    

    public function destroy($id)
    {
       $user = User::where('id', $id)->first();
       $user->delete();

       return response()->json(['message' => 'Success!', 'id' => $user], 200);

    }


}

