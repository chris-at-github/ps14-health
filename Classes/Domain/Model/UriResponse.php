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
 * UriRequest
 */
class UriResponse extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * lastRequestTime
     * 
     * @var \DateTime
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $lastRequestTime = null;

    /**
     * uri
     * 
     * @var \Ps14\Health\Domain\Model\Uri
     */
    protected $uri = null;

    /**
     * body
     * 
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $body = '';

    /**
     * Returns the uri
     * 
     * @return \Ps14\Health\Domain\Model\Uri $uri
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Sets the uri
     * 
     * @param \Ps14\Health\Domain\Model\Uri $uri
     * @return void
     */
    public function setUri(\Ps14\Health\Domain\Model\Uri $uri)
    {
        $this->uri = $uri;
    }

    /**
     * Returns the lastRequestTime
     * 
     * @return \DateTime lastRequestTime
     */
    public function getLastRequestTime()
    {
        return $this->lastRequestTime;
    }

    /**
     * Sets the lastRequestTime
     * 
     * @param \DateTime $lastRequestTime
     * @return void
     */
    public function setLastRequestTime(\DateTime $lastRequestTime)
    {
        $this->lastRequestTime = $lastRequestTime;
    }

    /**
     * Returns the body
     * 
     * @return string $body
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Sets the body
     * 
     * @param string $body
     * @return void
     */
    public function setBody($body)
    {
        $this->body = $body;
    }
}
