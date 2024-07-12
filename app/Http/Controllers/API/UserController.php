<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class UserController extends APIBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse|View
    {
        $users = User::all();

        return $this->sendResponse(UserResource::collection($users), 'Users retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $user = User::create($request->validated());
            return $this->sendResponse(new UserResourceResource($user), 'User created successfully.');
        } catch (\Throwable $th) {
            return $this->sendError('Problem to create User.', $th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return $this->sendError('User not found.');
        }

        return $this->sendResponse(new UserResource($user), 'User retrieved successfully.');
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        try {
            $user->update($request->validated());
    
            return $this->sendResponse(new UserResource($user), 'User updated successfully.');
        } catch (\Throwable $th) {
            return $this->sendError('Problem to update User.', $th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user): JsonResponse
    {
        try {
            $user->delete();
            return $this->sendResponse(message:'User deleted successfully.');
        } catch (\Throwable $th) {
            return $this->sendError('Problem to delete User.', $th);
        }
    }
}
