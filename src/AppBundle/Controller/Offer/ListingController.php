<?php

namespace AppBundle\Controller\Offer;

use AppBundle\Entity\Offer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ListingController extends Controller
{
    public function listOfferAction()
    {
        $offers = $this->getDoctrine()->getRepository(Offer::class)->findAll();

        return $this->render('@Page/Offer/Listing/list.html.twig', array(
            'offers' => $offers,
        ));
    }
}
