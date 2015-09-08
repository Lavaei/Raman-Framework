<?php

namespace Doctrine\Tests\ORM\Tools;

use Doctrine\ORM\Tools\Setup;
use Doctrine\Common\Cache\ArrayCache;

class SetupTest extends \Doctrine\Tests\OrmTestCase
{
    private $originalAutoloaderCount;
    private $originalIncludePath;

    public function setUp()
    {
        if (strpos(\Doctrine\ORM\Version::VERSION, "DEV") === false) {
            $this->markTestSkipped("Test only runs in a dev-installation from Github");
        }

        $this->originalAutoloaderCount = count(spl_autoload_functions());
        $this->originalIncludePath = get_include_path();
    }

    public function tearDown()
    {
        if ( ! $this->originalIncludePath) {
            return;
        }

        set_include_path($this->originalIncludePath);
        $loaders = spl_autoload_functions();
        for ($i = 0; $i < count($loaders); $i++) {
            if ($i > $this->originalAutoloaderCount+1) {
                spl_autoload_unregister($loaders[$i]);
            }
        }
    }

    public function testDirectoryAutoload()
    {
        Setup::registerAutoloadDirectory(__DIR__ . "/../../../../../vendor/doctrine/common/lib");

        $this->assertEquals($this->originalAutoloaderCount + 2, count(spl_autoload_functions()));
    }

    public function testAnnotationConfiguration()
    {
        $config = Setup::createAnnotationMetadataConfiguration(array(), true);

        $this->assertInstanceOf('Doctrine\ORM\Configuration', $config);
        $this->assertEquals(sys_get_temp_dir(), $config->getProxyDir());
        $this->assertEquals('DoctrineProxies', $config->getProxyNamespace());
        $this->assertInstanceOf('Doctrine\ORM\Mapping\Driver\AnnotationDriver', $config->getMetadataDriverImpl());
    }

    public function testXMLConfiguration()
    {
        $config = Setup::createXMLMetadataConfiguration(array(), true);

        $this->assertInstanceOf('Doctrine\ORM\Configuration', $config);
        $this->assertInstanceOf('Doctrine\ORM\Mapping\Driver\XmlDriver', $config->getMetadataDriverImpl());
    }

    public function testYAMLConfiguration()
    {
        $config = Setup::createYAMLMetadataConfiguration(array(), true);

        $this->assertInstanceOf('Doctrine\ORM\Configuration', $config);
        $this->assertInstanceOf('Doctrine\ORM\Mapping\Driver\YamlDriver', $config->getMetadataDriverImpl());
    }

    /**
     * @group DDC-1350
     */
    public function testConfigureProxyDir()
    {
        $config = Setup::createAnnotationMetadataConfiguration(array(), true, "/foo");
        $this->assertEquals('/foo', $config->getProxyDir());
    }

    /**
     * @group DDC-1350
     */
    public function testConfigureCache()
    {
        $cache = new ArrayCache();
        $config = Setup::createAnnotationMetadataConfiguration(array(), true, null, $cache);

        $this->assertSame($cache, $config->getResultCacheImpl());
        $this->assertSame($cache, $config->getMetadataCacheImpl());
        $this->assertSame($cache, $config->getQueryCacheImpl());
    }

    /**
     * @group DDC-3190
     */
    public function testConfigureCacheCustomInstance()
    {
        $cache = $this->getMock('Doctrine\Common\Cache\Cache');
        $cache->expects($this->never())->method('setNamespace');

        $config = Setup::createConfiguration(array(), true, $cache);

        $this->assertSame($cache, $config->getResultCacheImpl());
        $this->assertSame($cache, $config->getMetadataCacheImpl());
        $this->assertSame($cache, $config->getQueryCacheImpl());
    }
}
