<?php
namespace SD\ComponentCore;

use SD\DependencyInjection\AutoDeclarerInterface;
use SD\DependencyInjection\AutoDeclarerTrait;
use SD\DependencyInjection\DeclarerInterface;
use SD\Twig\DependencyInjection\TwigProfileAwareTrait;
use Twig_Environment;
use Twig_Profiler_Dumper_Text;
use Twig_Profiler_Profile;

abstract class TwigComponent implements
    AutoDeclarerInterface,
    DeclarerInterface,
    ComponentInterface
{
    use AutoDeclarerTrait;
    use TwigProfileAwareTrait;

    private $isDebug;
    private $twig;

    public function declareDependencies() {
        return [
            'isDebug',
            'twig',
        ];
    }

    public function setIsDebug(bool $isDebug) {
        $this->isDebug = $isDebug;
    }

    public function setTwig(Twig_Environment $twig) {
        $this->twig = $twig;
    }

    public function __toString() {
        return $this->render();
    }

    public function render(): string {
        // Get data and unfold included components' data
        profiler()->in(get_called_class() . '->getData');
        $data = $this->unfold($this->getData());
        profiler()->out(get_called_class() . '->getData');
        // Render
        profiler()->in($this->getTemplate() . '->twig->render');
        $render = $this->twig->render(
            $this->getTemplate(),
            $data
        );
        profiler()->out($this->getTemplate() . '->twig->render');
        if ($this->isDebug) {
            $dumper = new Twig_Profiler_Dumper_Text();
            profiler()->log($dumper->dump($this->twigProfile));
        }
        return $render;
    }

    abstract public function getData();

    public function getTemplate() {
        return str_replace('_', '/', get_called_class());
    }

    private function unfold(array $data): array {
        foreach ($data as $key => $value) {
            if ($value instanceof ComponentInterface) {
                profiler()->in(get_class($value) . '->getData');
                $subdata = $this->unfold($value->getData());
                profiler()->out(get_class($value) . '->getData');
                $data[$key] = [
                    'template' => $value->getTemplate(),
                    'data' => $subdata,
                ];
            } elseif (is_array($value)) {
                $data[$key] = $this->unfold($value);
            }
        }
        return $data;
    }
}
