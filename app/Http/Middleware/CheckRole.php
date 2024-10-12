<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = $request->user();


        // Redirect to login if the user is not authenticated
        if (!$user) {
            return redirect('/login');
        }

        // Role-based access control
        if ($role === 'registrar' && (!$user->employee || !$user->isRegistrar())) {
            return redirect()->route('dashboard');
        } 
        
        if ($role === 'teacher' && (!$user->employee || !$user->isTeacher())) {
            return redirect()->route('dashboard');
        } 

        if ($role === 'student' && $user->employee) {
            // If the user has an employee record, they are not considered a student
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
