<?php
namespace SD\ComponentCore\DependencyInjection;

use SD\ComponentCore\Factory\ComponentFactoryInterface;

trait ComponentFactoryAwareTrait {
    private $componentFactory;

    public function setComponentFactory(ComponentFactoryInterface $componentFactory) {
        $this->componentFactory = $componentFactory;
    }
}
