<?php
namespace tests\DependencyInjection;

class SubclassComponent extends ParentComponent
{
    public function getData(): array
    {
        return [
            'componentFactory' => $this->getComponentFactory(),
        ];
    }
}
