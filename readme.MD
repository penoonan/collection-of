#Collection Of

This is an extension of Laravel's "Illuminate\Support\Collection" class, which restricts the collection to objects of a certain type.

Just set the fully qualified namespace of the class you want a collection of as the `$of_class` property, like so:

```php

use Fully\Qualified\Namespace\For\Foo;
use pno\CollectionOf;

class FooCollection extends CollectionOf {
    protected static $of_class = "Fully\Qualified\Namespace\For\Foo";
}

$all_my_glorious_foos = new FooCollection([new Foo('bar'), new Foo('baz'), new Foo('ping')]);
$all_my_glorious_foos->push(new Foo('pong'));
$all_my_glorious_foos->put('this_one_has_a_key', new Foo('blargle'));

//These will throw an error:
$literally_cannot_even = new FooCollection([new Bar('foo'), 'String!?!?', ['array???'], 12345]);
$literally_cannot_even->push(new Bar('fizz');
$literally_cannot_even->put('futile_key', new Bar('buzz'));
```

That's pretty much it. Any time you try to add an item to that collection it will throw an exception if that item isn't an instance of the `$of_class`.