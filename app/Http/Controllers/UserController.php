<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|View
    {
        if ($request->ajax()) {
            $data = User::select('*')->latest();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $button = '<a class="btn btn-primary btn-sm" href="' . route('user.edit', $row) . '">Edit</a>';
                    if (auth()->user()->id != $row->id) {
                        $button .= '<form action="' . route('user.destroy', $row) . '" method="POST">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm(\'Are You Sure Want to Delete?\')">Delete</button>
                        </form>';
                    }

                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('user.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        try {
            User::create($request->validated());
            return redirect()->route('user.index')
                ->withSuccess('New user is added successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('user.index')
                ->withError('Problem to create user.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        try {
            $user->update($request->validated());

            return redirect()->route('user.index')
                ->withSuccess('User is updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('user.index')
                ->withError('Problem to update user.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        try {
            $user->delete();
            
            return redirect()->route('user.index')
                ->withSuccess('User is deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->route('user.index')
                ->withError('Problem to delete user.');
        }
    }

    /**
     * Summary of checkEmailExist
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function checkEmailExist(Request $request)
    {
        $checkEmailExists = User::where('email', $request->email);
        if ($request->has('id')) {
            $checkEmailExists = $checkEmailExists->where('id','<>', $request->id);
        }
        $checkEmailExists = $checkEmailExists->first();
        if ($checkEmailExists) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }
}
