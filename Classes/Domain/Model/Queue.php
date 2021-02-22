<?php
declare(strict_types=1);

namespace Ps14\Health\Domain\Model;


/***
 *
 * This file is part of the "Health" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Christian Pschorr <pschorr.christian@gmail.com>
 *
 ***/
/**
 * TestQueue
 */
class Queue extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * identifier
     * 
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $identifier = '';

    /**
     * handler
     * 
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $handler = '';

    /**
     * nextExecution
     * 
     * @var \DateTime
     */
    protected $nextExecution = null;

    /**
     * arguments
     * 
     * @var string
     */
    protected $arguments = '';

    /**
     * site
     * 
     * @var \Ps14\Health\Domain\Model\Site
     * @TYPO3\CMS\Extbase\Annotation\ORM\Lazy
     */
    protected $site = null;

    /**
     * Returns the identifier
     * 
     * @return string $identifier
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }

    /**
     * Sets the identifier
     * 
     * @param string $identifier
     * @return void
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Returns the handler
     * 
     * @return string $handler
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * Sets the handler
     * 
     * @param string $handler
     * @return void
     */
    public function setHandler($handler)
    {
        $this->handler = $handler;
    }

    /**
     * Returns the nextExecution
     * 
     * @return \DateTime $nextExecution
     */
    public function getNextExecution()
    {
        return $this->nextExecution;
    }

    /**
     * Sets the nextExecution
     * 
     * @param \DateTime $nextExecution
     * @return void
     */
    public function setNextExecution(\DateTime $nextExecution)
    {
        $this->nextExecution = $nextExecution;
    }

    /**
     * Returns the arguments
     * 
     * @return string $arguments
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Sets the arguments
     * 
     * @param string $arguments
     * @return void
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * Returns the site
     * 
     * @return \Ps14\Health\Domain\Model\Site $site
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Sets the site
     * 
     * @param \Ps14\Health\Domain\Model\Site $site
     * @return void
     */
    public function setSite(\Ps14\Health\Domain\Model\Site $site)
    {
        $this->site = $site;
    }
}
