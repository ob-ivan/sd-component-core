<?php
namespace tests;

use SD\ComponentCore\DependencyInjection\ComponentFactoryAwareTrait;
use SD\ComponentCore\TwigComponent;

abstract class ParentComponent extends TwigComponent {
    use ComponentFactoryAwareTrait;
}
