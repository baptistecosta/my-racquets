<?php

namespace AppBundle\Testing;

/**
 * Prints class name
 */
trait PrintClassNameTrait
{
    /**
     * @beforeClass
     */
    public static function printClassName()
    {
        echo "\r\n".static::class.' ';
    }
}
