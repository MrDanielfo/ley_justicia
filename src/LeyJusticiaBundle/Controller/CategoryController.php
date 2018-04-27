<?php

namespace LeyJusticiaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use LeyJusticiaBundle\Entity\Category; 
use Symfony\Component\HttpFoundation\Session\Session;
use LeyJusticiaBundle\Form\CategoryType; 

class CategoryController extends Controller
{
    private $session;
    
    public function __construct() {
        $this->session = new Session(); 
    }
    
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $category_repo = $em->getRepository("LeyJusticiaBundle:Category");
        $categories = $category_repo->findAll();
        
        return $this->render("LeyJusticiaBundle:Category:index.html.twig", array(
            "categories" => $categories
        ));
        
    }
    
    public function addCatAction(Request $request) {   
        
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category); 
        $form->handleRequest($request); 
        
        if($form->isSubmitted()) {
            if($form->isValid()){
                
                $category = new Category();
                $category->setName($form->get("name")->getData());
                $category->setDescription($form->get("description")->getData());
                
                $em = $this->getDoctrine()->getManager();
                
                $em->persist($category);
                
                $flush = $em->flush();
                
                if($flush == null){
                    $status = 'La categoría se ha creado correctamente';
                } else {
                    $status = 'La categoría no se ha podido crear';
                }
                
            }else {
                $status = 'La categoría no se ha creado, revisa tu configuración';
            }
            
          $this->session->getFlashBag()->add("status", $status);
          return $this->redirectToRoute("index_cat");
        }
        
       return $this->render("LeyJusticiaBundle:Category:add.html.twig", array(
           "form" => $form->createView()
       ));
    }
    
    public function deleteAction($id){
        
        $em = $this->getDoctrine()->getManager();
        $category_repo = $em->getRepository("LeyJusticiaBundle:Category");
        $category = $category_repo->find($id);
        
        if(count($category->getEntries()) == 0 ) {
            $em->remove($category);
            $em->flush();
        }
        
        return $this->redirectToRoute("index_cat");
        
    }
    
    public function editAction(Request $request, $id) {
        
        $em = $this->getDoctrine()->getManager();
        $category_repo = $em->getRepository("LeyJusticiaBundle:Category");
        $category = $category_repo->find($id);
        
        $form = $this->createForm(CategoryType::class, $category); 
        $form->handleRequest($request);
        
        if($form->isSubmitted()) {
            if($form->isValid()){
               
                $category->setName($form->get("name")->getData());
                $category->setDescription($form->get("description")->getData());
                
                $em = $this->getDoctrine()->getManager();
                
                $em->persist($category);
                
                $flush = $em->flush();
                
                if($flush == null){
                    $status = 'La categoría se ha editado correctamente';
                } else {
                    $status = 'La categoría no se ha podido editado';
                }
                
            }else {
                $status = 'La categoría no se ha editado, revisa tu configuración';
            }
            
          $this->session->getFlashBag()->add("status", $status);
          return $this->redirectToRoute("index_cat");
        }
        
        
        return $this->render("LeyJusticiaBundle:Category:edit.html.twig", array(
           "form" => $form->createView()
       ));
    }
    
    public function entriesCategoriesAction($id, $page){
        
        $em = $this->getDoctrine()->getManager();  
        $category_repo = $em->getRepository("LeyJusticiaBundle:Category");
        $categories = $category_repo->findAll();
        $category = $category_repo->find($id);
        
        $entry_repo = $em->getRepository("LeyJusticiaBundle:Entry");
        
        $pageSize = 6;
        $entries = $entry_repo->getCategoryEntries($category, $pageSize, $page);
        $totalItems = count($entries); 
        $pagesCount = ceil($totalItems/$pageSize);
        
        return $this->render("LeyJusticiaBundle:Category:entrycategory.html.twig", array(
            "category" => $category,
            "categories" => $categories,
            "entries"    => $entries,
            "totalItems" => $totalItems,
            "pagesCount" => $pagesCount,
            "page"       => $page,
            "page_m"     => $page
        )); 
        
    }
    
    
    
}
