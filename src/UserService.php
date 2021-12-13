<?php

namespace Microservices;

class UserService {
   
    private $endpoint;
    //http://192.168.100.93:8001/api

    public function __construct()
    {
        $this->endpoint = env('USER_ENDPOINT');
    }
    public function headers()
    {   
        $jwt = request()->cookie('jwt');
            return [
                'Authorization' => "Bearer {$jwt}",
                
            ];
        
       
    }
     public function request()
    {
        return Http::withHeaders($this->headers());
    }
   
    public function getUser()
    {
        $json = $this->request()->get("{$this->endpoint}/user")->json();
        return new User($json);

        
    }

    public function isAdmin()
    {
        return $this->request()->get("{$this->endpoint}/admin")->successful();
    }

    public function isInfluencer()
    {
        return $this->request()->get("{$this->endpoint}/influencer")->successful();

    }
    public function allows($ability, $arguments)
    {
        return Gate::forUser($this->getUser())->authorize($ability,$arguments);
    }

    public function all($page)
    {
        return  Http::withHeaders($this->headers())->get("{$this->endpoint}/users?page={$page}")->json();
    }

    public function get($id)
    {
        $json = $this->request()->get("{$this->endpoint}/users/{$id}")->json();

        return new User($json);;
    }

    public function create($data)
    {
        $json = $this->request()->post("{$this->endpoint}/users",$data)->json();

        return new User($json);;
    }

    public function update($id,$data)
    {
        $json = $this->request()->put("{$this->endpoint}/users/{$id}",$data)->json();

        return new User($json);;
    }

    public function delete($id)
    {
        return $this->request()->delete("{$this->endpoint}/users/{$id}")->successful();

    }

}