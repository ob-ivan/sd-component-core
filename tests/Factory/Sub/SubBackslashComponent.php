<?php
namespace tests\Factory\Sub;

use SD\ComponentCore\ComponentInterface;

class SubBackslashComponent implements ComponentInterface
{
    public function render(): string
    {
        return '';
    }
}
