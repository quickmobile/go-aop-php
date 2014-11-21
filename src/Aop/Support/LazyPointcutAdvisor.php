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

use Go\Aop\Advice;
use Go\Aop\Pointcut;
use Go\Core\AspectKernel;

/**
 * Lazy pointcut advisor is used to create a delayed pointcut only when needed
 */
class LazyPointcutAdvisor extends DefaultPointcutAdvisor
{

    /**
     * Pointcut expression
     *
     * @var string
     */
    private $pointcutExpression;

    /**
     * Is pointcut parsed or not
     *
     * @var bool
     */
    private $isParsed = false;

    /**
     * Create a DefaultPointcutAdvisor, specifying Pointcut and Advice.
     *
     * @param string $pointcutExpression The Pointcut targeting the Advice
     * @param Advice $advice The Advice to run when Pointcut matches
     */
    public function __construct($pointcutExpression, Advice $advice)
    {
        // Do not call parent constructor
        $this->pointcutExpression = $pointcutExpression;
        $this->setAdvice($advice);
    }

    /**
     * Get the Pointcut that drives this advisor.
     *
     * @return Pointcut The pointcut
     */
    public function getPointcut()
    {
        if (!$this->isParsed) {

            // TODO: Inject this dependencies and make them lazy!
            // TODO: should be extracted from AbstractAspectLoaderExtension into separate class

            $container = AspectKernel::getInstance()->getContainer();

            /** @var Pointcut\PointcutLexer $lexer */
            $lexer = $container->get('aspect.pointcut.lexer');

            /** @var Pointcut\PointcutParser $parser */
            $parser = $container->get('aspect.pointcut.parser');

            $tokenStream = $lexer->lex($this->pointcutExpression);
            $pointcut    = $parser->parse($tokenStream);

            parent::setPointcut($pointcut);
            $this->isParsed = true;
        }

        return parent::getPointcut();
    }
}
