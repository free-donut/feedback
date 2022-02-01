<?php

namespace App\Controller;

use App\Entity\Appeal;
use App\Form\AppealType;
use App\Form\AppealFilterType;
use App\Repository\AppealRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="appeal_index", methods={"GET"})
     */
    public function indexAppeal(AppealRepository $appealRepository, Request $request): Response
    {
        $customers = array_column($appealRepository->getDistinctField('customer'), 'customer');
        $phones = array_column($appealRepository->getDistinctField('phone'), 'phone');
        $statuses = array_filter(
            Appeal::STATUS_NAMES,
            fn($statusIndex) => $appealRepository->findOneBy(['status' => $statusIndex]) !== null,
            ARRAY_FILTER_USE_KEY
        );

        $form = $this->createForm(
            AppealFilterType::class,
            null,
            [
                'method' => 'GET',
                'statuses' => array_flip($statuses),
                'phones' => array_flip($phones),
                'customers' => array_flip($customers),
                'attr' => ['class' => 'd-flex mb-2'],
            ]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            ['status' => $status, 'customer' => $customerIndex, 'phone' => $phoneIndex] = $form->getData();
            $customer = isset($customerIndex) ? $customers[$customerIndex] : null;
            $phone = isset($phoneIndex) ? $phones[$phoneIndex] : null;

            $query = $appealRepository->getFilteredQuery($status, $customer, $phone);
        } else {
            $query = $appealRepository->getAllQuery();
        }

        $currentPage = $request->query->get('page') ?? 1;
        $limit = 1;
        $appeals = $appealRepository->getPaginatedPages($query, $currentPage, $limit);
        $maxPages = ceil($appeals->count() / $limit);

        return $this->render('appeal/index.html.twig', [
            'appeals' => $appeals,
            'form' => $form->createView(),
            'currentPage' => $currentPage,
            'maxPages' => $maxPages
        ]);
    }

    /**
     * @Route("/{id}/edit", name="appeal_edit", methods={"GET", "POST"})
     */
    public function editAppeal(Request $request, Appeal $appeal, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AppealType::class, $appeal, ['showStatus' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('appeal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('appeal/edit.html.twig', [
            'appeal' => $appeal,
            'form' => $form,
        ]);
    }
}
