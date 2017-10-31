<?php
namespace tests;

class SubclassComponent extends ParentComponent {
    public function getData() {
        return [
            'componentFactory' => $this->getComponentFactory(),
        ];
    }
}
