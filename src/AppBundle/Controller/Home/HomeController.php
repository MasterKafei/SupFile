<?php

namespace AppBundle\Controller\Home;

use AppBundle\Entity\Offer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function homeAction()
    {
        $offers = $this->getDoctrine()->getRepository(Offer::class)->findAll();

        return $this->render('@Page/Home/home.html.twig', array(
            'offers' => $offers,
        ));
    }

    public function informationAction()
    {
        return $this->render('@Page/Home/information.html.twig');
    }

    public function policyAction()
    {
        return $this->render('@Page/Home/policy.html.twig');
    }

    public function agreementAction()
    {
        return $this->render('@Page/Home/agreement.html.twig');
    }

    public function acceptableUseAction()
    {
        return $this->render('@Page/Home/acceptable_use.html.twig');
    }
}
