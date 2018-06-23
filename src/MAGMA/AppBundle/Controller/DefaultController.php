<?php

namespace MAGMA\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MAGMAAppBundle:Default:index.html.twig');
    }
}