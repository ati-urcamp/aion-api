<?php

namespace App\Http\Middleware;

use Closure;
use Domain\Usuario\UsuarioRepository;
use JWTAuth;

class ValidaPermissaoUsuario
{
    /**
     * @var UsuarioRepository
     */
    private $usuarioRepo;

    public function __construct(UsuarioRepository $usuarioRepo)
    {
        $this->usuarioRepo = $usuarioRepo;
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
        $routeName = $request->route()->getName();
        $ref_usuario = auth()->user()->id;

        $temPermissao = $this->usuarioRepo->temPermissao($routeName, $ref_usuario);

        if (!$temPermissao) {
            return response()->json(['error' => 'Sem permissão para executar a ação.'], 401);
        }

        return $next($request);
    }
}
