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
 * Site
 */
class Site extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * title
     * 
     * @var string
     * @TYPO3\CMS\Extbase\Annotation\Validate("NotEmpty")
     */
    protected $title = '';

    /**
     * identifier
     * 
     * @var string
     */
    protected $identifier = '';

    /**
     * domain
     * 
     * @var \Ps14\Health\Domain\Model\Domain
     */
    protected $domain = null;

    /**
     * Returns the title
     * 
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the title
     * 
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

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
     * Returns the domain
     * 
     * @return \Ps14\Health\Domain\Model\Domain $domain
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Sets the domain
     * 
     * @param \Ps14\Health\Domain\Model\Domain $domain
     * @return void
     */
    public function setDomain(\Ps14\Health\Domain\Model\Domain $domain)
    {
        $this->domain = $domain;
    }
}