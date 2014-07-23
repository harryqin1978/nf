<?php

namespace NF\CommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NF\CommerceBundle\Entity\Order;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
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

        if (!$this->get('security.context')->isGranted('ROLE_USER')) {
            throw new AccessDeniedException();
        }

        $entity = new Order();

        $form = $this->makeForm($entity, 'new');

        $form->handleRequest($request);

        if ($form->isValid()) {
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

    /**
     * @Template()
     */
    public function editAction(Request $request, $id)
    {

        $entity = $this->getDoctrine()->getRepository('NFCommerceBundle:Order')->find($id);
        $this->checkAccess($entity);

        $form = $this->makeForm($entity, 'edit');

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $redirect_route = 'nf_commerce_orders';

            return $this->redirect($this->generateUrl($redirect_route));
        }

        return array(
            'page_title' => 'nf.commerce.page.title.edit_order',
            'form' => $form->createView(),
        );

    }

    protected function makeForm($entity, $action) {
        $formBuilder = $this->createFormBuilder($entity);
        $formBuilder->add('price', 'text', array('label' => 'nf.commerce.label.price'));
        $formBuilder->add('receiveName', 'text', array('label' => 'nf.commerce.label.receive_name'));
        $formBuilder->add('save', 'submit', array('label' => 'nf.label.save', 'attr' => array('data-button-position' => 'first')));
        if ($action == 'new') {
            $formBuilder->add('saveAndAdd', 'submit', array('label' => 'nf.label.save_and_add'));
        }
        $formBuilder->add('back', 'button', array('label' => 'nf.label.back', 'attr' => array('data-button-position' => 'last', 'onclick' => 'window.location.href=\'' . $this->generateUrl('nf_commerce_orders') . '\'')));
        return $formBuilder->getForm();
    }

    public function deleteAction(Request $request, $id)
    {
        $entity = $this->getDoctrine()->getRepository('NFCommerceBundle:Order')->find($id);
        $this->checkAccess($entity);

        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();
        $redirect_route = 'nf_commerce_orders';
        return $this->redirect($this->generateUrl($redirect_route));
    }

    protected function checkAccess($entity) {
        if ($entity->getUser()->getName() != $this->getUser()->getName() && !$this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
    }

}
