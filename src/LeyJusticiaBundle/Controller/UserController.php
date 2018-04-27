<?php

namespace LeyJusticiaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use LeyJusticiaBundle\Entity\User; 
use Symfony\Component\HttpFoundation\Session\Session;
use LeyJusticiaBundle\Form\UserType; 

class UserController extends Controller
{
    private $session;
    
    public function __construct() {
        $this->session = new Session(); 
    }
    
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $user_repo = $em->getRepository("LeyJusticiaBundle:User");
        $users = $user_repo->findAll();
        
        return $this->render("LeyJusticiaBundle:User:index.html.twig", array(
            "users" => $users
        ));
        
    }
    
    public function loginAction(Request $request) {   
        
     $authenticationUtils = $this->get("security.authentication_utils"); 
     
     $error = $authenticationUtils->getLastAuthenticationError();
     $lastUsername = $authenticationUtils->getLastUserName();
     
     return $this->render("LeyJusticiaBundle:User:login.html.twig", array(
        "error" => $error,
        "last_username" => $lastUsername     
     )); 
       
    }
    
    public function registerAction(Request $request) {
        /* Se manda a llamar el objeto User  */
        
        $user = new User();
        $form = $this->createForm(UserType::class, $user); 
        $form->handleRequest($request);
        
        if($form->isSubmitted()) {
            
            if($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $user_repo = $em->getRepository("LeyJusticiaBundle:User");
                $user = $user_repo->findOneBy(array(
                    "email" => $form->get("email")->getData()
                ));
                
            if(count($user) == 0) {       
                $user = new User();
                $user->setName($form->get("name")->getData());
                $user->setEmail($form->get("email")->getData());

                $factory = $this->get("security.encoder_factory");
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($form->get("password")->getData(), $user->getSalt());   
                $user->setPassword($password);


                $user->setRole("ROLE_USER");
                $user->setImage(null);
                $user->setBiography(null);

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $flush = $em->flush();

                if($flush == null) {
                        $status = "El usuario se ha registrado correctamente";
                    } else {
                        $status = 'No te has registrado correctamente'; 
                    }
            
                } else {
                    $status = 'No te puedes registrar porque el usuario ya existe'; 
                }        
            } else {
                $status = 'No te has registrado correctamente'; 
            }
            
        
            $this->session->getFlashBag()->add("status", $status);
        
        }
        
        return $this->render('LeyJusticiaBundle:User:register.html.twig', [
            'form' => $form->createView(),
            ]);
        /* es la otra forma de crear un array */ 
        
    }
    
    public function editProfileAction(Request $request, $id){
         $em = $this->getDoctrine()->getManager();
            $user_repo = $em->getRepository("LeyJusticiaBundle:User");
            $user = $user_repo->find($id);
            $user_image = $user->getImage();
            
            $form = $this->createForm(UserType::class, $user); 
            $form->handleRequest($request);
            
            if($form->isSubmitted()) {  
                if($form->isValid()) {
                    
                    $factory = $this->get("security.encoder_factory");
                    $encoder = $factory->getEncoder($user);
                    $password = $encoder->encodePassword($form->get("password")->getData(), $user->getSalt());   
                    $user->setPassword($password);
                      
                    $file = $form["image"]->getData();

                     if(!empty($file) && $file != null) { 
                         $ext = $file->guessExtension();
                         $file_name = time(). "." . $ext;
                         $file->move("users", $file_name);
                         $user->setImage($file_name);
                     } else {
                         $user->setImage($user_image);
                    }
                    
                    $user->setBiography($form->get("biography")->getData());

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $flush = $em->flush();

                    if($flush == null) {
                            $status = "El perfil se ha editado correctamente";
                        } else {
                            $status = 'No se ha podido editar correctamente'; 
                        } 
                     
            } else {
                $status = 'No se ha editado'; 
            }
            
        
            $this->session->getFlashBag()->add("status", $status);
            return $this->redirectToRoute("ley_justicia_homepage");
        
        }
        
        return $this->render("LeyJusticiaBundle:User:editprofile.html.twig", array(
            "form" => $form->createView(),
            "user" => $user
        ));
        
    }
    
    public function showProfileAction($id){
        
        $em = $this->getDoctrine()->getManager();
        
        $user_repo = $em->getRepository("LeyJusticiaBundle:User");
        
        $user = $user_repo->find($id);
        
        
        return $this->render("LeyJusticiaBundle:User:profile.html.twig", array(
            "user"      => $user
        ));
    }
    
    
}
