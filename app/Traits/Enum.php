<?php

/**
 * This file defines the Enum trait used within the application.
 *
 * The Enum trait provides utility methods for working with PHP enums,
 * allowing for easier and more readable access to enum names, values,
 * and cases. It includes methods for retrieving an array of enum names
 * and values, as well as searching for a specific enum case by name or value.
 * Additionally, the trait implements a magic method to facilitate static
 * method calls to enum cases, throwing an exception if the requested case
 * does not exist.
 *
 * @category Traits
 * @package  App\Traits
 * @author   Kareem Mohamed <kareemshaaban221@gmail.com>
 */

namespace App\Traits;

use App\Exceptions\Api\ApiBaseException;

trait Enum
{
    /**
     * Return an array of enum names.
     *
     * @return string[]
     */
    public static function names(): array
    {
        return array_column(static::cases(), 'name');
    }

    /**
     * Return an array of enum values.
     *
     * @return mixed[]
     */
    public static function values(): array
    {
        return array_column(static::cases(), 'value');
    }

    /**
     * Returns an associative array of enum values to names.
     *
     * Example:
     * [
     *     'value1' => 'name1',
     *     'value2' => 'name2',
     *     ...
     * ]
     *
     * @return array
     */
    public static function array(): array
    {
        return array_combine(static::values(), static::names());
    }

    /**
     * Search for an enum value or name and return the matching case instance.
     *
     * @param string|int $type
     * @return static|null
     */
    public static function search($type): ?static
    {
        foreach (static::cases() as $case) {
            if ($case->value == $type || $case->name == $type) {
                return $case;
            }
        }
        return null;
    }

    public static function toString($delimiter = ','): string
    {
        return implode($delimiter, static::values());
    }

    /**
     * Magic method to allow static calling of enum cases as methods.
     *
     * This method enables the retrieval of enum case values by calling the case name
     * statically as a method. If the method name matches an enum case name, the corresponding
     * case value is returned. If no matching case is found, an ApiBaseException is thrown.
     *
     * @param string $method The name of the method being called, expected to match a case name.
     * @param array $args The arguments passed to the method, not used in this implementation.
     * @return mixed The value of the matching enum case.
     * @throws ApiBaseException If no matching enum case is found for the given method name.
     */
    public static function __callStatic($method, $args) {
        foreach (static::cases() as $case) {
            if ($case->name === $method) {
                return $case->value;
            }
        }
        $className = static::class;
        throw new ApiBaseException("[$className] Method [$method] does not exist.");
    }
}
