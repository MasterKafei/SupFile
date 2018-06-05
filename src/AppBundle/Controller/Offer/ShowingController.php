<?php

namespace AppBundle\Controller\Offer;


use AppBundle\Entity\Offer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ShowingController extends Controller
{
    public function showOfferAction(Offer $offer)
    {
        return $this->render('@Page/Offer/Showing/show.html.twig', array(
            'offer' => $offer,
        ));
    }
}
