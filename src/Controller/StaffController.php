<?php

namespace App\Controller;

use App\Entity\Department;
use App\Entity\Staff;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/staff")
 */
class StaffController extends AbstractController
{
    /**
     * @Route("/", name="staff_index", methods={"GET"})
     */
    public function index(): Response
    {
        $staff = $this->getDoctrine()
            ->getRepository(Staff::class)
            ->findAll();

        return $this->render('staff/index.html.twig', [
            'staff' => $staff,
        ]);
    }

    /**
     * @Route("/new/{full_name}/{email}/{phone}/{create_at}/{skills}/{comments}/{id_dep}",
     *     name="staff_new", methods={"GET","POST"},
     *     requirements={"id_dep"="\d+"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $staff = new Staff();

        $department = $this->getDoctrine()
            ->getRepository(Department::class)
            ->find($request->get("id_dep"));

        if ($department != null) {
            $staff->setFullName($request->get("full_name"))
                ->setEmail($request->get("email"))
                ->setPhone($request->get("phone"))
                ->setComments($request->get("comments"))
                ->setSkills($request->get("skills"))
                ->addDepartment($department);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($staff);
            $entityManager->flush();
        }

        return $this->redirectToRoute('staff_index');
    }

    /**
     * @Route("/{id}/edit/{full_name}/{email}/{phone}/{create_at}/{skills}/{comments}/{id_dep}",
     *     name="staff_edit", methods={"GET","POST"},
     *     requirements={"id_dep"="\d+"})
     * @param Request $request
     * @param Staff $staff
     * @return Response
     */
    public function edit(Request $request, Staff $staff): Response
    {

        $department = $this->getDoctrine()
            ->getRepository(Department::class)
            ->find($request->get("id_dep"));

        if ($department != null) {
            $staff->setFullName($request->get("full_name"))
                ->setEmail($request->get("email"))
                ->setPhone($request->get("phone"))
                ->setComments($request->get("comments"))
                ->setSkills($request->get("skills"))
                ->addDepartment($department);

            $this->getDoctrine()->getManager()->flush();
        }

        return $this->redirectToRoute('staff_index');
    }

    /**
     * @Route("/{id}/delete", name="staff_delete", methods={"DELETE"})
     * @param Request $request
     * @param Staff $staff
     * @return Response
     */
    public function delete(Request $request, Staff $staff): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($staff);
        $entityManager->flush();

        return $this->redirectToRoute('staff_index');
    }
}
