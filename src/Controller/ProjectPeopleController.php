<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\ProjectPeople;
use App\Entity\Staff;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/project/people")
 */
class ProjectPeopleController extends AbstractController
{
    /**
     * @Route("/", name="project_people_index", methods={"GET"})
     */
    public function index(): Response
    {
        $projectPeoples = $this->getDoctrine()
            ->getRepository(ProjectPeople::class)
            ->findAll();

        return $this->render('project_people/index.html.twig', [
            'project_peoples' => $projectPeoples,
        ]);
    }

    /**
     * @Route("/new/{type}/{responsibility}/{id_project}/{id_staff}", name="project_people_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $projectPerson = new ProjectPeople();

        $project = $this->getDoctrine()
            ->getRepository(Project::class)
            ->find($request->get("id_project"));

        $staff = $this->getDoctrine()
            ->getRepository(Staff::class)
            ->find($request->get("id_staff"));

        if ($project != null && $staff != null) {
            $projectPerson->setType($request->get("type"))
                ->setResponsibility($request->get("responsibility"))
                ->setProject($project)
                ->setStaff($staff);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($projectPerson);
            $entityManager->flush();
        }

        return $this->redirectToRoute('project_people_index');
    }

    /**
     * @Route("/{id}/edit/{type}/{responsibility}/{id_project}/{id_staff}", name="project_people_edit", methods={"GET","POST"})
     * @param Request $request
     * @param ProjectPeople $projectPerson
     * @return Response
     */
    public function edit(Request $request, ProjectPeople $projectPerson): Response
    {
        $project = $this->getDoctrine()
            ->getRepository(Project::class)
            ->find($request->get("id_project"));

        $staff = $this->getDoctrine()
            ->getRepository(Staff::class)
            ->find($request->get("id_staff"));

        if ($project != null && $staff != null) {
            $projectPerson->setType($request->get("type"))
                ->setResponsibility($request->get("responsibility"))
                ->setProject($project)
                ->setStaff($staff);

            $this->getDoctrine()->getManager()->flush();
        }
            return $this->redirectToRoute('project_people_index');
    }

    /**
     * @Route("/{id}/delete", name="project_people_delete")
     * @param Request $request
     * @param ProjectPeople $projectPerson
     * @return Response
     */
    public function delete(Request $request, ProjectPeople $projectPerson): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($projectPerson);
        $entityManager->flush();

        return $this->redirectToRoute('project_people_index');
    }
}
