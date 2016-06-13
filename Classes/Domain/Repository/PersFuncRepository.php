<?php
namespace HSE\HeTools\Domain\Repository;

use HSE\HeTools\Domain\Model\Persons;

class PersFuncRepository extends \TYPO3\CMS\Extbase\Persistence\Repository{

    public function findByInstitution($institution){
        /** @var \TYPO3\CMS\Extbase\Persistence\QueryInterface $query */
        $query = $this->createQuery();
        $queryResult = $query->matching(
            $query->equals('institution', $institution)
        )->execute();
        $firstMatch = $queryResult->getFirst();
        return $firstMatch;
    }

    public function findByFaculty($faculty){
        /** @var \TYPO3\CMS\Extbase\Persistence\QueryInterface $query */
        $query = $this->createQuery();
        $queryResult = $query->matching(
            $query->equals('faculty', $faculty)
        )->execute();
        $firstMatch = $queryResult->getFirst();
        return $firstMatch;
    }


}

?>