<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user(); // Récupère l'utilisateur connecté

        // Vérifie si l'utilisateur est connecté et a un rôle autorisé
        if (!$user || !in_array($user->getRoleType(), $roles)) {
            // Interdit l'accès si non autorisé
            abort(403, 'Accès refusé : vous n\'avez pas les permissions nécessaires.');
        }

        // Continue la requête si tout est bon
        return $next($request);
    }
}
