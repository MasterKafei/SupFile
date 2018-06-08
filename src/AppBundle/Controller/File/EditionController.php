<?php

namespace AppBundle\Controller\File;


use AppBundle\Entity\File;
use AppBundle\Form\Type\File\FileEditionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EditionController extends Controller
{
    public function editFileAction(Request $request, File $file)
    {
        $this->get('app.business.folder')->isUserAllowedToManageFolder($file);

        $form = $this->createForm(FileEditionType::class, $file, array('action' => $this->get('router')->generate('app_file_edition_edit', array('id' => $file->getId()))));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($file);
            $em->flush();

            return $this->redirectToRoute('app_file_showing_show', array('id' => $file->getId()));
        }

        return $this->render('@Page/File/Edition/edit.html.twig', array(
           'form' => $form->createView(),
           'file' => $file,
        ));
    }
}
