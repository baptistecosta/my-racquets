<?php

namespace AppBundle\Testing\Fixtures;

use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Replaces fixtures references in an array
 */
class FixturesReferenceReplacer
{
    /**
     * Replaces references in array values (recursively)
     *
     * @param array|string $value
     * @param array        $references
     *
     * @return mixed
     */
    public static function replace($value, array $references)
    {
        if (is_array($value)) {
            foreach ($value as &$subValue) {
                $subValue = self::replace($subValue, $references);
            }

            return $value;
        } else {
            if (1 === preg_match('/\@([a-z0-9._]*)\->([a-zA-Z0-9]*)/', $value, $matches)) {
                $accessor = PropertyAccess::createPropertyAccessor();
                $value = str_replace(
                    $matches[0],
                    $accessor->getValue($references[$matches[1]], $matches[2]),
                    $value
                );
            }

            return $value;
        }
    }
}
