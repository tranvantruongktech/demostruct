<?php

namespace TCore\Base\Traits;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use TCore\Base\Supports\Helper;

trait LoadAndPublishData
{

    protected function loadComponents(string $type = null): self
    {
        if($type == null)
        {
            $type = 'TCore';
        }
        $type .= '\\' . ucfirst($this->getName()); 

        Blade::componentNamespace($type . '\\Views\\Components', $this->getUnderlineNamespace());

        return $this;
    }
    
    protected function loadMigrations(): self
    {
        $paths = $this->getPath('database/migrations');
        
        $this->loadMigrationsFrom($paths);

        return $this;
    }

    protected function loadViews(): self
    {
        $viewPaths = $this->getPath('resources/views');
        
        $this->loadViewsFrom($viewPaths, $this->getUnderlineNamespace());

        return $this;
    }

    protected function loadLanguages(): self
    {
        $langPaths = $this->getPath('lang');
        
        $this->loadTranslationsFrom($langPaths, $this->getUnderlineNamespace());
        $this->loadJsonTranslationsFrom($langPaths);

        return $this;
    }

    protected function loadRoutes(): self
    {
        $routesPaths = $this->getFilesInFolder('routes');
        
        foreach($routesPaths as $routePath)
        {
            $this->loadRoutesFrom($routePath);
        }

        return $this;
    }

    protected function loadConfig(): self
    {
        $configPaths = $this->getFilesInFolder('config');

        foreach($configPaths as $configPath)
        {
            $this->mergeConfigFrom($configPath, $this->getUnderlineNamespace() .  '_' . pathinfo($configPath, PATHINFO_FILENAME));
        }

        return $this;
    }

    protected function loadHeplers(): self
    {
        Helper::autoload($this->getPath('helpers'));

        return $this;
    }

    protected function getPath(string $path = null): string
    {
        $reflection = new \ReflectionClass($this);

        $modulePath = str_replace('/src/Providers', '', File::dirname($reflection->getFileName()));

        return $modulePath . ($path ? '/' . ltrim($path, '/') : '');
    }

    protected function getName(): string
    {
        return basename($this->getNamespace());
    }

    protected function getNamespace(): string
    {
        return str_replace(platform_path(), '', $this->getPath());
    }

    protected function getUnderlineNamespace(): string
    {
        return str_replace('/', '_', $this->getNamespace());
    }

    protected function getFilesInFolder(string $folderName): array
    {
        $files = File::glob($this->getPath($folderName) . '/*.php');

        return $files;
    }
}