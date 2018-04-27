<?php

namespace LeyJusticiaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use LeyJusticiaBundle\Entity\Tag; 
use Symfony\Component\HttpFoundation\Session\Session;
use LeyJusticiaBundle\Form\TagType; 

class TagController extends Controller
{
    private $session;
    
    public function __construct() {
        $this->session = new Session(); 
    }
    
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $tag_repo = $em->getRepository("LeyJusticiaBundle:Tag");
        $tags = $tag_repo->findAll();
        
        return $this->render("LeyJusticiaBundle:Tag:index.html.twig", array(
            "tags" => $tags
        ));
        
    }
    
    public function addTagAction(Request $request) {   
        
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag); 
        $form->handleRequest($request); 
        
        if($form->isSubmitted()) {
            if($form->isValid()){
                
                $tag = new Tag();
                $tag->setName($form->get("name")->getData());
                $tag->setDescription($form->get("description")->getData());
                
                $em = $this->getDoctrine()->getManager();
                
                $em->persist($tag);
                
                $flush = $em->flush();
                
                if($flush == null){
                    $status = 'La etiqueta se ha creado correctamente';
                } else {
                    $status = 'La etiqueta no se ha podido crear';
                }
                
            }else {
                $status = 'La etiqueta no se ha creado, revisa tu configuración';
            }
            
          $this->session->getFlashBag()->add("status", $status);
          return $this->redirectToRoute("index_tag");
        }
        
       return $this->render("LeyJusticiaBundle:Tag:add.html.twig", array(
           "form" => $form->createView()
       ));
    }
    
    public function deleteAction($id){
        
        $em = $this->getDoctrine()->getManager();
        $tag_repo = $em->getRepository("LeyJusticiaBundle:Tag");
        $tag = $tag_repo->find($id);
        
        if(count($tag->getEntryTag()) == 0 ) {
            $em->remove($tag);
            $em->flush();
        }
        
        return $this->redirectToRoute("index_tag");
        
    }
    
    
    
}
