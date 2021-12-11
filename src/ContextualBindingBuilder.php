<?php
/**
 * ContextualBindingBuilder.php
 *
 * @package   laravel-container
 * @copyright Copyright (c) 2021, Ashley Gibson
 * @license   GPL2+
 */

namespace Ashleyfae\LaravelContainer;

class ContextualBindingBuilder
{

    /**
     * The underlying container instance.
     *
     * @var Container
     */
    protected Container $container;

    /**
     * The concrete instance.
     *
     * @var array
     */
    protected array $concrete;

    /**
     * The abstract target.
     *
     * @var string
     */
    protected string $needs;

    /**
     * ContextualBindingBuilder constructor.
     *
     * @param  Container  $container
     * @param  array|string  $concrete
     */
    public function __construct(Container $container, $concrete)
    {
        $this->container = $container;
        $this->concrete  = is_array($concrete) ? $concrete : [$concrete];
    }

    /**
     * Define the abstract target that depends on the context.
     *
     * @param  string  $abstract
     *
     * @return $this
     */
    public function needs(string $abstract): self
    {
        $this->needs = $abstract;

        return $this;
    }

    /**
     * Define the implementation for the contextual binding.
     *
     * @param  \Closure|string|array  $implementation
     *
     * @return void
     */
    public function give($implementation)
    {
        foreach ($this->concrete as $concrete) {
            $this->container->addContextualBinding($concrete, $this->needs, $implementation);
        }
    }

}
