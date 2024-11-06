<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Get tenant slug from the URL
        $tenantSlug = $request->route('tenant');

        // Find the tenant by slug
        $tenant = Tenant::where('slug', $tenantSlug)->first();

        if (!$tenant) {
            // If no tenant found, abort with 404 error
            abort(404, 'Tenant not found.');
        }

        // Set the tenant in the request context, if needed
        $request->attributes->set('tenant', $tenant);

        return $next($request);
    }
}
