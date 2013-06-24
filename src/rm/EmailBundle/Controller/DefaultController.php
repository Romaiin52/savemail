<?php

namespace rm\EmailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use rm\EmailBundle\Entity\Email;
use rm\EmailBundle\Form\EmailType;
use rm\EmailBundle\Entity\Categorie;

class DefaultController extends Controller
{
    public function indexAction($categorieId)
    {
        $em = $this->getDoctrine()->getManager();
        
        if($categorieId == 0){
            $emails = $em->getRepository('rmEmailBundle:Email')->findAll();

            return $this->render('rmEmailBundle:Default:index.html.twig', 
                array(
                        'emails' => $emails
                    )
                );
        }
        else{
            $emails = $em->getRepository('rmEmailBundle:Email')->findWhereCategories($categorieId);
            $categorie = $em->getRepository('rmEmailBundle:Categorie')->findOneById($categorieId);

            return $this->render('rmEmailBundle:Default:index.html.twig', 
                array(
                        'categorie' => $categorie,
                        'emails' => $emails
                    )
                );
        }

        
    }

    public function singleAction(Email $email)
    {
        if( $email === null ){
            throw $this->createNotFoundException('Email [id='. $email->getId() .'] inexistant.');
        }

        return $this->render('rmEmailBundle:Default:single.html.twig', array('email' => $email));
    }

    public function addAction()
    {
        $email = new Email();
        $form = $this->createForm(new EmailType, $email);

        $request = $this->get('request');

        if($request->getMethod() == 'POST'){
            $form->bind($request);

            if( $form->isValid() ){
                $em = $this->getDoctrine()->getManager();
                $em->persist($email);
                $em->flush($email);

                $this->get('session')->getFlashBag()->add('info', 'L\'email a bien été enregistré');

                return $this->redirect($this->generateUrl('rm_email_home'));
            }
        }

        return $this->render('rmEmailBundle:Default:add.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    public function updateAction(Email $email)
    {
        $form = $this->createForm(new EmailType, $email);

        $request = $this->get('request');

        if($request->getMethod() == 'POST'){
            $form->bind($request);

            if( $form->isValid() ){
                $em = $this->getDoctrine()->getManager();
                $em->persist($email);
                $em->flush($email);

                $this->get('session')->getFlashBag()->add('info', 'L\'email a bien été enregistré');

                return $this->redirect($this->generateUrl('rm_email_single',  array('id'=> $email->getId() ) ));
            }
        }

        return $this->render('rmEmailBundle:Default:update.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    public function deleteAction(Email $email)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($email);
        $em->flush();

        return $this->redirect($this->generateUrl('rm_email_home'));
    }

    public function menuFavorisAction($nombre){
        $em = $this->getDoctrine()->getManager();
        $liste_favoris = $em->getRepository('rmEmailBundle:Email')->findBy( array('isFavorite'=>true), array('date'=>'desc'),$nombre,0);

        return $this->render('rmEmailBundle:Default:menuFavoris.html.twig', 
          array('liste_favoris' => $liste_favoris)); 
    }


    public function countEmailsByCatAction($id){
        $em = $this->getDoctrine()->getManager();
        $nbEmails = $em->getRepository('rmEmailBundle:Email')->calculteNumEmailsByCat($id);

        return new Response($nbEmails);
    }
}
