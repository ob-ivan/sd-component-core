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
        $tried = [];
        foreach ($this->namespaces as $namespace) {
            foreach ($this->getClassNames($namespace, $componentName) as $className) {
                if (class_exists($className)) {
                    return $this->getContainer()->produce(new $className(...$parameters));
                }
                $tried[] = $className;
            }
        }
        throw new ComponentFactoryException(
            "Unknown component name '$componentName', tried classnames: '" . implode("', '", $tried) . "'"
        );
    }

    private function getClassNames(string $namespace, string $componentName): array {
        $hasUnderscore = false !== strpos($namespace, '_') || false !== strpos($componentName, '_');
        $classNames = [];
        foreach ($this->getPrefixes($namespace, $hasUnderscore) as $prefix) {
            foreach ($this->getExpands($componentName, $hasUnderscore) as $expand) {
                $classNames[] = $prefix . $expand;
            }
        }
        return $classNames;
    }

    private function getPrefixes(string $namespace, bool $hasUnderscore): array {
        $lastChar = substr($namespace, -1);
        if ($lastChar === '_' || $lastChar === '\\') {
            return [$namespace];
        }
        $prefixes = [$namespace . '\\'];
        if ($hasUnderscore) {
            $prefixes[] = $namespace . '_';
        }
        return $prefixes;
    }

    private function getExpands(string $componentName, bool $hasUnderscore): array {
        if (false === strpos($componentName, ':')) {
            return [$componentName];
        }
        $separators = ['\\\\'];
        if ($hasUnderscore) {
            $separators[] = '_';
        }
        return array_map(
            function ($separator) use ($componentName) {
                return preg_replace('/([a-z]+):/i', '$1' . $separator . '$1', $componentName);
            },
            $separators
        );
    }
}
