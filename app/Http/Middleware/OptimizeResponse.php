<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OptimizeResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Add caching headers for static assets
        if ($this->isStaticAsset($request)) {
            $response->header('Cache-Control', 'public, max-age=31536000'); // 1 year
            $response->header('Expires', gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
        } else {
            // For dynamic content, add appropriate cache headers
            $response->header('Cache-Control', 'no-cache, must-revalidate');
            $response->header('Pragma', 'no-cache');
        }

        // Enable gzip compression
        if (extension_loaded('zlib') && !ini_get('zlib.output_compression')) {
            if (strpos($request->header('Accept-Encoding', ''), 'gzip') !== false) {
                $response->header('Content-Encoding', 'gzip');
            }
        }

        // Security headers
        $response->header('X-Content-Type-Options', 'nosniff');
        $response->header('X-Frame-Options', 'DENY');
        $response->header('X-XSS-Protection', '1; mode=block');
        
        // Performance headers
        $response->header('X-DNS-Prefetch-Control', 'on');

        return $response;
    }

    /**
     * Check if the request is for a static asset
     */
    private function isStaticAsset(Request $request): bool
    {
        $extensions = ['css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'woff', 'woff2', 'ttf', 'eot'];
        $path = $request->path();
        
        foreach ($extensions as $ext) {
            if (str_ends_with($path, '.' . $ext)) {
                return true;
            }
        }
        
        return false;
    }
}
