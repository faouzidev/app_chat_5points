<?php

namespace MAGMA\AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GeneralController extends Controller {

    public function getVars() {
        // entity Manager
        $this->entityManager = $this->getDoctrine()->getEntityManager();
        $this->session = new Session();
        $this->request = $this->getRequest();
        // définit et récupère des attributs de session
        $this->personnel_id = $this->session->get('personnel_id');
//        $personnel_emptyData = new User();
        $entityManager = $this->getDoctrine()->getEntityManager();
        $this->personnelRepository = 'MAGMAAppBundle:User';
        $this->repository_user = 'MAGMAAppBundle:User';
        $this->repository_message = 'MAGMAAppBundle:Message';
//        $this->repository_message = 'MAGMAAppBundle:Message';
//        $this->userData = (isset($this->personnel_id) && !empty($this->personnel_id)) ? $entityManager->getRepository($this->personnelRepository)->find($this->personnel_id) : $personnel_emptyData;

        $this->data = new \stdClass();
        $this->data->menu = '';
        $this->data->profil = $this->session->get('profil');
//        $this->data->g_profil = $GLOBALS['g_profil'];
        // get 
        $this->data->count_msg = 0;
        if ($this->personnel_id > 0) {
//            $builder = $this->entityManager->getRepository($this->repository_message)->createQueryBuilder('e')->addSelect();
//            $builder = $builder->where("e.destinateur =" . $this->personnel_id . " and e.nouveau =" . 1);
//            $itemsData = $builder->getQuery()->getResult();
//            $this->data->count_msg = count($itemsData);
        }
        $filter = ['vue' => 0];
        if ($this->data->profil != 1) {
            $filter = ['vue' => 0, 'agent' => $this->personnel_id, 'traitement' => array(1, 4)];
        } else {
            $filter = ['vue' => 0, 'traitement' => array(2, 3)];
        }
        $this->data->users = $this->entityManager->getRepository($this->repository_user)->findAll();
    }

    public function security() {
        //verif session
        $this->personnel_id = $this->session->get('personnel_id');
        if (!isset($this->personnel_id) || empty($this->personnel_id)) {
            $this->redirect($this->generateUrl('login'))->sendHeaders();
            exit;
        }
        // end verif session
    }

    public function indexAction() {
        $this->getVars();
        return $this->render('MAGMAAppBundle:Chat:index.html.twig', array('data' => $this->data));
    }
 

}
