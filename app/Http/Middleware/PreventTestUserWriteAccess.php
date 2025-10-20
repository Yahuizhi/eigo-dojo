<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PreventTestUserWriteAccess
{
    
    public function handle(Request $request, Closure $next): Response
    {
        
        if (Auth::check() && Auth::user()->email === 'test@example.com') {
            
            
            if ($request->isMethod('POST') || $request->isMethod('PATCH') || $request->isMethod('DELETE')) {
                
                $errorMessage = 'この操作はテストアカウントでは許可されていません。';

                
                
                if ($request->ajax() || $request->wantsJson()) {
                    
                    return response()->json(['message' => $errorMessage], 403);
                }
                
                
                return redirect()->back()->with('error', $errorMessage);
            }
        }

        return $next($request);
    }
}
