<?php

namespace AppBundle\Controller\Folder;

use AppBundle\Entity\Folder;
use AppBundle\Form\Type\Folder\FolderCreationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CreationController extends Controller
{
    public function createFolderAction(Request $request, Folder $parent = null)
    {
        $folder = new Folder();
        $form = $this->createForm(FolderCreationType::class, $folder);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $folder->setParent($parent);
           $folder->setOwner($this->getUser());

           $em = $this->getDoctrine()->getManager();

           $em->persist($folder);
           $em->flush();

           if (null === $parent) {
               return $this->redirectToRoute('app_folder_showing_show_root');
           }

           return $this->redirectToRoute('app_folder_showing_show',
               array(
                  'id' => $parent->getId(),
               ));
        }

        return $this->render('@Page/Folder/Creation/create.html.twig',
            array(
                'form' => $form->createView(),
            ));
    }
}
