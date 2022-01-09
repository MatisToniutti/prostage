<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Stage;
use App\Entity\Formation;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $nbEntreprises=5;
        $nbStagesParFormation=2;
        $nbFormations=5;
        $nbStages=0; //utilisé pour générer les variables

        //génération des entreprises
        $entreprise1 = new Entreprise();
        $entreprise1->setActivite("activite1");
        $entreprise1->setAdresse("adresse1");
        $entreprise1->setNom("entreprise1");
        $entreprise1->setURLSite("URL1");
        $manager->persist($entreprise1);
        $manager->flush();
        $entreprise2 = new Entreprise();
        $entreprise2->setActivite("activite2");
        $entreprise2->setAdresse("adresse2");
        $entreprise2->setNom("entreprise2");
        $entreprise2->setURLSite("URL2");
        $manager->persist($entreprise2);
        $manager->flush();
        $entreprise3 = new Entreprise();
        $entreprise3->setActivite("activite3");
        $entreprise3->setAdresse("adresse3");
        $entreprise3->setNom("entreprise3");
        $entreprise3->setURLSite("URL3");
        $manager->persist($entreprise3);
        $manager->flush();
        $entreprise4 = new Entreprise();
        $entreprise4->setActivite("activite4");
        $entreprise4->setAdresse("adresse4");
        $entreprise4->setNom("entreprise4");
        $entreprise4->setURLSite("URL4");
        $manager->persist($entreprise4);
        $manager->flush();
        $entreprise5 = new Entreprise();
        $entreprise5->setActivite("activite5");
        $entreprise5->setAdresse("adresse5");
        $entreprise5->setNom("entreprise5");
        $entreprise5->setURLSite("URL5");
        $manager->persist($entreprise5);
        $manager->flush();

        $tabEntreprises = array($entreprise1,$entreprise2,$entreprise3,$entreprise4,$entreprise5);

        //génération des formations
        for($i=1;$i<=$nbFormations;$i++){
            $formation = new Formation();
            $formation->setNomCourt("nomCourt".strval($i));
            $formation->setNomLong("nomLong".strval($i));
            $manager->persist($formation);
            $manager->flush();

            //génération des stages
            for($j=1;$j<=$nbStagesParFormation;$j++){
                $nbStages++;
                $stage = new Stage();
                $stage->setTitre("titre".strval($nbStages));
                $stage->setMission("mission".strval($nbStages));
                $stage->setEmail("email".strval($nbStages));
                $stage->addFormation($formation);
                $stage->setEntreprise($tabEntreprises[$n=rand(0,4)]);
                $tabEntreprises[$n]->addStage($stage);
                $manager->persist($tabEntreprises[$n]);
                $manager->persist($stage);
                $manager->flush();
            }
        }
    }
}
