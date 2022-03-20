<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Stage;
use App\Entity\Formation;
use App\Entity\Entreprise;
use App\Form\StageType;
use App\Form\EntrepriseType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ProstagesController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function accueil(): Response
    {
        $repositoryRessource=$this->getDoctrine()->getRepository(Stage::Class);
        $stages = $repositoryRessource->findAll();
        return $this->render('prostages/index.html.twig',['stages'=>$stages]);
    }

    /**
     * @Route("/entreprises", name="entreprises")
     */
    public function entreprises(): Response
    {
        $repositoryRessource=$this->getDoctrine()->getRepository(Entreprise::Class);
        $entreprises = $repositoryRessource->findAll();
        return $this->render('prostages/entreprises.html.twig',['entreprises'=>$entreprises]);
    }

    /**
     * @Route("/modifierEntreprise/{id}", name="modifierEntreprise")
     */
    public function modifierEntreprise($id,Request $request, EntityManagerInterface $manager): Response
    {
        $repositoryEntreprise=$this->getDoctrine()->getRepository(Entreprise::Class);
        $entreprise=$repositoryEntreprise->find($id);
        $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);
        $formulaireEntreprise -> handleRequest($request);
        if($formulaireEntreprise->isSubmitted()&&$formulaireEntreprise->isValid()){
            $manager->persist($entreprise);
            $manager->flush();
            return $this->redirectToRoute("entreprises",['id'=> $entreprise->getId()]);
        }
        return $this->render('prostages/modifierEntreprise.html.twig',['vueFormulaire' => $formulaireEntreprise->createView()]);
    }

    /**
     * @Route("/formations", name="formations")
     */
    public function formations(): Response
    {
        $repositoryRessource=$this->getDoctrine()->getRepository(Formation::Class);
        $formations = $repositoryRessource->findAll();
        return $this->render('prostages/formations.html.twig',['formations'=>$formations]);
    }

    /**
     * @Route("/stages/{id}", name="stages")
     */
    public function stages($id): Response
    {
        $repositoryRessource=$this->getDoctrine()->getRepository(Stage::Class);
        $stage = $repositoryRessource->find($id);
        return $this->render('prostages/stages.html.twig', 
        ['stage' => $stage]);
    }

    /**
     * @Route("/entreprises/{id}", name="stagesEntreprise")
     */
    public function stageEntreprises($id): Response
    {
        $repositoryStage=$this->getDoctrine()->getRepository(Stage::Class);
        $repositoryEntreprise=$this->getDoctrine()->getRepository(Entreprise::Class);
        $stages = $repositoryStage->trouverStagesParEntreprise($id);
        $entreprise=$repositoryEntreprise->find($id);
        return $this->render('prostages/stagesEntreprise.html.twig', 
        ['stages' => $stages,'entreprise' => $entreprise]);
    }

    /**
     * @Route("/formations/{id}", name="stagesFormation")
     */
    public function stageFormations($id): Response
    {
        $repositoryStage=$this->getDoctrine()->getRepository(Stage::Class);
        $repositoryFormation=$this->getDoctrine()->getRepository(Formation::Class);
        $stages = $repositoryStage->trouverStagesParFormation($id);
        $formation=$repositoryFormation->find($id);
        return $this->render('prostages/stagesFormation.html.twig', 
        ['stages' => $stages,'formation' => $formation]);
    }

    /**
     * @Route("/profile/creerStage", name="creerStage")
     */
    public function creerStage(Request $request, EntityManagerInterface $manager)
    {
        $stage = new Stage();
        $formulaireStage = $this->createForm(StageType::class, $stage);
        $formulaireStage -> handleRequest($request);
        if($formulaireStage->isSubmitted()&&$formulaireStage->isValid()){
            $manager->persist($stage);
            $manager->persist($stage->getEntreprise());
            $manager->flush();
            return $this->redirectToRoute("stages",['id'=> $stage->getId()]);
        }
        return $this->render('prostages/creerStage.html.twig',['vueFormulaire' => $formulaireStage->createView()]);
    }

    /**
     * @Route("/admin/creerEntreprise", name="creerEntreprise")
     */
    public function creerEntreprise(Request $request, EntityManagerInterface $manager)
    {
        $entreprise = new Entreprise();
        $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);
        $formulaireEntreprise -> handleRequest($request);
        if($formulaireEntreprise->isSubmitted()&&$formulaireEntreprise->isValid()){
            $manager->persist($entreprise);
            $manager->persist($entreprise->getEntreprise());
            $manager->flush();
            return $this->redirectToRoute("entreprises",['id'=> $entreprise->getId()]);
        }
        return $this->render('prostages/creerEntreprise.html.twig',['vueFormulaire' => $formulaireEntreprise->createView()]);
    }
}
