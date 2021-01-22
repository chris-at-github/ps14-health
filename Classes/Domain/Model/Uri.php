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
 * Uri
 */
class Uri extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * uri
     * 
     * @var string
     */
    protected $uri = '';

    /**
     * site
     * 
     * @var \Ps14\Health\Domain\Model\Site
     */
    protected $site = null;

    /**
     * Returns the uri
     * 
     * @return string $uri
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Sets the uri
     * 
     * @param string $uri
     * @return void
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
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
