<?php
/**
 * Go! AOP framework
 *
 * @copyright Copyright 2014, Lisachenko Alexander <lisachenko.it@gmail.com>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Go\Aop\Support;

use Go\Aop\Framework\AfterInterceptor;
use Go\Aop\Framework\AroundInterceptor;
use Go\Aop\Framework\BeforeInterceptor;
use Go\Core\AspectContainer;

/**
 * Pointcut builder provides simple DSL for declaring pointcuts in plain PHP code
 */
class PointcutBuilder
{
    /**
     * @var AspectContainer
     */
    protected $container;

    /**
     * Default constructor for the builder
     *
     * @param AspectContainer $container Instance of container
     */
    public function __construct(AspectContainer $container)
    {
        $this->container = $container;
    }

    /**
     * Declares the "Before" hook for specific pointcut expression
     *
     * @param string $pointcutExpression Pointcut, e.g. "within(**)"
     * @param callable $advice Advice to call
     */
    public function before($pointcutExpression, \Closure $advice)
    {
        $this->container->registerAdvisor(
            new LazyPointcutAdvisor($pointcutExpression, new BeforeInterceptor($advice)),
            md5($pointcutExpression)
        );
    }

    /**
     * Declares the "After" hook for specific pointcut expression
     *
     * @param string $pointcutExpression Pointcut, e.g. "within(**)"
     * @param callable $advice Advice to call
     */
    public function after($pointcutExpression, \Closure $advice)
    {
        $this->container->registerAdvisor(
            new LazyPointcutAdvisor($pointcutExpression, new AfterInterceptor($advice)),
            md5($pointcutExpression)
        );
    }

    /**
     * Declares the "Around" hook for specific pointcut expression
     *
     * @param string $pointcutExpression Pointcut, e.g. "within(**)"
     * @param callable $advice Advice to call
     */
    public function around($pointcutExpression, \Closure $advice)
    {
        $this->container->registerAdvisor(
            new LazyPointcutAdvisor($pointcutExpression, new AroundInterceptor($advice)),
            md5($pointcutExpression)
        );
    }
}
