<?php
namespace tests;

use PHPUnit\Framework\TestCase;
use SD\ComponentCore\Factory\ComponentFactory;
use SD\ComponentCore\Factory\ComponentFactoryException;
use SD\DependencyInjection\Container;
use tests_Sub_SubSpace;

class ComponentFactoryTest extends TestCase {
    public function testCreateNoNamespace() {
        $factory = new ComponentFactory();
        $this->expectException(ComponentFactoryException::class);
        $factory->create('whatever');
    }

    public function testCreateNonExistent() {
        $factory = new ComponentFactory(['tests']);
        $this->expectException(ComponentFactoryException::class);
        $factory->create('NonExistent');
    }

    public function testCreateSimple() {
        $factory = new ComponentFactory(['tests']);
        $factory->setContainer(new Container());
        $component = $factory->create('HelloWorld');
        $this->assertInstanceOf(HelloWorld::class, $component, 'Must return instance of HelloWorld component');
    }

    public function testCreateUnderscoreWithExpand() {
        $factory = new ComponentFactory(['tests_']);
        $factory->setContainer(new Container());
        $component = $factory->create('Sub:Space');
        $this->assertInstanceOf(tests_Sub_SubSpace::class, $component, 'Must return instance of tests_Sub_SubSpace component');
    }
}
