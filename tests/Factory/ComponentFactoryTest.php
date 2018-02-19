<?php
namespace tests\Factory;

use PHPUnit\Framework\TestCase;
use SD\ComponentCore\Factory\ComponentFactory;
use SD\ComponentCore\Factory\Exception\NoContainerException;
use SD\ComponentCore\Factory\Exception\NoNamespaceException;
use SD\ComponentCore\Factory\Exception\UnknownComponentException;
use SD\DependencyInjection\Container;
use tests\Factory\Sub\SubBackslashComponent;
use tests_Factory_Sub_SubUnderscoreComponent;

class ComponentFactoryTest extends TestCase
{
    public function testCreateNoNamespaceException()
    {
        $factory = new ComponentFactory();
        $this->expectException(NoNamespaceException::class);
        $factory->create('whatever');
    }

    public function testCreateUnknownComponentException()
    {
        $factory = new ComponentFactory([__NAMESPACE__]);
        $this->expectException(UnknownComponentException::class);
        $factory->create('UnknownComponent');
    }

    public function testCreateNoContainerException()
    {
        $factory = new ComponentFactory([__NAMESPACE__]);
        $this->expectException(NoContainerException::class);
        $factory->create('HelloWorldComponent');
    }

    public function testCreateSimple()
    {
        $factory = new ComponentFactory([__NAMESPACE__]);
        $factory->setContainer(new Container());
        $component = $factory->create('HelloWorldComponent');
        $this->assertInstanceOf(
            HelloWorldComponent::class,
            $component,
            'Must return instance of HelloWorldComponent'
        );
    }

    public function testCreateUnderscoreWithExpand()
    {
        $factory = new ComponentFactory();
        $factory->addNamespace(str_replace('\\', '_', __NAMESPACE__));
        $factory->setContainer(new Container());
        $component = $factory->create('Sub:UnderscoreComponent');
        $this->assertInstanceOf(
            tests_Factory_Sub_SubUnderscoreComponent::class,
            $component,
            'Must expand component name with underscores'
        );
    }

    public function testCreateBackslashWithExpand()
    {
        $factory = new ComponentFactory();
        $facotyr->addNamespace(__NAMESPACE__ . '\\');
        $factory->setContainer(new Container());
        $component = $factory->create('Sub:BackslashComponent');
        $this->assertInstanceOf(
            SubBackslashComponent::class,
            $component,
            'Must expand component name with backslashes'
        );
    }
}
