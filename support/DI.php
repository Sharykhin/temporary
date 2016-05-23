<?php

namespace Support;

use Exceptions\InterfaceNotBoundableException;

/**
 * Class DI
 * @package Support
 */
class DI
{
    /**
     * @param $className
     * @return object
     */
    public static function create($className)
    {
        if (!is_string($className)) {
            throw new \InvalidArgumentException('Class name must be string');
        }
        $className = new \ReflectionClass($className);
        $depParameters = is_null($className->getConstructor()) ? [] : $className->getConstructor()->getParameters();
        $newParams = [];
        foreach ($depParameters as $parameter) {
           if($parameter->getClass()) {
               if($parameter->getClass()->isInterface()) {
                    if (isset(self::getServiceContainer()[$parameter->getClass()->getName()])) {
                        $bindClass = self::getServiceContainer()[$parameter->getClass()->getName()];
                    } else {
                        throw new InterfaceNotBoundableException('Interface ' . $parameter->getClass()->getName() .
                            ' is not instantiable');
                    }
                   $newParams[] = self::create($bindClass);
               } else {
                   $newParams[] = self::create($parameter->getClass()->getName());
               }
           }
        }

        return $className->newInstanceArgs($newParams);

    }

    /**
     * @return string
     */
    private static function getServiceContainer()
    {
        return require(__DIR__ . '/../config/service_container.php');
    }
}