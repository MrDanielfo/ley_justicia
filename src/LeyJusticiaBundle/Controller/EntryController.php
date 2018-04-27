<?php

namespace LeyJusticiaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use LeyJusticiaBundle\Entity\Entry; 
use Symfony\Component\HttpFoundation\Session\Session;
use LeyJusticiaBundle\Form\EntryType; 

class EntryController extends Controller
{
    private $session;
    
    public function __construct() {
        $this->session = new Session(); 
    }
    
    public function indexAction($page) {
        $em = $this->getDoctrine()->getManager();
        $entry_repo = $em->getRepository("LeyJusticiaBundle:Entry");
        $category_repo = $em->getRepository("LeyJusticiaBundle:Category");
        $categories = $category_repo->findAll();
              
        $pageSize = 6;
        $entries = $entry_repo->getPaginateEntries($pageSize, $page);
        $totalItems = count($entries); 
        $pagesCount = ceil($totalItems/$pageSize);
                     
        return $this->render("LeyJusticiaBundle:Entry:index.html.twig", array(
            "entries" => $entries,
            "categories" => $categories,
            "totalItems" => $totalItems,
            "pagesCount"  => $pagesCount,
            "page"      => $page,
            "page_m"    => $page
        ));
        
    }
    
    public function addEntryAction(Request $request) {   
        
        $entry = new Entry();
        $form = $this->createForm(EntryType::class, $entry); 
        $form->handleRequest($request); 
        
        if($form->isSubmitted()) {
            if($form->isValid()){
                
                $em = $this->getDoctrine()->getManager();
                $entry_repo = $em->getRepository("LeyJusticiaBundle:Entry");
                $category_repo = $em->getRepository("LeyJusticiaBundle:Category");
                
                $entry = new Entry();
                $entry->setTitle($form->get("title")->getData());
                $entry->setContent($form->get("content")->getData());
                $entry->setStatus($form->get("status")->getData());
                
                $file = $form["image"]->getData();
                
                if (!empty($file) && $file != null) { 
                    $ext = $file->guessExtension();
                    $file_name = time(). "." . $ext;
                    $file->move("uploads", $file_name);
                    $entry->setImage($file_name);
                } else {
                    $entry->setImage(null);
                }
                
                $category = $category_repo->find($form->get("category")->getData());
                $entry->setCategory($category);  
                $user = $this->getUser();   
                $entry->setUser($user);
                
                $em->persist($entry);
                
                $flush = $em->flush();
                
                $entry_repo->saveEntryTags(
                        $form->get('tags')->getData(),
                        $form->get('title')->getData(),
                        $category,
                        $user           
                    );
                
                if($flush == null){
                    $status = 'La entrada se ha creado correctamente';
                } else {
                    $status = 'La entrada no se ha podido crear';
                }
                
            }else {
                $status = 'La entrada no se ha creado, revisa tu configuración';
            }
            
          $this->session->getFlashBag()->add("status", $status);
          return $this->redirectToRoute("index_entry");
        }
        
       return $this->render("LeyJusticiaBundle:Entry:add.html.twig", array(
           "form" => $form->createView()
       ));
    }
    
    public function editEntryAction(Request $request, $id){
        
        $em = $this->getDoctrine()->getManager();
            $entry_repo = $em->getRepository("LeyJusticiaBundle:Entry");
            $category_repo = $em->getRepository("LeyJusticiaBundle:Category");
            $entry_tag_repo = $em->getRepository("LeyJusticiaBundle:EntryTag");
            
            $entry = $entry_repo->find($id);
            $entry_image = $entry->getImage();
            
            $tags = '';
            foreach($entry->getEntryTag() as $entryTag) {
                $tags .= $entryTag->getTag()->getName().",";
            }
            
            $form = $this->createForm(EntryType::class, $entry); 
            $form->handleRequest($request);
            
            if($form->isSubmitted()) {
            if($form->isValid()){        
                
                $file = $form["image"]->getData();
                
                if(!empty($file) && $file != null) { 
                    $ext = $file->guessExtension();
                    $file_name = time(). "." . $ext;
                    $file->move("uploads", $file_name);
                    $entry->setImage($file_name);
                } else {
                    $entry->setImage($entry_image);
                }
                
                $category = $category_repo->find($form->get("category")->getData());
                $entry->setCategory($category);  
                $user = $this->getUser();   
                $entry->setUser($user);
                
                $em->persist($entry);
                
                $flush = $em->flush();
                
                $entry_tags = $entry_tag_repo->findBy(array(
                    "entry" => $entry 
                ));
                
                foreach($entry_tags as $et){
                    $em->remove($et);
                    $em->flush();
                }
                
                $entry_repo->saveEntryTags(
                        $form->get('tags')->getData(),
                        $form->get('title')->getData(),
                        $category,
                        $user           
                    );
                
                if($flush == null){
                    $status = 'La entrada se ha editado correctamente';
                } else {
                    $status = 'La entrada no se ha podido editar';
                }
                
            }else {
                $status = 'La entrada no se ha editado, revisa tu configuración';
            }
            
          $this->session->getFlashBag()->add("status", $status);
          return $this->redirectToRoute("index_entry");
        }
            
        return $this->render("LeyJusticiaBundle:Entry:edit.html.twig", array(
            "form" => $form->createView(),
            "entry" => $entry,
            "tags" => $tags
        ));   
                        
    }
    
    
    public function deleteEntryAction($id){
        
        $em = $this->getDoctrine()->getManager();
        $entry_repo = $em->getRepository("LeyJusticiaBundle:Entry");
        $entry_tag_repo = $em->getRepository("LeyJusticiaBundle:EntryTag");
        
        
        $entry = $entry_repo->find($id);
        $entry_tag = $entry_tag_repo->findBy(array("entry" => $entry));
        
        foreach($entry_tag as $et){
            $em->remove($et);
            $em->flush();
        }
        
        $em->remove($entry);
        $em->flush();
        
        return $this->redirectToRoute("index_entry");
        
        
    }
    
    public function singleEntryAction($id){
        
        $em = $this->getDoctrine()->getManager();
        
        $entry_repo = $em->getRepository("LeyJusticiaBundle:Entry");
        $cat_repo = $em->getRepository("LeyJusticiaBundle:Category");
        
        $category = $cat_repo->findAll();
        $entry = $entry_repo->find($id);
        
        
        return $this->render("LeyJusticiaBundle:Entry:single.html.twig", array(
            "categories" => $category,
            "entry"      => $entry
        ));
        
    }
    
    
    
    
    
    
    
}
