<?php

namespace App\Controller;

use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/project")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("/", name="project_index", methods={"GET"})
     */
    public function index(): Response
    {
        $projects = $this->getDoctrine()
            ->getRepository(Project::class)
            ->findAll();

        return $this->render('project/index.html.twig', [
            'projects' => $projects,
        ]);
    }

    /**
     * @Route("/new/{title}/{description}", name="project_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $project = new Project();
        $project->setTitle($request->get("title"))
            ->setDescription($request->get("description"));

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($project);
        $entityManager->flush();

        return $this->redirectToRoute('project_index');
    }

    /**
     * @Route("/{id}/edit/{title}/{description}", name="project_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Project $project
     * @return Response
     */
    public function edit(Request $request, Project $project): Response
    {
        $project->setTitle($request->get("title"))
            ->setDescription($request->get("description"));

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('project_index');
    }

    /**
     * @Route("/{id}/delete", name="project_delete")
     * @param Request $request
     * @param Project $project
     * @return Response
     */
    public function delete(Request $request, Project $project): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($project);
        $entityManager->flush();

        return $this->redirectToRoute('project_index');
    }
}
