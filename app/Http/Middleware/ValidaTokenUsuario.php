<?php

namespace App\Http\Middleware;

use Closure;
use Domain\UsuarioToken\UsuarioTokenRepository;
use JWTAuth;

class ValidaTokenUsuario
{
    /**
     * @var UsuarioTokenRepository
     */
    protected $tokenRepo;

    public function __construct(UsuarioTokenRepository $tokenRepo)
    {
        $this->tokenRepo = $tokenRepo;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $this->tokenRepo->buscarAtivoPorUsuario(auth()->user()->id, JWTAuth::getToken());

        if (!$token) {
            return response()->json([
                'error' => 401,
                'message' => 'O token foi colocado na blacklist'
            ], 401);
        }

        return $next($request);
    }
}
