<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class PerformanceMonitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        $startMemory = memory_get_usage(true);

        $response = $next($request);

        $endTime = microtime(true);
        $endMemory = memory_get_usage(true);

        $executionTime = round(($endTime - $startTime) * 1000, 2); // milliseconds
        $memoryUsage = round(($endMemory - $startMemory) / 1024 / 1024, 2); // MB
        $peakMemory = round(memory_get_peak_usage(true) / 1024 / 1024, 2); // MB

        // Log performance metrics for slow requests (>500ms)
        if ($executionTime > 500) {
            Log::warning('Slow Request Detected', [
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'execution_time' => $executionTime . 'ms',
                'memory_usage' => $memoryUsage . 'MB',
                'peak_memory' => $peakMemory . 'MB',
                'user_id' => auth()->id(),
                'ip' => $request->ip(),
            ]);
        }

        // Add performance headers for debugging (only in local environment)
        if (app()->environment('local')) {
            $response->headers->set('X-Response-Time', $executionTime . 'ms');
            $response->headers->set('X-Memory-Usage', $memoryUsage . 'MB');
            $response->headers->set('X-Peak-Memory', $peakMemory . 'MB');
        }

        return $response;
    }
}