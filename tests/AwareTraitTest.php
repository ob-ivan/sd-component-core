<?php
namespace tests;

use PHPUnit\Framework\TestCase;
use SD\ComponentCore\DependencyInjection\ComponentFactoryProvider;
use SD\DependencyInjection\Container;
use Twig_Environment;
use Twig_Loader_Array;
use Twig_Profiler_Profile;

class AwareTraitTest extends TestCase {
    public function testInheritAutoDeclare() {
        $container = new Container(
            [
                'isDebug' => false,
                'twig' => new Twig_Environment(new Twig_Loader_Array([])),
                'twigProfile' => new Twig_Profiler_Profile(),
            ],
            'container'
        );
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
