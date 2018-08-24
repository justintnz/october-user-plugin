<?php namespace TinTrang\Tuser;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name'        => 'T User',
            'description' => 'Plugin Assigment ',
            'author'      => 'Tin Trang',
            'icon'        => 'icon-leaf'
        ];
    }


    public function registerComponents()
    {
        return [
            'TinTrang\TUser\Components\LoginForm' => 'loginForm',
            'TinTrang\TUser\Components\Account' => 'account',
            'TinTrang\TUser\Components\TSession' => 'tsession',

        ];
    }

    public function registerSettings()
    {
    }
}
