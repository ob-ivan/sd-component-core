<?php
namespace tests\Sub;

use SD\ComponentCore\ComponentInterface;

class SubBackslash implements ComponentInterface {
    public function render(): string {
        return '';
    }
}
