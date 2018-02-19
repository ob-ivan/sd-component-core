<?php
namespace tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use SD\ComponentCore\DependencyInjection\ComponentFactoryProvider;
use SD\DependencyInjection\Container;

class ComponentFactoryAwareTraitTest extends TestCase
{
    public function testInheritAutoDeclare()
    {
        $container = new Container();
        $container->connect(new ComponentFactoryProvider([__NAMESPACE__]));
        $expectedComponentFactory = $container->get('componentFactory');
        $data = $expectedComponentFactory->create('SubclassComponent')->getData();
        $actualComponentFactory = $data['componentFactory'];
        $this->assertSame(
            $expectedComponentFactory,
            $actualComponentFactory,
            'Subclass component must return instance of component factory'
        );
    }
}
