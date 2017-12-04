<?php

namespace App\Extension;

class ModuleLoader extends \Nette\DI\CompilerExtension
{
    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();

        $menuItems = [];
        $junctionItems = [];

        /** @var \Nette\Utils\Finder $files */
        $files = \Nette\Utils\Finder::findFiles('Module.php')
            ->from(__DIR__ . '/../module')
            ->limitDepth(2);

        /** @var \SplFileInfo $file */
        foreach ($files as $file)
        {
            require $file->getPathname();
        }

        foreach (get_declared_classes() as $class)
        {
            $reflection = new \ReflectionClass($class);

            if ($reflection->implementsInterface(\App\IWebmodModule::class))
            {
                /** @var \App\IWebmodModule $class */

                $menuItems[$class::getName()] = $class::getMenu();
                $junctionItems[$class::getName()] = $class::getJunction();
            }
        }


        $builder->addDefinition($this->prefix('menu'))
            ->setClass(\App\Extension\Menu::class)
            ->setArguments(['items' => $menuItems]);
        $builder->addAlias('menu', $this->prefix('menu'));

        $builder->addDefinition($this->prefix('junction'))
            ->setClass(\App\Extension\Junction::class)
            ->setArguments(['items' => $junctionItems]);
        $builder->addAlias('junction', $this->prefix('junction'));
    }
}
