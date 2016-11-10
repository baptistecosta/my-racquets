<?php

require_once __DIR__ . '/AppKernel.php';

/**
 * Kernel used in tests
 */
class AppTestKernel extends AppKernel
{
    /**
     * @var \Closure
     */
    private $kernelModifier = null;

    /**
     * {@inheritdoc}
     *
     * @see http://kriswallsmith.net/post/27979797907/get-fast-an-easy-symfony2-phpunit-optimization
     */
    protected function initializeContainer()
    {
        static $first = true;

        if ('test' !== $this->getEnvironment()) {
            parent::initializeContainer();
            return;
        }

        $debug = $this->debug;

        if (!$first) {
            // disable debug mode on all but the first initialization
            $this->debug = false;
        }

        // will not work with --process-isolation
        $first = false;

        try {
            parent::initializeContainer();
        } catch (\Exception $e) {
            $this->debug = $debug;
            throw $e;
        }

        $this->debug = $debug;
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        parent::boot();

        if ($kernelModifier = $this->kernelModifier) {
            $kernelModifier($this);
        };
    }

    /**
     * @param Closure $kernelModifier
     */
    public function setKernelModifier(\Closure $kernelModifier)
    {
        $this->kernelModifier = $kernelModifier;
        $this->shutdown();
    }
}