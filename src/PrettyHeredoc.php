<?php

namespace Sadovnik\PrettyHeredoc;

use Sadovnik\PrettyHeredoc\Exceptions\InvalidArgumentException;

/**
 * @param string $input
 * @return string
 */
function ph($input)
{
    if (!is_string($input)) {
        throw new InvalidArgumentException('The argument must be string');
    }

    /**
     * @param string $line
     * @return integer
     */
    $leftSpaceCount = function ($line) {
        return strlen($line) - strlen(ltrim($line));
    };

    /**
     * @param array $lines
     * @return integer
     */
    $getSpaceIdentationLevel = function ($lines) use (&$leftSpaceCount) {
        $linesWithoutIdentation = array_filter(
            $lines,
            function ($line) {
                return !empty(trim($line));
            }
        );

        $levels = array_map(
            function ($item) use (&$leftSpaceCount) {
                return $leftSpaceCount($item);
            },
            $linesWithoutIdentation
        );

        return min($levels);
    };

    /**
     * @param string $line
     * @param integer $count
     * @return string
     */
    $substractFirstCharacters = function ($line, $count) {
        return substr($line, $count);
    };

    /**
     * @param array $lines
     * @param integer $identationLevel
     * @return array
     */
    $substractIdentation = function (
        $lines,
        $identationLevel
    ) use (
        &$substractFirstCharacters
    ) {
        return array_map(
            function ($line) use (&$substractFirstCharacters, &$identationLevel) {
                return $substractFirstCharacters($line, $identationLevel);
            },
            $lines
        );
    };

    /**
     * @param array $lines
     * @return bool
     */
    $linesAreEmpty = function ($lines) {
        foreach ($lines as $line) {
            if (!empty(trim($line))) {
                return false;
            }
        }

        return true;
    };

    /**
     * @param array $lines
     * @return array
     */
    $removeFramingLines = function ($lines) {
        return array_slice($lines, 1, sizeof($lines) - 2);
    };

    $rawLines = explode(PHP_EOL, $input);

    if (sizeof($rawLines) < 3) {
        return '';
    }

    $lines = $removeFramingLines($rawLines);

    if ($linesAreEmpty($lines)) {
        return '';
    }

    $identationLevel = $getSpaceIdentationLevel($lines);
    $prettyLines = $substractIdentation($lines, $identationLevel);

    return implode(PHP_EOL, $prettyLines);
}
