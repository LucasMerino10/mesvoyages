<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests\Validations;

use App\Entity\Visite;
use DateInterval;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Description of VisiteValidationsTest
 *
 * @author Lucas
 */
class VisiteValidationsTest extends KernelTestCase {

    public function getVisite(): Visite {
        return (new Visite())
                        ->setVille("Troyes")
                        ->setPays("France");
    }

    public function testValidNoteVisite() {      
        $this->assertErrors($this->getVisite()->setNote(10), 0, "10 devrait réussir");        
        $this->assertErrors($this->getVisite()->setNote(0), 0, "0 devrait réussir");      
        $this->assertErrors($this->getVisite()->setNote(20), 0, "20 devrait réussir");
    }

    public function testInvalidNoteVisite() {
        $this->assertErrors($this->getVisite()->setNote(21), 1, "21 devrait échouer");
        $this->assertErrors($this->getVisite()->setNote(-1), 1, "-1 devrait échouer");
    }

    public function testValidTempmaxVisite() {
        $this->assertErrors($this->getVisite()->setTempmin(20)->setTempmax(40), 0, "min=20, max=40 devrait réussir");
        $this->assertErrors($this->getVisite()->setTempmin(10)->setTempmax(11), 0, "min=10, max=11 devrait réussir");
    }

    public function testInvalidTempmaxVisite() {
        $this->assertErrors($this->getVisite()->setTempmin(30)->setTempmax(10), 1, "min=30, max=10 devrait échouer");
        $this->assertErrors($this->getVisite()->setTempmin(15)->setTempmax(15), 1, "min=15, max=15 devrait échouer");
    }
    
    public function testInvalidDatecreation(){
        $tomorrow = new \DateTime('tomorrow');
        $this->assertErrors($this->getVisite()->setDatecreation($tomorrow), 1, "La date du lendemain devrait échouer");
        $later = (new \DateTime())->add(new \DateInterval("P5D"));
        $this->assertErrors($this->getVisite()->setDatecreation($later), 1, "Une date future devrait échouer");     
                            
    }
    
    public function testValidDatecreation(){
        $today = new \DateTime();     
        $this->assertErrors($this->getVisite()->setDatecreation($today), 0, "La date du jour devrait réussir");     
        $before = (new \DateTime())->sub(new DateInterval("P5D"));
        $this->assertErrors($this->getVisite()->setDatecreation($before), 0, "La date d'il y a 5 jours devrait réussir");                    
    }

    public function assertErrors(Visite $visite, int $nbErreursttendues, string $message = "") {
        self::bootKernel();
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $error = $validator->validate($visite);
        $this->assertCount($nbErreursttendues, $error, $message);
    }

}
