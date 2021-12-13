<?php

namespace Microservices;

use App\Services\UserService;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AdminScope
{    

    private $userServices;

    public function __construct(UserService $userServices)
    {
        $this->userServices = $userServices;
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {   
        if ($this->userServices->isAdmin()) {
            return $next($request);
        }
       throw new AuthenticationException;
    }
}
