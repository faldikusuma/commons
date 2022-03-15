<?php

namespace Microservices;



use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class InfluencerScope
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
        if ($this->userServices->isInfluencer()) {
            return $next($request);
        }

        throw new AuthenticationException;
    }
}
