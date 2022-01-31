<?php

namespace App\Controller;

use App\Entity\Appeal;
use App\Form\AppealType;
use App\Repository\AppealRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(Request $request, EntityManagerInterface $entityManager): Response
    {
        // just set up a fresh $task object (remove the example data)
        $appeal = new Appeal();
        $form = $this->createForm(AppealType::class, $appeal, ['showStatus' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($appeal);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->renderForm('pages/home.html.twig', [
            'form' => $form,
        ]);
    }
}
