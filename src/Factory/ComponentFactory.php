<?php
namespace SD\ComponentCore\Factory;

use SD\ComponentCore\ComponentInterface;
use SD\DependencyInjection\AutoDeclarerInterface;
use SD\DependencyInjection\AutoDeclarerTrait;
use SD\DependencyInjection\ContainerAwareTrait;

class ComponentFactory implements AutoDeclarerInterface, ComponentFactoryInterface {
    use AutoDeclarerTrait;
    use ContainerAwareTrait;

    private $namespaces = [];

    public function __construct(array $namespaces = []) {
        $this->namespaces = array_map('strval', $namespaces);
    }

    public function addNamespace(string $namespace) {
        $this->namespaces[] = $namespace;
    }

    public function map(string $componentName, array $parameterArray): array {
        return array_map(
            function (...$parameters) use ($componentName) {
                return $this->create($componentName, ...$parameters);
            },
            $parameterArray
        );
    }

    public function create(string $componentName, ...$parameters): ComponentInterface {
        $componentClass = $this->getComponentClass($componentName);
        foreach ($this->namespaces as $namespace) {
            $className = $namespace . $componentClass;
            if (class_exists($className)) {
                return $this->getContainer()->produce(function () use ($className, $parameters) {
                    return new $className(...$parameters);
                });
            }
        }
        throw new ComponentFactoryException(
            "Unknown component name '$componentName' with class '$componentClass'"
        );
    }

    private function getComponentClass(string $componentName): string {
        return preg_replace('/([a-z]+):/i', '$1_$1', $componentName);
    }
}
