<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\UserType;



class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $formulaireUser = $this->createForm(UserType::class, $user);
        $formulaireUser -> handleRequest($request);
        if($formulaireUser->isSubmitted()&&$formulaireUser->isValid()){
            $user->setRoles(['ROLE_USER']);
            $encodagePassword = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encodagePassword);
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('accueil');
        }
        return $this->render('security/inscription.html.twig',['vueFormulaire' => $formulaireUser->createView()]);
    }

}
