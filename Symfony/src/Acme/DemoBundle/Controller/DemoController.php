<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Acme\DemoBundle\Form\ContactType;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use NF\UserBundle\Entity\User;
use NF\CommerceBundle\Entity\Order;

class DemoController extends Controller
{
    /**
     * @Route("/", name="_demo")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/hello/{name}", name="_demo_hello")
     * @Template()
     */
    public function helloAction($name)
    {

        // print_r($this->get('request'));

        // $user = new User();
        // $user->setName('a');
        // $user->setPasswordHash('b');
        // $user->setEmail('c@126.com');
        // $user->setIsActive(true);

        // $order = new Order();
        // $order->setReceiveName('Foo');
        // $order->setPrice(19.99);
        // // relate this order to the user
        // $order->setUser($user);

        // $em = $this->getDoctrine()->getManager();
        // $em->persist($user);
        // $em->persist($order);
        // $em->flush();

        $factory = $this->get('security.encoder_factory');
        $user = new User();

        $encoder = $factory->getEncoder($user);
        $password = $encoder->encodePassword('b', $user->getSalt());

        return array(
            // 'page_title' => 'Demo hello ' . $user->getId() . ' ' . $order->getId(),
            'page_title' => 'Demo hello: [' . $password . ']',
            // 'page_title' => 'Demo hello',
            'name' => $name
        );
    }

    /**
     * @Route("/contact", name="_demo_contact")
     * @Template()
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(new ContactType());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $mailer = $this->get('mailer');

            // .. setup a message and send it
            // http://symfony.com/doc/current/cookbook/email.html

            $request->getSession()->getFlashBag()->set('notice', 'Message sent!');

            return new RedirectResponse($this->generateUrl('_demo'));
        }

        return array('form' => $form->createView());
    }
}
