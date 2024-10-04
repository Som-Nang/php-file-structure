<?php

namespace Core\Middleware;

class Middleware
{
    const MAP = [
        'guest' => Guest::class,
        'auth' => Auth::class,
    ];

    /**
     * @throws \Exception
     */
    public static function resolve($key)
    {
        if (!$key) {
            return;
        }

        // Access MAP using 'self::' since it's a constant
        $middleware = self::MAP[$key] ?? false;

        if (!$middleware) {
            throw new \Exception("No matching middleware found for key '{$key}'.");
        }

        (new $middleware)->handle();
    }
}
