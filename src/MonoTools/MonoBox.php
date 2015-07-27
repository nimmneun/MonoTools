<?php

namespace MonoTools;

class MonoBox
{
    private static $medoo;

    public static function getMedoo()
    {
        if (null === self::$medoo) {
            self::$medoo = new Medoo(
                array(
                    'database_type' => 'mysql',
                    'database_name' => 'local',
                    'server'        => 'localhost',
                    'username'      => 'root',
                    'password'      => '',
                    'charset'       => 'utf8'
                )
            );
        }

        return self::$medoo;
    }

    public static function arrayToObject($entity, $row)
    {
        $object = new $entity();

        foreach ($row as $key => $value) {
            $setter = 'set' . MonoBox::camelize($key);

            if (method_exists($object, $setter)) {
                $object->$setter($value);
            }
        }

        return $object;
    }

    public static function objectToArray($object)
    {
        $columns = array();

        /** @var EntityInterface $entity */
        foreach ($object->toArray() as $key => $value) {
            $column = MonoBox::decamelize($key);
            $columns[$column] = $value;
        }

        return $columns;
    }

    public static function decamelize($string)
    {
        return ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', $string)), '_');
    }

    public static function camelize($string)
    {
        return str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
    }
}
