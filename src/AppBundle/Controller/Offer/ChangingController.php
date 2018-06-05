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
                $offer = null;
                return $this->render('@Page/Offer/Changing/change.html.twig');
            }
        }
        $user->setOffer($offer);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->render('@Page/Offer/Changing/change.html.twig', array(
            'offer' => $offer,
        ));
    }
}
