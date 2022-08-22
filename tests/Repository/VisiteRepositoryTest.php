<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Repository;

use App\Entity\Visite;
use App\Repository\VisiteRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of VisiteRepositoryTest
 *
 * @author Lucas
 */
class VisiteRepositoryTest extends KernelTestCase {

    /**
     * Récupère le repository de Visite
     * @return VisiteRepository
     */
    public function recupRepository(): VisiteRepository {
        self::bootKernel();
        $repository = self::getContainer()->get(VisiteRepository::class);
        return $repository;
    }

    public function testNbVisites() {
        $repository = $this->recupRepository();
        $nbVisites = $repository->count([]);
        $this->assertEquals(2, $nbVisites);
    }

    public function newVisite(): Visite {
        $visite = (new Visite())
                        ->setVille("New York")
                        ->setPays("USA")
                        ->setDatecreation(new DateTime("now"));
        return $visite;
    }
    
    public function testAddVisite(){
        $repository = $this->recupRepository();
        $visite = $this->newVisite();
        $nbVisites = $repository->count([]);        
        $repository->add($visite, true);
        $this->assertEquals($nbVisites+1, $repository->count([]), "erreur lors de l'ajout");
    }
    
    public function testRemoveVisite(){
        $repository = $this->recupRepository();
        $visite = $this->newVisite();      
        $repository->add($visite, true);
        $nbVisites = $repository->count([]);
        $repository->remove($visite, true);
        $this->assertEquals($nbVisites-1, $repository->count([]), "erreur lors de la suppression");
    }
    
    public function testFindByEqualValue(){
        $repository = $this->recupRepository();
        $visite = $this->newVisite();      
        $repository->add($visite, true);
        $visites = $repository->findByEqualValue("ville", "New York");
        $nbVisites = count($visites);
        $this->assertEquals(1, $nbVisites);
        $this->assertEquals("New York", $visites[0]->getVille());
    }

}
