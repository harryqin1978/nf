<?php

namespace NF\CommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NF\CommerceBundle\Entity\Order;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class OrderController extends Controller
{

    /**
     * @Template()
     */
    public function indexAction()
    {

        $page_size = $this->container->getParameter('nf_page_size');
        $page_num = (int) $this->get('request')->query->get('page', 1);
        $page_firstrecord = ($page_num - 1) * $page_size;

        $em = $this->getDoctrine()->getManager();

        $page_totalcount = $em
            ->createQuery("SELECT COUNT(c.id) AS result FROM NFCommerceBundle:Order c")
            ->getSingleResult();
        $page_totalcount = $page_totalcount['result'];
        $page_count = ceil($page_totalcount / $page_size);

        $entities = $em
            ->getRepository('NFCommerceBundle:Order')
            ->createQueryBuilder('c')
            ->setFirstResult($page_firstrecord)
            ->setMaxResults($page_size)
            ->getQuery()
            ->getResult();

        return array(
            'page_title' => 'nf.commerce.page.title.orders',
            'entities' => $entities,
            'page_num' => $page_num,
            'page_count' => $page_count,
        );
    }

    /**
     * @Template()
     */
    public function newAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $task = new Order();
        $task->setPrice(0);

        $form = $this->createFormBuilder($task)
            ->add('price', 'text', array('label' => 'nf.commerce.label.price'))
            ->add('receiveName', 'text', array('label' => 'nf.commerce.label.receive_name'))
            ->add('save', 'submit', array('label' => 'nf.label.save'))
            ->getForm();

        return array(
            'page_title' => 'nf.commerce.page.title.create_new_order',
            'form' => $form->createView(),
        );
    }

}
