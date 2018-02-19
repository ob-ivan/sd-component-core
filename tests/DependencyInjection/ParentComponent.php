<?php
namespace tests\DependencyInjection;

use SD\ComponentCore\DependencyInjection\ComponentFactoryAwareTrait;
use SD\ComponentCore\ComponentInterface;
use SD\DependencyInjection\AutoDeclarerInterface;
use SD\DependencyInjection\AutoDeclarerTrait;

abstract class ParentComponent implements AutoDeclarerInterface, ComponentInterface
{
    use AutoDeclarerTrait;
    use ComponentFactoryAwareTrait;

    public function render(): string
    {
        return print_r($this->getData(), true);
    }

    abstract public function getData(): array;
}
