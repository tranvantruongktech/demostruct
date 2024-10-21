<?php

use Illuminate\Support\Facades\Vite;

if (! function_exists('theme_asset')) {
    function theme_asset(string $module, string $file = null): string
    {
        return platform_resource('theme', $module) . ($file ? '/' .  ltrim($file, '/') : '');
    }
}

if (! function_exists('module_asset')) {
    function module_asset(string $module, string $file = null): string
    {
        return platform_resource('modules', $module) . ($file ? '/' .  ltrim($file, '/') : '');
    }
}

if (! function_exists('core_asset')) {
    function core_asset(string $module, string $file = null): string
    {
        return platform_resource('core', $module) . ($file ? '/' . ltrim($file, '/') : '');
    }
}

if (! function_exists('platform_resource')) {
    function platform_resource(string $type, string $module): string
    {
        return "platform/{$type}/{$module}/resources";
    }
}

if (! function_exists('vite_module_asset')) {
    function vite_module_asset(string $module, string $path): string
    {
        return Vite::asset(module_asset($module, $path));
    }
}

if (! function_exists('vite_asset')) {
    function vite_asset(string $path): string
    {
        return Vite::asset($path);
    }
}

if (! function_exists('platform_path')) {
    function platform_path(string|null $path = null): string
    {
        return base_path('platform/' . $path);
    }
}

if (! function_exists('core_path')) {
    function core_path(string|null $path = null): string
    {
        return platform_path('core/' . $path);
    }
}

if (! function_exists('modules_path')) {
    function modules_path(string|null $path = null): string
    {
        return platform_path('modules/' . $path);
    }
}

if (! function_exists('themes_path')) {
    function themes_path(string|null $path = null): string
    {
        return platform_path('themes/' . $path);
    }
}