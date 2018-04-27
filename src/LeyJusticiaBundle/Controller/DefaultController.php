<?php

namespace LeyJusticiaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function proofAction()
            
    {
        
        /*$em = $this->getDoctrine()->getManager();
        $entry_repo = $em->getRepository("LeyJusticiaBundle:Entry");
        
        $entries = $entry_repo->findAll();
        
        
        foreach($entries as $entry) {
           echo '<li>' . $entry->getTitle(). '</li>'; 
           echo '<li>' . $entry->getCategory()->getName(). '</li>';
           echo '<li>' . $entry->getUser()->getName().'</li>';
           echo '<li>' . $entry->getUser()->getBiography().'</li>'; 
           
           $tags = $entry->getEntryTag();
           foreach($tags as $tag){
               echo '<li>'. $tag->getTag()->getName(). '</li>'; 
           }
           
           echo '<hr>';
        }*/ 
        
        /*$em = $this->getDoctrine()->getManager();
        $category_repo = $em->getRepository("LeyJusticiaBundle:Category");
        
        $categories = $category_repo->findAll();
        
        
        foreach($categories as $category) {
           echo '<li>' . $category->getName(). '</li>'; 
           //echo '<li>' . $cat->getDescription(). '</li>';
           
           $entries = $category->getEntries(); /* se usa la variable singular del foreach */ 
        /*   foreach($entries as $entry){
               echo '<li>'. $entry->getTitle() . '</li>'; 
               echo '<li>'. $entry->getContent() . '</li>'; 
           }
           
           echo '<hr>';
        }*/
               
        $em = $this->getDoctrine()->getManager();
        $tag_repo = $em->getRepository("LeyJusticiaBundle:Tag");
        
        $tags = $tag_repo->findAll();
        
        
        foreach($tags as $tag) {
           echo '<li>' . $tag->getName(). '</li>'; 
           //echo '<li>' . $cat->getDescription(). '</li>';
           
           $entryTag = $tag->getEntryTag(); 
           foreach($entryTag as $entry){
               echo '<li>'. $entry->getEntry()->getTitle() . '</li>'; 
               //echo '<li>'. $entry->getEntry()->getContent() . '</li>'; 
               echo '<li>'. $entry->getEntry()->getUser()->getName() . '</li>';
           }
           
           echo '<hr>';
        }
        
        
        
        die(); 
        return $this->render('LeyJusticiaBundle:Default:index.html.twig');
    }
    
    public function indexAction() {
        
        
        
        return $this->render('LeyJusticiaBundle:Default:index.html.twig');
    }
    
    
}
