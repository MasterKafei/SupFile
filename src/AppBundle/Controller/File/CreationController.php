<?php

namespace AppBundle\Controller\File;

use AppBundle\Entity\File;
use AppBundle\Entity\Folder;
use AppBundle\Form\Type\File\FileCreationType;
use AppBundle\Service\Util\Console\Model\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CreationController extends Controller
{
    public function createFileAction(Request $request, Folder $parent = null)
    {
        $file = new File();
        if ($parent === null) {
            $route = $this->get('router')->generate('app_file_creation_create_without_parent');
        } else {
            $route = $this->get('router')->generate('app_file_creation_create', array('id' => $parent->getId()));
        }

        $form = $this->createForm(FileCreationType::class, $file, array('action' => $route));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $quota = round(intval($file->getFile()->getSize())/(1000 * 1000));
            $quota += intval($this->get('app.business.user')->getQuota($this->getUser()));
            if ($quota > $this->getUser()->getOffer()->getQuota() * 1000) {
                $this->get('app.util.console')->add('Not enough space for your current Offer', Message::TYPE_WARNING);
            } else {
                $file->setOwner($this->getUser());
                $file->setParent($parent);
                $file->setName($file->getFile()->getClientOriginalName());

                $em = $this->getDoctrine()->getManager();
                $em->persist($file);
                $em->flush();
            }

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
