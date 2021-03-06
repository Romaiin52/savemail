<?php

namespace rm\EmailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use rm\EmailBundle\Entity\Categorie;
use rm\EmailBundle\Form\CategorieType;

class CategorieController extends Controller
{
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.context')->getToken()->getUser();

        $categories = $em->getRepository('rmEmailBundle:Categorie')->findBy(array('user'=>$user));

        return $this->render('rmEmailBundle:Categorie:index.html.twig', 
            array(
                'page' => $page,
                'categories' => $categories
            )
        );
    }

    public function singleAction(Categorie $categorie)
    {
        if( $categorie === null ){
            throw $this->createNotFoundException('Categorie [id='. $categorie->getId() .'] inexistant.');
        }

        return $this->render('rmEmailBundle:Categorie:single.html.twig', array('categorie' => $categorie));
    }

    public function addAction()
    {
        $categorie = new Categorie();
        $categorie->setUser($this->get('security.context')->getToken()->getUser());

        $form = $this->createForm(new CategorieType, $categorie);

        $request = $this->get('request');

        if($request->getMethod() == 'POST'){
            $form->bind($request);

            if( $form->isValid() ){
                $em = $this->getDoctrine()->getManager();
                $em->persist($categorie);
                $em->flush($categorie);

                $this->get('session')->getFlashBag()->add('info', 'La  catégorie a bien été enregistré');

                return $this->redirect($this->generateUrl('rm_email_categorie_single',  array('id'=> $categorie->getId() ) ));
            }
        }

        return $this->render('rmEmailBundle:Categorie:add.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    public function updateAction(Categorie $categorie)
    {
        $form = $this->createForm(new CategorieType, $categorie);

        $request = $this->get('request');

        if($request->getMethod() == 'POST'){
            $form->bind($request);

            if( $form->isValid() ){
                $em = $this->getDoctrine()->getManager();
                $em->persist($categorie);
                $em->flush($categorie);

                $this->get('session')->getFlashBag()->add('info', 'La catégorie a bien été enregistré');

                return $this->redirect($this->generateUrl('rm_email_categorie_single',  array('id'=> $categorie->getId() ) ));
            }
        }

        return $this->render('rmEmailBundle:Categorie:update.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    public function deleteAction(Categorie $categorie)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($categorie);
        $em->flush();

        return $this->redirect($this->generateUrl('rm_email_home'));
    }

    public function menuAction(){
        $em = $this->getDoctrine()->getManager();

        $user = $this->get('security.context')->getToken()->getUser();

        $liste_categories = $em->getRepository('rmEmailBundle:Categorie')->findBy( array('user'=>$user));

        return $this->render('rmEmailBundle:Categorie:menu.html.twig', 
          array('liste_categories' => $liste_categories)); 
    }
}
