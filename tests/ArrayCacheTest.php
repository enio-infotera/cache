<?php

namespace Odan\Test;

use Odan\Cache\Simple\ArrayCache;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;

/**
 * OpCacheTest
 *
 * @coversDefaultClass \Odan\Cache\Simple\ArrayCache
 */
class ArrayCacheTest extends TestCase
{

    /**
     * @var CacheInterface
     */
    protected $cache;

    protected function setUp()
    {
        $this->cache = new ArrayCache();
        $this->cache->clear();
    }

    /**
     * Test.
     */
    public function testInstanceOf()
    {
        $this->assertInstanceOf(ArrayCache::class, $this->cache);
    }

    /**
     * Test.
     */
    public function testHasByStringKey()
    {
        $this->cache->set('key', 'value');
        sleep(1);
        $this->assertTrue($this->cache->has('key'));
    }

    /**
     * Test exception.
     *
     * @expectedException \Psr\SimpleCache\InvalidArgumentException
     * @expectedExceptionMessage_ Cannot throw objects that do not implement Throwable
     */
    public function testGetInvalidKey()
    {
        $this->cache->get(1, 'value');
    }

    public function testGetByStringKey()
    {
        $this->cache->set('strkey', 'str key value');
        sleep(1);
        $this->assertEquals('str key value', $this->cache->get('strkey'));
    }

    /**
     * Test exception.
     *
     * @expectedException \Psr\SimpleCache\InvalidArgumentException
     * @expectedExceptionMessage_ Cannot throw objects that do not implement Throwable
     */
    public function testSetByIntKey()
    {
        $this->cache->set(2, 'value 2');
    }

    public function testDelete()
    {
        $this->cache->set('fordeletekey', 'value');
        sleep(1);
        $this->assertTrue($this->cache->has('fordeletekey'));
        $this->cache->delete('fordeletekey');
        $this->assertFalse($this->cache->has('fordeletekey'));
    }

    public function testHasStringKey()
    {
        $this->cache->set('key', 'value');
        sleep(1);
        $this->assertTrue($this->cache->has('key'));
    }

    public function testHasNotExistsStringKey()
    {
        $this->assertFalse($this->cache->has('somethingkey'));
    }

    public function testGetByStringKeyWithDefaultValue()
    {
        $this->assertEquals('default value', $this->cache->get('somenotexistingkey', 'default value'));
    }

    public function testGetByArrayKeyWithDefaultValue()
    {
        $this->assertEquals(array('table', '3'), $this->cache->get('somenotexistingkey', array('table', '3')));
    }

    /**
     * Test.
     */
    public function testMultiple()
    {
        $values = array('key' => 'value', 'key2' => 'value2');
        $keys = array_keys($values);

        $this->cache->setMultiple($values);
        sleep(1);
        $actual = $this->cache->getMultiple($keys);

        $this->assertSame($values, $actual);
    }
}
