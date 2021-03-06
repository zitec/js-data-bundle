<?php

namespace Zitec\JSDataBundle\Utils;

/**
 * Encapsulates a set of common helper functions.
 */
class Common
{
    /**
     * Given a set of arrays as arguments, it merges them recursively. The key difference between this function
     * and the native array_merge_recursive() is that it only merges same-key values when both are arrays.
     * Otherwise, it will behave exactly like array_merge(), by keeping the latter value.
     *
     * @example
     * array_merge_recursive(['a' => ['a', 'b'], 'x' => 0], ['a' => ['c'], 'x' => 1])
     * => ['a' => ['a', 'b', 'c'], 'x' => [0, 1]]
     *
     * mergeArraysRecursive(['a' => ['a', 'b'], 'x' => 0], ['a' => ['c'], 'x' => 1])
     * => ['a' => ['a', 'b', 'c'], 'x' => 1]
     *
     * @link https://api.drupal.org/api/drupal/includes%21bootstrap.inc/function/drupal_array_merge_deep/7
     *
     * @param array ...$arrays
     * - a variable number of arrays to merge;
     *
     * @return array
     */
    public static function mergeArraysRecursive(array ...$arrays)
    {
        $result = array();

        foreach ($arrays as $array) {
            foreach ($array as $key => $value) {
                if (is_int($key)) {
                    // Values with numeric keys are always appended, as is done in array_merge().
                    $result[] = $value;
                } elseif (isset($result[$key]) && is_array($result[$key]) && is_array($value)) {
                    // Merge recursively same string key arrays.
                    $result[$key] = self::mergeArraysRecursive($result[$key], $value);
                } else {
                    $result[$key] = $value;
                }
            }
        }

        return $result;
    }
}
