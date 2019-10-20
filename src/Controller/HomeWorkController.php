<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class HomeWorkController extends AbstractController
{
    /**
     * @param string $optionalParam
     * @return Response
     */
    public function yamlAction(string $optionalParam = '')
    {
        $line = "";
        if ($optionalParam != '') {
            $line = ' with parameter: ' . $optionalParam;
        }

        return $this->render(
            'yaml.html.twig',
            ['line' => $line]
        );
    }

    public function phpAction()
    {
        return new Response(
            '<html lang="en"><body>This is PHP action</body></html>'
        );
    }

    /**
     * @Route("/annotation/{onlyLetters}", name="annotation_action", requirements={"onlyLetters"="[a-zA-Z]+"})
     * @param string $onlyLetters
     * @return JsonResponse
     */
    public function annotationAction(string $onlyLetters = "")
    {
        return $this->json(["letters" => $onlyLetters]);
    }

    /**
     * @Route("/generate/{onlyLetters}", name="gen_url_action", requirements={"onlyLetters"="[a-zA-Z]+"})
     * @param string $onlyLetters
     * @return Response
     */
    public function generateUrlAction(string $onlyLetters)
    {
        $generatedUrl = $this->generateUrl('annotation_action', ['onlyLetters' => $onlyLetters], UrlGeneratorInterface::ABSOLUTE_URL);
        return $this->render(
            'generate-url.html.twig',
            [
                'action' => 'annotation_action',
                'onlyLetters' => $onlyLetters,
                'generatedUrl' => $generatedUrl
            ]
        );
    }

    /**
     * @Route("/redirect", name="redirect_action")
     */
    public function redirectAction()
    {
        return $this->redirectToRoute('yaml_action');
    }
}
