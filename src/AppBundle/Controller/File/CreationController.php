<?php

namespace AppBundle\Controller\File;

use AppBundle\Entity\File;
use AppBundle\Entity\Folder;
use AppBundle\Form\Type\File\FileCreationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CreationController extends Controller
{
    public function createFileAction(Request $request, Folder $parent = null)
    {
        $file = new File();
        $form = $this->createForm(FileCreationType::class, $file);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file->setOwner($this->getUser());
            $file->setParent($parent);

            $em = $this->getDoctrine()->getManager();
            $em->persist($file);
            $em->flush();

            if (null === $parent) {
                return $this->redirectToRoute('app_folder_showing_show_root');
            }

            return $this->redirectToRoute('app_folder_showing_show',
                array(
                    'id' => $parent->getId(),
                ));
        }

        return $this->render('@Page/File/Creation/create.html.twig',
            array(
               'form' => $form->createView(),
            ));
    }
}
