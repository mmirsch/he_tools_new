<?php
namespace HSE\HeTools\Domain\Repository;

class FacultiesRepository extends \TYPO3\CMS\Extbase\Persistence\Repository{

    public function findByShortcut($shortcut){
        /** @var \TYPO3\CMS\Extbase\Persistence\QueryInterface $query */
        $query = $this->createQuery();
        $queryResult = $query->matching(
            $query->equals('shortcut', $shortcut)
        )->execute();
        $firstMatch = $queryResult->getFirst();
        return $firstMatch;
    }

}

?>