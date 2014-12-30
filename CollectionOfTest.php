<?php namespace Stryker\Tests;

use Illuminate\Support\Collection;
use Stryker\Helpers\CollectionOf;

class CollectionOfStub extends CollectionOf {
    protected static $of_class = 'Stryker\Tests\Stub';
}

class Stub {}

class CollectionOfTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var \CollectionOfStub
     */
    protected $collection;

    public function setUp()
    {
        $this->collection = new CollectionOfStub();
    }

    public function tearDown()
    {
        unset($this->collection);
    }

    public function test_it_instantiates()
    {
        $this->assertInstanceOf('Stryker\Tests\CollectionOfStub', $this->collection);
    }

    /**
     * @expectedException \Stryker\Exceptions\IllegalCollectionMemberException
     */
    public function test_it_throws_exception_if_non_stubs_in_constructor()
    {
        $foo = new CollectionOfStub([new Stub, new Stub, 'foooooo']);
    }

    public function test_it_accepts_stubs_in_contructor()
    {
        $foo = new CollectionOfStub([new Stub, new Stub, new Stub]);
    }

    /**
     * @expectedException \Stryker\Exceptions\IllegalCollectionMemberException
     */
    public function test_put_throws_exception_when_invalid()
    {
        $this->collection->put('key', 'foo');
    }

    public function test_put_throws_no_exception_when_valid()
    {
        $stub = new Stub();
        $this->collection->put('key', $stub);
        $this->assertSame($stub, $this->collection->get('key'));
    }

    /**
     * @expectedException \Stryker\Exceptions\IllegalCollectionMemberException
     */
    public function test_push_throws_exception_when_invalid()
    {
        $this->collection->push('foo');
    }

    public function test_push_throws_no_exception_when_valid()
    {
        $stub = new Stub();
        $this->collection->push($stub);
        $this->assertSame($stub, $this->collection->first());
    }

    /**
     * @expectedException \Stryker\Exceptions\IllegalCollectionMemberException
     */
    public function test_prepend_throws_exception_when_invalid()
    {
        $this->collection->prepend('foo');
    }

    public function test_prepend_throws_no_exception_when_valid()
    {
        $stub = new Stub();
        $this->collection->prepend($stub);
        $this->assertSame($stub, $this->collection->first());
    }

    /**
     * @expectedException \Stryker\Exceptions\IllegalCollectionMemberException
     */
    public function test_merge_throws_exception_when_invalid()
    {
        $this->collection->merge(new Collection(['foo']));
    }

    public function test_merge_throws_no_exception_when_valid()
    {
        $stub = new Stub();
        $result = $this->collection->merge(new Collection([$stub]));
        $this->assertSame($stub, $result->first());
    }

    /**
     * @expectedException \Stryker\Exceptions\IllegalCollectionMemberException
     */
    public function test_make_throws_exception_when_invalid()
    {
        $this->collection->make(['foo']);
    }

    public function test_make_throws_no_exception_when_valid()
    {
        $stub = new Stub();
        $result = $this->collection->make([$stub]);
        $this->assertSame($stub, $result->first());
    }

}