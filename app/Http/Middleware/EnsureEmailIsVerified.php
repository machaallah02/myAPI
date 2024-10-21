<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User|null $user */
        $user = $request->user();

        if ( ! $user ||
            ($user instanceof MustVerifyEmail &&
            ! $request->user()->hasVerifiedEmail())) {
            return response()->json(['message' => 'Your email address is not verified.'], 409);
        }

        return $next($request);
    }
}