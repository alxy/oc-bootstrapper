<?php

namespace OFFLINE\Bootstrapper\October\Util;


use Symfony\Component\Process\Process;

/**
 * Class Composer
 * @package OFFLINE\Bootstrapper\October\Util
 */
class Composer
{

    /**
     * @var string
     */
    protected $composer;

    /**
     * Run Composer commands.
     */
    public function __construct()
    {
        $this->composer = $this->findComposer();
    }

    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    protected function findComposer()
    {
        if (file_exists(getcwd() . '/composer.phar')) {
            return '"' . PHP_BINARY . '" composer.phar';
        }

        return 'composer';
    }

    /**
     * Composer install
     *
     * @return void
     * @throws \Symfony\Component\Process\Exception\InvalidArgumentException
     * @throws \Symfony\Component\Process\Exception\RuntimeException
     * @throws \Symfony\Component\Process\Exception\LogicException
     */
    public function install()
    {
        (new Process($this->composer . ' install --no-scripts --no-interaction --prefer-dist'))
            ->setTimeout(3600)
            ->run();
    }

    /**
     * Composer require
     *
     * @return void
     * @throws \Symfony\Component\Process\Exception\LogicException
     * @throws \Symfony\Component\Process\Exception\RuntimeException
     * @throws \Symfony\Component\Process\Exception\InvalidArgumentException
     */
    public function addDependency($package)
    {
        $package = escapeshellarg($package);

        (new Process($this->composer . ' require ' . $package . ' --no-interaction'))
            ->setTimeout(3600)
            ->run();
    }
}