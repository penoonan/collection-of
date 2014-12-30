<?php namespace pno\CollectionOf;

use \Illuminate\Support\Collection;

abstract class CollectionOf extends Collection {

    /**
     * The fully qualified namespace of the class
     * that this is a collection of
     * @var string
     */
    protected static $of_class;

    public function __construct(array $items = [])
    {
        static::validateItemsAreOfClass($items);
        parent::__construct($items);
    }

    public static function make($items)
    {
        static::validateItemsAreOfClass($items);
        parent::make($items);
    }

    public function merge($items)
    {
        static::validateItemsAreOfClass($items);
        parent::merge($items);
    }

    public function prepend($value)
    {
        static::validateIsOfClass($value);
        parent::prepend($value);
    }

    public function push($value)
    {
        static::validateIsOfClass($value);
        parent::push($value);
    }

    public function put($key, $value)
    {
        static::validateIsOfClass($value);
        parent::put($key, $value);
    }

    protected static function validateIsOfClass($value)
    {
        if (!is_a($value, static::$of_class)) {
            Throw new IllegalCollectionMemberException('Item in collection passed to '.get_called_class().' is not an instance of '.static::$of_class.'. Parameter was: ' . print_r($value, true));
        }
        return true;
    }

    protected static function validateItemsAreOfClass(array $items) {
        foreach($items as $key => $value) {
            static::validateIsOfClass($value);
        }
    }

}