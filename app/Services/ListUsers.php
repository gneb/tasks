<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Http\Requests\ListUsersRequest;

class ListUsers
{
    public function run(ListUsersRequest $request)
    {  
        $users = User::with(['permissions', 'roles', 'tasks'])
        ->when($request->q, function($q) use($request){
            return $q->where('name', 'LIKE', '%'.$request->q.'%')
                     ->orWhere('username', 'LIKE', '%'.$request->q.'%')
                     ->orWhere('email', 'LIKE', '%'.$request->q.'%');
        })
        ->when($request->role, function($q) use($request){
            return $q->role($request->role);
        })
        ->when($request->permission, function($q) use($request){
            return $q->permission($request->permission);
        })
        ->paginate($request->per_page)->onEachSide(0);

        $users->appends([
            'per_page' => $request->per_page, 
            'q' => $request->q, 
            'role' => $request->role,
            'permission' => $request->permission,
        ]);

        return $users;
    }
}