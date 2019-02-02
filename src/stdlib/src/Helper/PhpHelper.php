<?php

namespace Swoft\Stdlib\Helper;

/**
 * Php helper
 *
 * @since 2.0
 */
class PhpHelper
{
    /**
     * Call by callback
     *
     * @param callable $cb   callback
     * @param array    $args arguments
     *
     * @return mixed
     */
    public static function call(callable $cb, ...$args)
    {
        if (\is_string($cb)) {
            // className::method
            if (\strpos($cb, '::') > 0) {
                $cb = \explode('::', $cb, 2);
                // function
            } elseif (\function_exists($cb)) {
                return $cb(...$args);
            }
        } elseif (\is_object($cb) && \method_exists($cb, '__invoke')) {
            return $cb(...$args);
        }

        if (\is_array($cb)) {
            [$obj, $mhd] = $cb;

            return \is_object($obj) ? $obj->$mhd(...$args) : $obj::$mhd(...$args);
        }

        return $cb(...$args);
    }

    /**
     * Call by callback
     *
     * @param callable $cb
     * @param array    $args
     *
     * @return mixed
     */
    public static function callByArray(callable $cb, array $args = [])
    {
        return self::call($cb, ...$args);
    }
}