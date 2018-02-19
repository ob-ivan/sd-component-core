<?php
namespace tests;

use PHPUnit\Framework\TestCase;
use SD\ComponentCore\DependencyInjection\ComponentFactoryProvider;
use SD\DependencyInjection\Container;

class AwareTraitTest extends TestCase {
    public function testInheritAutoDeclare() {
        $container = new Container();
        $container->connect(new ComponentFactoryProvider(['tests']));
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
