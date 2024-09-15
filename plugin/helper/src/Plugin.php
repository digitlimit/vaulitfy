<?php

namespace DigitLimit\Helper;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class Plugin implements PluginInterface, EventSubscriberInterface
{
    protected $composer;
    protected $generator;

    public function activate(Composer $composer, IOInterface $io)
    {
        $this->composer = $composer;
        $this->generator = new AutoloadGenerator($composer->getEventDispatcher(), $io);
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {
        // No deactivation logic needed
    }

    public function uninstall(Composer $composer, IOInterface $io)
    {
        // No uninstallation logic needed
    }

    public static function getSubscribedEvents()
    {
        return [
            'post-autoload-dump' => 'dumpFiles',
        ];
    }

    public function dumpFiles()
    {
        $extraConfig = $this->composer->getPackage()->getExtra();
        $scripts = $extraConfig['helper']['scripts'] ?? [];

        if (empty($scripts)) {
            return;
        }

        $this->generator->dumpFiles($this->composer, $scripts);
    }
}
