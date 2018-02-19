<?php
namespace tests\Factory;

use SD\ComponentCore\ComponentInterface;

class HelloWorldComponent implements ComponentInterface
{
    public function render(): string
    {
        return 'Hello World';
    }
}
