<?php

/*
 * This file is part of jwt-auth. Overrided for custom functionality.
 *
 * (c) Sean Tymon <tymon148@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Middleware;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Middleware\BaseMiddleware;
use App\Http\ApiResponder;
use App\Token;
use Carbon\Carbon;

class GetUserFromToken extends BaseMiddleware
{
    use ApiResponder;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $token = $request->token;
        if (! $token) {
            return $this->unauthorized();
        }

        try {
            $user = $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) {
            return $this->customResponse(401, NULL, 'Token kadaluarsa.');
        } catch (JWTException $e) {
            return $this->customResponse(401, NULL, 'Token tidak valid.');
        }

        if (! $user) {
            return $this->notFound('User tidak ditemukan.');
        }

        if ($user->token_login_mobile !== $token) {
            return $this->customResponse(401, NULL, 'Token tidak valid.');
        } else {
            $now = Carbon::now()->toDateTimeString();
            if ($user->token_login_mobile_kadaluarsa === NULL 
                || $user->token_login_mobile_kadaluarsa < $now) {
                return $this->customResponse(401, NULL, 'Token kadaluarsa.');
            };
        }

        $this->events->fire('tymon.jwt.valid', $user);

        return $next($request);
    }
}