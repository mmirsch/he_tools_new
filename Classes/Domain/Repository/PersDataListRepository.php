<?php
namespace HSE\HeTools\Domain\Repository;

class PersDataListRepository extends \TYPO3\CMS\Extbase\Persistence\Repository{

    public function findByTitle($title){
        /** @var \TYPO3\CMS\Extbase\Persistence\QueryInterface $query */
        $query = $this->createQuery();
         $queryResult = $query->matching(
            $query->equals('title', $title)
        )->execute();
        $firstMatch = $queryResult->getFirst();
        return $firstMatch;
    }

}

?>