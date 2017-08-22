<?php
namespace tests;

use SD\ComponentCore\ComponentInterface;

class HelloWorld implements ComponentInterface {
    public function render(): string {
        return '';
    }
}
