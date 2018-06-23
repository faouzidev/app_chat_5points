<?php

namespace MAGMA\AppBundle\Controller;

use MAGMA\AppBundle\Entity\User;

require_once 'data.php';

class UserController extends GeneralController {

    public $indexTpl = 'MAGMAAppBundle:User:index.html.twig';
    public $itemTpl = 'MAGMAAppBundle:User:item.html.twig';
    public $repository = 'MAGMAAppBundle:User';
    public $route_index = 'login';
    public $route_item = 'register';

    public function getVars() {
        parent::getVars();
        $this->data->menu = 'user';
        $this->data->title1 = 'Utilisateurs';
        $this->data->title2 = 'Utilisateur';
        $this->data->title3 = 'Gestion des utilisateurs';
        $this->data->g_profil = $GLOBALS['g_profil'];
        $this->data->g_valider = $GLOBALS['g_valider'];

        $this->empty_entity = new User();
    }

    public function indexAction() {
        $this->getVars();
        //    $this->security();
        $itemsData = $this->entityManager->getRepository($this->repository)->findAll();
        return $this->render($this->indexTpl, array('itemsData' => $itemsData, 'data' => $this->data));
    }

    function itemAction() {
        $this->getVars();
        // $this->security();
//        $profilsData = $GLOBALS['g_profil'];
        if ($this->request->isMethod('POST')) {
            $response = $this->store();
            if ($response instanceof \Symfony\Component\HttpFoundation\Response) {
                return $response;
            }
            return $this->redirect($this->generateUrl($this->route_index));
        } else {
            $this->request = $this->getRequest();
            $id = $this->request->get('id');
            $this->entityManager = $this->getDoctrine()->getEntityManager();
            //$this->data->matieres = $this->entityManager->getRepository($this->repository_matiere)->findAll();
            $itemData = (isset($id) && !empty($id)) ? $this->entityManager->getRepository($this->repository)->find($id) : $this->empty_entity;
            return $this->render($this->itemTpl, array('item' => $itemData, 'data' => $this->data));
        }
    }

    function desactiverAction() {
        $this->getVars();
        // $this->security();
//        $profilsData = $GLOBALS['g_profil'];
        if ($this->request->isMethod('POST')) {
            $Entity = $this->entityManager->getRepository($this->repository)->find($this->personnel_id);
            $Entity->setValider(0);
            $this->entityManager->persist($Entity);
            $this->entityManager->flush();
            $this->session->getFlashBag()->add('success', 'desactivation terminée avec succée');
            return $this->redirect($this->generateUrl('logout'));
        } else {
            $this->request = $this->getRequest();
            $id = $this->request->get('id');
            $this->entityManager = $this->getDoctrine()->getEntityManager();
            //$this->data->matieres = $this->entityManager->getRepository($this->repository_matiere)->findAll();
            $itemData = $this->entityManager->getRepository($this->repository)->find($this->personnel_id);
            return $this->render('MAGMAAppBundle:User:desactiver.html.twig', array('item' => $itemData, 'data' => $this->data));
        }
    }

    function store() {
        $id = $this->request->get('id');
        $id = !(isset($id) && !empty($id)) ? 0 : $id;
        $is_new = !(isset($id) && !empty($id));
        //check data
        $msg = "";
        //login empty
        $name = $this->request->get('nom');
        if (empty($msg) && empty($name)) {
            $msg = 'Veuillez entrer le nom';
        }
        $prenom = $this->request->get('prenom');
        if (empty($msg) && empty($prenom)) {
            $msg = 'Veuillez entrer le prenom';
        }
        $mp = $this->request->get('mp');
        if (empty($msg) && empty($mp)) {
            $msg = 'Veuillez entrer le mot de passe';
        }
        $mp_2 = $this->request->get('mp_2');
        if (empty($msg) && empty($mp_2)) {
            $msg = 'Veuillez entrer la confirmation du mot de passe';
        }
        if (empty($msg) && $mp_2 != $mp) {
            $msg = 'Veuillez vérifier votre mot de passe';
        }
        $login = $this->request->get('login');
        if (empty($msg) && empty($login)) {
            $msg = 'Veuillez entrer votre login';
        }
        $mail = $this->request->get('mail');
        if (empty($msg) && empty($login)) {
            $msg = 'Veuillez entrer votre e-mail';
        }
        //login exist
        if (!empty($msg)) {
            $this->session->getFlashBag()->add('msg', $msg);
            if ($this->personnel_id < 1) {
                $this->redirect($this->generateUrl('register'))->sendHeaders();
            } else {
                $this->redirect($this->generateUrl($this->route_item, array('id' => $id)))->sendHeaders();
            }
            exit;
        }
        $Entity = (isset($id) && !empty($id)) ? $this->entityManager->getRepository($this->repository)->find($id) : $this->empty_entity;
//        $user = $this->entityManager->getRepository($this->repository_user)->find($this->personnel_id);
        $Entity->setNom($this->request->get('nom'));
        $Entity->setPrenom($this->request->get('prenom'));
        $Entity->setMp($this->request->get('mp'));
        $Entity->setLogin($this->request->get('login'));
        $Entity->setMail($this->request->get('mail'));
        $this->entityManager->persist($Entity);
        $this->entityManager->flush();
        $this->session->getFlashBag()->add('success', 'Operation terminée avec succée');
    }

    function removeAction() {
        $this->getVars();
        $request = $this->getRequest();
        $id = $request->get('id');
        $e = $this->entityManager->getRepository($this->repository)->find($id);
        $this->entityManager->remove($e);
        $this->entityManager->flush();
        $this->session->getFlashBag()->add('success', 'Operation terminée avec succée');
        return $this->redirect($this->generateUrl($this->route_index));
    }

    function registerAction() {
        $this->getVars();
        // $this->security();
//        $profilsData = $GLOBALS['g_profil'];
        if ($this->request->isMethod('POST')) {
            $response = $this->store();
            if ($response instanceof \Symfony\Component\HttpFoundation\Response) {
                return $response;
            }
            $this->session->getFlashBag()->add('success', 'inscription terminée avec succée');
            return $this->redirect($this->generateUrl('login'));
        } else {
            $this->request = $this->getRequest();
            $id = $this->request->get('id');
            $this->entityManager = $this->getDoctrine()->getEntityManager();
            //$this->data->matieres = $this->entityManager->getRepository($this->repository_matiere)->findAll();
            $itemData = (isset($id) && !empty($id)) ? $this->entityManager->getRepository($this->repository)->find($id) : $this->empty_entity;
            return $this->render('MAGMAAppBundle:User:register.html.twig', array('item' => $itemData, 'data' => $this->data));
        }
    }

}
