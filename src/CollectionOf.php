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

    /**
     * Create a new collection instance if the value isn't one already.
     *
     * @param mixed $items
     * @return static
     */
    public static function make($items)
    {
        static::validateItemsAreOfClass($items);
        return parent::make($items);
    }

    /**
     * Merge the collection with the given items.
     *
     * @param \Illuminate\Support\Collection | \Illuminate\Contracts\Support\Arrayable|array $items
     * @return static
     */
    public function merge($items)
    {
        static::validateItemsAreOfClass($items->all());
        return parent::merge($items);
    }

    /**
     * Push an item onto the beginning of the collection.
     *
     * @param mixed $value
     * @return void
     */
    public function prepend($value)
    {
        static::validateIsOfClass($value);
        parent::prepend($value);
    }

    /**
     * Push an item onto the end of the collection.
     *
     * @param mixed $value
     * @return void
     */
    public function push($value)
    {
        static::validateIsOfClass($value);
        parent::push($value);
    }

    /**
     * Put an item in the collection by key.
     *
     * @param mixed $key
     * @param mixed $value
     * @return void
     */
    public function put($key, $value)
    {
        static::validateIsOfClass($value);
        parent::put($key, $value);
    }

    /**
     * Set the item at a given offset.
     *
     * @param mixed $key
     * @param mixed $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        static::validateIsOfClass($value);
        parent::offsetSet($key, $value);
    }

    /**
     * Validate that a single item is an instance of the required class
     * @param $value
     * @return bool
     * @throws IllegalCollectionMemberException
     */
    protected static function validateIsOfClass($value)
    {
        if (!is_a($value, static::$of_class)) {
            Throw new IllegalCollectionMemberException('Item in collection passed to ' . get_called_class() . ' is not an instance of ' . static::$of_class . '. Parameter was: ' . print_r($value, true));
        }
        return true;
    }

    /**
     * Validate that all items in a given array are instances of the required class
     * @param array $items
     * @throws IllegalCollectionMemberException
     */
    protected static function validateItemsAreOfClass(array $items)
    {
        foreach ($items as $key => $value) {
            static::validateIsOfClass($value);
        }
    }


    /**
     * @param array|Collection|\Illuminate\Support\Contracts\ArrayableInterface $items
     * @return static
     */
    public function diff($items)
    {
        return new static(array_udiff($this->items, $this->getArrayableItems($items), [$this, 'diffObjectsByReference']));
    }

    /**
     * Used in $this->diff() array_udiff call to see if two collections
     * contain the same object instances
     * @param $a
     * @param $b
     * @return int
     */
    protected function diffObjectsByReference($a, $b)
    {
        return strcmp(spl_object_hash($a), spl_object_hash($b));
    }


}