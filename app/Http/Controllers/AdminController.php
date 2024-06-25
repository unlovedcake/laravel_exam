<?php

namespace App\Http\Controllers;

use App\Models\User;


use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use yajra\Datatables\Datatables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = User::where('user_type', 'user')->get();

            return Datatables::of($data)
                ->addIndexColumn()


                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="View" class="me-1 btn btn-info btn-sm showUser"><i class="fa-regular fa-eye"></i> View</a>';
                    $btn = $btn . '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editUser"><i class="fa-regular fa-pen-to-square"></i> Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteUser"><i class="fa-solid fa-trash"></i> Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.dashboard');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'contactNumber' => 'required|string|max:11',
            'gender' => 'required|string',
            'age' => 'required|numeric',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', Rules\Password::defaults()],


        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }


        User::updateOrCreate(
            [
                'id' => $request->user_id
            ],
            [
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'contactNumber' => $request->contactNumber,
                'age' => $request->age,
                'gender' => $request->gender,
                'email' => $request->email,
                'password' => $request->password,



            ]
        );


        return response()->json([
            'status' => true,
            'message' => 'User added successfully',

        ], 201);
    }


    public function show($id): JsonResponse
    {
        $user = User::find($id);

        return response()->json($user);
    }

    /**
     * Update a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */



    public function edit($id): JsonResponse
    {
        $user = User::find($id);
        return response()->json($user);
    }

    // public function update(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'editFirstName' => ['required', 'string', 'max:255'],
    //         'lastName' => ['required', 'string', 'max:255'],
    //         'contactNumber' => ['required', 'string', 'max:11'],
    //         'age' => ['required', 'string'],
    //         'gender' => ['required'],

    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             "status" => false,
    //             "errors" => $validator->errors(),

    //         ]);
    //     }

    //     User::where('id', $request->user_id)->update([

    //         'editFirstName' => $request->editFirstName,
    //         'lastName' => $request->editLastName,
    //         'age' => $request->editAge,
    //         'contactNumber' => $request->editContactNumber,
    //         'gender' => $request->editGender,
    //         'email' => $request->editEmail,
    //         'password' =>  $request->editPassword,


    //     ]);

    //     return response()->json([
    //         "status" => true,
    //         "message" => 'User Successfully Updated',

    //     ]);
    // }


    public function destroy($id): JsonResponse
    {
        User::find($id)->delete();

        return response()->json(['success' => 'User deleted successfully.']);
    }
}
