<?php

namespace NF\CommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NFCommerceBundle:Default:index.html.twig', array('name' => $name));
    }
}
