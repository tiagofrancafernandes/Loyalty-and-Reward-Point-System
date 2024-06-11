<?php

declare(strict_types=1);

use App\Helpers\File\FileHelpers;
use App\Helpers\Arrays\ArrayHelpers;
use App\Helpers\Strings\StringHelpers;
use App\Helpers\TrueOrFalseHelper;

require_once __DIR__ . '/import-export-helpers.php';

if (!function_exists('logAndDump')) {
    /**
     * logAndDump function
     *
     * @param mixed ...$content
     * @return void
     */
    function logAndDump(...$content)
    {
        FileHelpers::logAndDump(...$content);
    }
}

if (!function_exists('logAndDumpSpf')) {
    /**
     * logAndDumpSpf function
     *
     *
     * @param string $firstString
     * @param float|int|string ...$params
     *
     * @return void
     */
    function logAndDumpSpf(string $firstString, float|int|string ...$params): void
    {
        $params = array_values($params);

        foreach ($params as $key => $item) {
            $params[$key] = trim(var_export($item, true), "'");
        }

        FileHelpers::logAndDump(sprintf($firstString, ...$params));
    }
}

if (!function_exists('getMimeType')) {
    /**
     * getMimeType function
     *
     * @param string|null $filePath
     * @return string|boolean|null
     */
    function getMimeType(?string $filePath): string|bool|null
    {
        return FileHelpers::getMimeType($filePath);
    }
}

if (!function_exists('isFilledFile')) {
    /**
     * isFilledFile function
     *
     * @param string|null $filePath
     *
     * @return boolean
     */
    function isFilledFile(?string $filePath): bool
    {
        return FileHelpers::isFilledFile($filePath);
    }
}

if (!function_exists('relativePath')) {
    /**
     * relativePath function
     *
     * @param string $filePath
     * @return string
     */
    function relativePath(string $filePath): string
    {
        return FileHelpers::relativePath($filePath);
    }
}

if (!function_exists('currentFileAndLine')) {
    /**
     * currentFileAndLine function
     *
     * @param boolean $relativePath
     *
     * @return string
     */
    function currentFileAndLine(bool $relativePath = false): string
    {
        return FileHelpers::currentFileAndLine($relativePath);
    }
}

if (!function_exists('testeParams')) {
    /**
     * formatDebugBacktrace function
     *
     * @param array $trace
     * @param boolean $relativePath
     *
     * @return string
     */
    function formatDebugBacktrace(array $trace, bool $relativePath = false): string
    {
        return FileHelpers::formatDebugBacktrace($trace, $relativePath);
    }
}

if (!function_exists('spf')) {
    /**
     * spf function  Easy way to use sprintf
     *
     *
     * ```php
     * spf('aa %s %d', 123, 34); // "aa 123 34"
     * ```
     *
     * @param string $firstString
     * @param float|int|string ...$params
     *
     * @return string
     */
    function spf(string $firstString, float|int|string ...$params): string
    {
        return StringHelpers::spf($firstString, ...$params);
    }
}

if (!function_exists('stringToArray')) {
    /**
     * stringToArray function
     *
     * @param string|null $data
     * @param string $decoder  `'unserialize', 'json_decode', 'unserialize|json_decode', 'json_decode|unserialize'`
     * @param boolean $throw
     *
     * @return array
     */
    function stringToArray(
        ?string $data,
        string $decoder = 'json_decode|unserialize',
        bool $throw = false
    ): array {
        return ArrayHelpers::stringToArray($data, $decoder, $throw);
    }
}

if (!function_exists('trueOrFalse')) {
    /**
     * function trueOrFalse
     *
     * @param mixed $value
     *
     * @return bool
     */
    function trueOrFalse(mixed $value): bool
    {
        return boolval(TrueOrFalseHelper::trueOrFalse($value));
    }
}

if (!function_exists('str_to_bool')) {
    /**
     * function str_to_bool
     *
     * @param mixed $value
     *
     * @return bool
     */
    function str_to_bool(mixed $value): bool
    {
        return boolval(TrueOrFalseHelper::trueOrFalse($value));
    }
}
