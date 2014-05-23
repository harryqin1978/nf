<?php

namespace NF\CommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DashboardController extends Controller
{

    /**
     * @Template()
     */
    public function indexAction()
    {
        return array(
            'page_title' => 'Dashboard'
        );
    }

}
