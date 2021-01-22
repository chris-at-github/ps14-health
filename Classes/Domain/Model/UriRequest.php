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
class UriRequest extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * lastRequest
     * 
     * @var \DateTime
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $lastRequest = null;

    /**
     * uri
     * 
     * @var \Ps14\Health\Domain\Model\Uri
     */
    protected $uri = null;

    /**
     * Returns the lastRequest
     * 
     * @return \DateTime $lastRequest
     */
    public function getLastRequest()
    {
        return $this->lastRequest;
    }

    /**
     * Sets the lastRequest
     * 
     * @param \DateTime $lastRequest
     * @return void
     */
    public function setLastRequest(\DateTime $lastRequest)
    {
        $this->lastRequest = $lastRequest;
    }

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
}
