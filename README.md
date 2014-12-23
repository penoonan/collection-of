#Collection Of

This is a helper class that I wrote for a project I'm working on and it's turned out to be pretty handy, so I decided to throw it up here. It's an extension of Laravel's "Illuminate\Support\Collection" class, and its purpose is to allow devs to restrict a Laravel Collection to only accept objects of a certain type. Frankly I'm surprised something like this didn't already exist and, if it turns out it does already exist, I won't be surprised.

Note: you can really, really easily use Laravel's collections outside of Laravel by requiring "illuminate\support" in your composer.json file.

Just set the fully qualified namespace of the class you want a collection of as the `$of_class` property, like so:

```php

use pno\CollectionOf;
use Fully\Qualified\Namespace\For\Foo;
use Bar;

class FooCollection extends CollectionOf {
    protected static $of_class = "Fully\Qualified\Namespace\For\Foo";
}

// All these are so incredibly valid
$all_my_glorious_foos = new FooCollection([new Foo('bar'), new Foo('baz'), new Foo('ping')]);
$all_my_glorious_foos->push(new Foo('pong'));
$all_my_glorious_foos->put('this_one_has_a_key', new Foo('blargle'));

//These would all throw an exception:
$literally_cannot_even = new FooCollection([new Bar('foo'), 'String!?!?', ['array???'], 12345]);
$literally_cannot_even->push(new Bar('fizz'));
$literally_cannot_even->put('utterly_futile_key', new Bar('buzz'));

```

That's pretty much it. Any time you try to add an item to that collection it will throw an exception if that item isn't an instance of the `$of_class`.
