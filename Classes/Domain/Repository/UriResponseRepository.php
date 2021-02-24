<?php
declare(strict_types=1);

namespace Ps14\Health\Domain\Repository;

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
 * The repository for Uris
 */
class UriResponseRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

	/**
	 *
	 */
    public function findBy($options = []) {
    	$matches = [];
    	$query = $this->createQuery();

    	if(isset($options['uri']) === true) {
    		$matches = $query->equals('uri', $options['uri']->getUid());
			}

    	if(empty($matches) === false) {
    		$query->matching($query->logicalAnd($matches));
			}

    	return $query->execute()->getFirst();
		}
}
