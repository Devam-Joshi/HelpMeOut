<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Convert middleware parameters to integers
        $roleIds = array_map('intval', $roles);

        // Get the user's role id safely
        $userRoleId = $user->role_id ?? ($user->role->id ?? 0);
        
        if (!in_array($userRoleId, $roleIds)) {
            return response()->json(['status'=> false,'message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
