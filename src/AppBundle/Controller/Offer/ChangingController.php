<?php

namespace AppBundle\Controller\Offer;


use AppBundle\Entity\Offer;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ChangingController extends Controller
{
    public function changeOfferAction(Offer $offer)
    {
        /** @var User $user */
        $user = $this->getUser();
        if ($user->getOffer()) {
            if($user->getOffer()->getPrice() > $offer->getPrice()) {
                $offer = $user->getOffer();
            }
        }
        $user->setOffer($offer);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('app_folder_showing_show_root');
    }
}
