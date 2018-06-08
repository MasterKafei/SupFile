<?php

namespace AppBundle\Controller\Folder;

use AppBundle\Entity\Folder;
use AppBundle\Form\Type\Folder\FolderEditionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EditionController extends Controller
{
    public function editFolderAction(Request $request, Folder $folder)
    {
        $this->get('app.business.folder')->isUserAllowedToManageFolder($folder);

        $form = $this->createForm(FolderEditionType::class, $folder, array(
            'action' => $this->get('router')->generate('app_folder_edition_edit', array(
                'id' => $folder->getId(),
            ))
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($folder);
            $em->flush();

            return $this->redirectToRoute('app_folder_showing_show', array('id' => $folder->getId()));
        }

        return $this->render('@Page/Folder/Edition/edit.html.twig', array(
            'form' => $form->createView(),
            'folder' => $folder,
        ));
    }
}
