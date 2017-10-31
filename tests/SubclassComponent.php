<?php
namespace tests;

class SubclassComponent extends ParentComponent {
    public function getData(): array {
        return [
            'componentFactory' => $this->getComponentFactory(),
        ];
    }
}
