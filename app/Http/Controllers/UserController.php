<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;

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

    public function destroy($id)
    {
       $user = User::where('id', $id)->first();
       $user->delete();

       return response()->json(['message' => 'Success!', 'id' => $user], 200);

    }


}

