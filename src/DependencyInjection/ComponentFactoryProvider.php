<?php
namespace SD\ComponentCore\DependencyInjection;

use SD\ComponentCore\Factory\ComponentFactory;
use SD\DependencyInjection\ProviderInterface;

class ComponentFactoryProvider implements ProviderInterface {
    public function getServiceName(): string {
        return 'componentFactory';
    }

    public function provide() {
        return new ComponentFactory();
    }
}
