<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        $user = Auth::user(); // Retrieve the currently authenticated user

        if ($user && $user->role === $role) {
            return $next($request);
        }

        // Redirect based on role
        if ($role === 'admin' &&  $user->remember_token === NULL) {
            return redirect()->route('admin.dashboard'); // Replace 'admin.dashboard' with your admin dashboard route
        } elseif ($role === 'user' &&  $user->remember_token === NULL) {
            return redirect()->route('user.dashboard'); // Replace 'student.dashboard' with your student dashboard route
        }

        // Add additional handling for other roles as needed

        // If the role doesn't match any expected roles, you can handle it here (e.g., show an error page)
        abort(403, 'Unauthorized');
    }
}
