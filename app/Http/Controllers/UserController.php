<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Requests\ListUsersRequest;
use App\Services\ListUsers;
use App\Http\Requests\EditUserRequest;
use App\Models\User;

class UserController extends Controller
{
    use HttpResponses;

    protected $listUsers;

    public function __construct(
        ListUsers $listUsers, 
    ){
        $this->listUsers = $listUsers;
    }

    public function list(ListUsersRequest $request)
    {
        return $this->success([
            'users' => $this->listUsers->run($request),
        ]);   
    }

    public function update(EditUserRequest $request, $user_id)
    {
        try {
            $user = User::findOrFail($user_id);
        } catch (\Throwable $th) {
            return $this->error('', 'user_not_found', 404);
        }

        $request->validated($request->all());

        $user->syncRoles([$request->role]);

        return $this->success([
            'user' => $user->toArray(),
        ], 'user_updated', 200);

    }

    public function delete(Request $request, $user_id)
    {
        try {
            $user = User::findOrFail($user_id);
        } catch (\Throwable $th) {
            return $this->error('', 'user_not_found', 404);
        }

        $user->delete();

        return $this->success('', 'user_deleted', 200);

    }
}
