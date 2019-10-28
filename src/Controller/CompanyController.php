<?php

namespace App\Controller;

use App\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/company")
 */
class CompanyController extends AbstractController
{
    /**
     * @Route("/", name="company_index", methods={"GET"})
     */
    public function index(): Response
    {
        $companies = $this->getDoctrine()
            ->getRepository(Company::class)
            ->findAll();

        return $this->render('company/index.html.twig', [
            'companies' => $companies,
        ]);
    }

    /**
     * @Route("/new/{title}", name="company_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $company = new Company();
        $company->setTitle($request->get("title"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($company);
        $entityManager->flush();

        return $this->redirectToRoute('company_index');
    }

    /**
     * @Route("/{id}/edit/{title}", name="company_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Company $company
     * @return Response
     */
    public function edit(Request $request, Company $company): Response
    {
        $company->setTitle($request->get("title"));

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('company_index');
    }

    /**
     * @Route("/{id}/delete", name="company_delete")
     * @param Request $request
     * @param Company $company
     * @return Response
     */
    public function delete(Request $request, Company $company): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($company);
        $entityManager->flush();

        return $this->redirectToRoute('company_index');
    }
}
