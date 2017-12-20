<?php

namespace AppBundle\Controller;

use Akuma\Bundle\CoenFileBundle\Entity\Attachment;
use Akuma\Bundle\CoenFileBundle\Form\Type\AttachmentCollectionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @param Request $request
     *
     * @return Response
     * @throws \LogicException
     */
    public function indexAction(Request $request)
    {
        $form = $this->createForm(AttachmentCollectionType::class);
        $em = $this->getDoctrine()->getManagerForClass(Attachment::class);
        if ($request->isMethod('post')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $files = $form->getData();
                if (count($files)) {
                    foreach ($files['files'] as $file) {
                        $em->persist($file);
                    }
                    $em->flush();
                }
            }
        }

        return $this->render('default/index.html.twig', [
            'form' => $form->createView(),
            'files' => $em->getRepository(Attachment::class)->findBy([], ['createdAt' => 'DESC'], 10),
            'allowedCount' => $this->get('akuma_coen_file.manager.attachement')->getAllowedCount(),
        ]);
    }
}
