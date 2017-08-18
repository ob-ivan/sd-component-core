<?php
namespace SD\ComponentCore\Factory;

use SD\ComponentCore\ComponentInterface;

interface ComponentFactoryInterface {
    /**
     * @param  string $componentName
     * @param  array  $parameters
     * @return ComponentInterface
    **/
    public function create(string $componentName, ...$parameters): ComponentInterface;
}
