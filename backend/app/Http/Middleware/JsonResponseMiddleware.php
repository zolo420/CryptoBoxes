<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Routing\ResponseFactory;

/**
 * Class JsonResponseMiddleware.
 */
class JsonResponseMiddleware
{
    /**
     * The Response Factory our app uses.
     *
     * @var ResponseFactory
     */
    protected $factory;

    /**
     * JsonMiddleware constructor.
     *
     * @param ResponseFactory $factory
     */
    public function __construct(ResponseFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Str::startsWith($request->url(), url('debug'))) {
            // First, set the header so any other middleware knows we're
            // dealing with a should-be JSON response.
            $request->headers->set('Accept', 'application/json');

            // Get the response
            $response = $next($request);

            // If the response is not strictly a JsonResponse, we make it
            if (!$response instanceof JsonResponse) {
                $response = $this->factory->json(
                    $response->content(),
                    $response->status(),
                    $response->headers->all()
                );
            }

            return $response;
        }

        return $next($request);
    }
}
