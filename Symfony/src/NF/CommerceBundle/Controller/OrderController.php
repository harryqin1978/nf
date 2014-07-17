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
        
        $entity = new Order();
        // $entity->setPrice(0);

        $form = $this->createFormBuilder($entity)
            ->add('price', 'text', array('label' => 'nf.commerce.label.price'))
            ->add('receiveName', 'text', array('label' => 'nf.commerce.label.receive_name'))
            ->add('save', 'submit', array('label' => 'nf.label.save', 'attr' => array('data-button-position' => 'first')))
            ->add('saveAndAdd', 'submit', array('label' => 'nf.label.save_and_add'))
            ->add('back', 'button', array('label' => 'nf.label.back', 'attr' => array('data-button-position' => 'last', 'onclick' => 'window.location.href=\'' . $this->generateUrl('nf_commerce_orders') . '\'')))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            // $entity = $form->getData();
            $entity->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $redirect_route = $form->get('saveAndAdd')->isClicked() ? 'nf_commerce_order_new' : 'nf_commerce_orders';

            return $this->redirect($this->generateUrl($redirect_route));
        }

        return array(
            'page_title' => 'nf.commerce.page.title.create_new_order',
            'form' => $form->createView(),
        );
    }

}
