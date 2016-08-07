<?php

namespace CodeProject\Http\Middleware;

use CodeProject\Repositories\ProjectRepository; 

use Closure;

class CheckOwnerProject
{
    private $repository;

    public function __construct(ProjectRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userId = \Authorizer::getResourceOwnerId();

        $projectId = $request->project;

        if($this->repository->isOwner($projectId, $userId) == false)
        {
            return ['error' => 'Access Denied'];
        }

        return $next($request);
    }
}
