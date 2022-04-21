<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Address;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Filesystem\Cache;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\This;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::with('phones', 'addresses')->paginate(5);
        return UserResource::collection($data);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            //return response($user,200) ;
            return new UserResource($user);
        } else if ($id == is_null(1)) {
            return $this->apiResponse(ResultType::Error, null, 'enter a user id', 404);
        } else {
            return $this->apiResponse(ResultType::Error, null, 'User not found', 404);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user,$id)
    {
        $user = User::find($id);
        if ($id){
            $user->name=$request->name;
            $user->surname=$request->surname;
            $user->email=$request->email;
            foreach ($request->get("phones") as $phone) {
                Phone::find($phone['id'])->update([
                    'user_id'=>$user->id,
                    'phone_type' => $phone['phone_type'],
                    'phone_number' => $phone['phone_number']
                ]);
            }
            foreach ($request->get("addresses") as $address) {
                Phone::find($address['id'])->update([
                    'user_id'=>$user->id,
                    'title' => $address['title'],
                    'address' => $address['address'],
                    'district' => $address['district'],
                    'city' => $address['city'],
                    'postal_code' => $address['postal_code']
                ]);
            }
            return $this->apiResponse(ResultType::Success, $user, 'updated', 200);

        }
        else{
            return $this->apiResponse(ResultType::Error,'user not found',404);
        }





    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function request(Request $request)
    {

        return DB::transaction(function () use($request){
            $phoneArray = $request->get("phones");
            $addressArray = $request->get("addresses");

            $userExist = User::where('email', $request->email)->first();
            if ($userExist) {
                return $this->apiResponse(ResultType::Error, null,'user already exists', 404);
            } else {
                $user = new User;
                $user->name = $request->name;
                $user->surname = $request->surname;
                $user->email = $request->email;
                $user->save();
                if ($phoneArray) {
                    foreach ($phoneArray as $phone) {
                        Phone::create(array_merge($phone, ['user_id' => $user->id]));
                    }
                }
                if ($addressArray) {
                    foreach ($addressArray as $address) {
                        Address::create(array_merge($address, ['user_id' => $user->id]));
                    }
                }
                return $this->apiResponse(ResultType::Success,$user->load("phones","addresses"), 'user, phone and address created', 201);
            }

        });





    }
}
