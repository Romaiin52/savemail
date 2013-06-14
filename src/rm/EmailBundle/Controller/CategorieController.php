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
        $categories = $em->getRepository('rmEmailBundle:Categorie')->findAll();

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

                $this->get('session')->getFlashBag()->add('info', 'L\'categorie a bien été enregistré');

                return $this->redirect($this->generateUrl('rm_categorie_single',  array('id'=> $categorie->getId() ) ));
            }
        }

        return $this->render('rmEmailBundle:Categorie:update.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    public function deleteAction($id)
    {
        return $this->render('rmEmailBundle:Categorie:delete.html.twig', array('id' => $id));
    }

    public function menuFavorisAction($nombre){
        $em = $this->getDoctrine()->getManager();
        $liste_favoris = $em->getRepository('rmEmailBundle:Categorie')->findBy( array('isFavorite'=>true), array('date'=>'desc'),$nombre,0);

        return $this->render('rmEmailBundle:Categorie:menuFavoris.html.twig', 
          array('liste_favoris' => $liste_favoris)); 
    }
}
