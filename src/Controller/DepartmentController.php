<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Department;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/department")
 */
class DepartmentController extends AbstractController
{
    /**
     * @Route("/", name="department_index", methods={"GET"})
     */
    public function index(): Response
    {
        $departments = $this->getDoctrine()
            ->getRepository(Department::class)
            ->findAll();

        return $this->render('department/index.html.twig', [
            'departments' => $departments,
        ]);
    }

    /**
     * @Route("/new/{title}/{description}/{id_company}", name="department_new", methods={"GET","POST"}, requirements={"id"="\d+"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $department = new Department();

        $company = $this->getDoctrine()
            ->getRepository(Company::class)
            ->find($request->get("id_company"));
        if ($company != null) {
            $department->setTitle($request->get("title"))
                ->setDescription($request->get("description"))
                ->setCompany($company);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($department);
            $entityManager->flush();
        }

        return $this->redirectToRoute('department_index');
    }

    /**
     * @Route("/{id}/edit/{title}/{description}/{id_company}", name="department_edit", methods={"GET","POST"},
     *     requirements={"id"="\d+", "id_company"="\d+"})
     * @param Request $request
     * @param Department $department
     * @return Response
     */
    public function edit(Request $request, Department $department): Response
    {
        $company = $this->getDoctrine()
            ->getRepository(Company::class)
            ->find($request->get("id_company"));
        if ($company != null) {
            $department->setTitle($request->get("title"))
                ->setDescription($request->get("description"))
                ->setCompany($company);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->redirectToRoute('department_index');
    }

    /**
     * @Route("/{id}/delete", name="department_delete")
     * @param Request $request
     * @param Department $department
     * @return Response
     */
    public function delete(Request $request, Department $department): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($department);
        $entityManager->flush();

        return $this->redirectToRoute('department_index');
    }
}
