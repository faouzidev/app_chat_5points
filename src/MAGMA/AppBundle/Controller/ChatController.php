<?php

namespace MAGMA\AppBundle\Controller;

use MAGMA\AppBundle\Entity\User;
use MAGMA\AppBundle\Entity\Message;

require_once 'data.php';

class ChatController extends GeneralController {

    public $indexTpl = 'MAGMAAppBundle:Chat:index.html.twig';
    public $itemTpl = 'MAGMAAppBundle:Chat:item.html.twig';
    public $repository = 'MAGMAAppBundle:Message';
    public $route_index = 'chat';
    public $route_item = 'chat';

    public function getVars() {
        parent::getVars();
        $this->data->menu = 'user';
        $this->data->title1 = 'Utilisateurs';
        $this->data->title2 = 'Utilisateur';
        $this->data->title3 = 'Gestion des utilisateurs';
        $this->data->g_profil = $GLOBALS['g_profil'];
        $this->data->g_valider = $GLOBALS['g_valider'];

        $this->empty_entity = new Message();
        $this->empty_user = new User();
    }

    public function indexAction() {
        $this->getVars();
//        $this->security();
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
            return $this->redirect($this->generateUrl($this->route_index, array('id' => $this->request->get('destinateur'))));
        } else {
            $this->request = $this->getRequest();
            $id = $this->request->get('id');
            $destinateur_id = $this->request->get('id');
            $this->entityManager = $this->getDoctrine()->getEntityManager();
            $itemData = (isset($id) && !empty($id)) ? $this->entityManager->getRepository($this->repository_user)->find($destinateur_id) : $this->empty_entity;
            $destinateurData = (isset($id) && !empty($id)) ? $this->entityManager->getRepository($this->repository_user)->find($destinateur_id) : $this->empty_user;
            $this->data->msgsData = $this->entityManager->getRepository($this->repository_message)->findBy(
                    array('source' => [$destinateurData->getId(), $this->personnel_id],
                'destinateur' => [$destinateurData->getId(), $this->personnel_id]
                    ), array('date' => 'DESC')
            );
            return $this->render($this->itemTpl, array('destinateurData' => $destinateurData, 'data' => $this->data));
        }
    }

    function store() {
        $id = $this->request->get('id');
        $id = !(isset($id) && !empty($id)) ? 0 : $id;
        $is_new = !(isset($id) && !empty($id));
        //check data
        $msg = "";
        //login empty
        $name = $this->request->get('texte');
        if (empty($msg) && empty($name)) {
            $msg = 'Veuillez entrer le message';
        }
        //login exist
        if (!empty($msg)) {
            $this->session->getFlashBag()->add('msg', $msg);
            if ($this->personnel_id < 1) {
                $this->redirect($this->generateUrl('register'))->sendHeaders();
            } else {
                $this->redirect($this->generateUrl($this->route_item, array('id' => $this->request->get('destinateur'))))->sendHeaders();
            }
            exit;
        }
        $Entity = (isset($id) && !empty($id)) ? $this->entityManager->getRepository($this->repository_message)->find($id) : $this->empty_entity;
        $source = $this->entityManager->getRepository($this->repository_user)->find($this->personnel_id);
        $Entity->setSource($source);
        $destinateur = $this->entityManager->getRepository($this->repository_user)->find($this->request->get('destinateur'));
        $Entity->setDestinateur($destinateur);

        $Entity->setTexte($this->request->get('texte'));

        $date = new \DateTime();
        $Entity->setDate($date);

        $this->entityManager->persist($Entity);
        $this->entityManager->flush();
        $this->session->getFlashBag()->add('success', 'Message envoyé avec succée');
    }

}
