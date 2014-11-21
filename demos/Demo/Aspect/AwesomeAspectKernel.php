<?php
/**
 * Go! AOP framework
 *
 * @copyright Copyright 2012, Lisachenko Alexander <lisachenko.it@gmail.com>
 *
 * This source file is subject to the license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Demo\Aspect;

use Go\Aop\Framework\ClassFieldAccess;
use Go\Aop\Intercept\MethodInvocation;
use Go\Aop\Support\PointcutBuilder;
use Go\Core\AspectKernel;
use Go\Core\AspectContainer;

/**
 * Awesome Aspect Kernel class
 */
class AwesomeAspectKernel extends AspectKernel
{
    /**
     * Configure an AspectContainer with advisors, aspects and pointcuts
     *
     * @param AspectContainer $container
     *
     * @return void
     */
    protected function configureAop(AspectContainer $container)
    {
        $pointcutBuilder = new PointcutBuilder($container);
        $pointcutBuilder->before('execution(public **->*(*))', function (MethodInvocation $method) {
            echo $method, PHP_EOL;
        });

        $pointcutBuilder->after('access(* Demo\**->*)', function (ClassFieldAccess $property) {
            echo $property, PHP_EOL;
        });
    }
}
