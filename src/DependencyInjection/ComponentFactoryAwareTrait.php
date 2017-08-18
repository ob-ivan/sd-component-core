<?php
namespace SD\ComponentCore\DependencyInjection;

use SD\ComponentCore\Factory\ComponentFactoryInterface;

trait ComponentFactoryAwareTrait {
    private $autoDeclareComponentFactory = 'componentFactory';
    private $componentFactory;

    public function setComponentFactory(ComponentFactoryInterface $componentFactory) {
        $this->componentFactory = $componentFactory;
    }

    public function getComponentFactory(): ComponentFactoryInterface {
        return $this->componentFactory;
    }
}
