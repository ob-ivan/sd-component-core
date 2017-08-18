<?php
namespace SD\ComponentCore\Factory\DependencyInjection;

use SD\ComponentCore\Factory\Factory;
use SD\DependencyInjection\ProviderInterface;

class ComponentFactoryProvider implements ProviderInterface {
    public function getServiceName(): string {
        return 'componentFactory';
    }

    public function provide() {
        return new Factory();
    }
}
