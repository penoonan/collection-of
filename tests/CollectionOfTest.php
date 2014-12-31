<?php

use Illuminate\Support\Collection;
use pno\CollectionOf\CollectionOf;

class CollectionOfStub extends CollectionOf {
    protected static $of_class = 'Stub';
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
        $this->assertInstanceOf('CollectionOfStub', $this->collection);
    }

    /**
     * @expectedException \pno\CollectionOf\IllegalCollectionMemberException
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
     * @expectedException \pno\CollectionOf\IllegalCollectionMemberException
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
     * @expectedException \pno\CollectionOf\IllegalCollectionMemberException
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
     * @expectedException \pno\CollectionOf\IllegalCollectionMemberException
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
     * @expectedException \pno\CollectionOf\IllegalCollectionMemberException
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

    public function test_merge_result_is_instance_of_given_collection()
    {
        $stub = new Stub();
        $result = $this->collection->merge(new Collection([$stub]));
        $this->assertInstanceOf('CollectionOfStub', $result);
    }

    /**
     * @expectedException \pno\CollectionOf\IllegalCollectionMemberException
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

    public function test_make_result_is_instance_of_given_collection()
    {
        $stub = new Stub();
        $result = $this->collection->make([$stub]);
        $this->assertInstanceOf('CollectionOfStub', $result);
    }

    /**
     * @expectedException \pno\CollectionOf\IllegalCollectionMemberException
     */
    public function test_offsetSet_throws_exception_when_invalid_with_key_given()
    {
        $this->collection['foo'] = 'bar';
    }

    /**
     * @expectedException \pno\CollectionOf\IllegalCollectionMemberException
     */
    public function test_offsetSet_throws_exception_when_invalid_without_key_given()
    {
        $this->collection[] = 'bar';
    }

    public function test_offsetSet_throws_no_exception_when_valid()
    {
        $this->collection[] = new Stub();
        $this->collection['stub'] = new Stub();

        $this->assertEquals(2, $this->collection->count());
    }

}