<?php
namespace SD\ComponentCore\DependencyInjection;

use SD\ComponentCore\Factory\ComponentFactory;
use SD\DependencyInjection\ProviderInterface;

class ComponentFactoryProvider implements ProviderInterface {
    private $namespaces;

    public function __construct(array $namespaces = []) {
        $this->namespaces = array_map('strval', $namespaces);
    }

    public function getServiceName(): string {
        return 'componentFactory';
    }

    public function provide() {
        return new ComponentFactory($this->namespaces);
    }
}
