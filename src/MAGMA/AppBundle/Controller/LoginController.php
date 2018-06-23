<?php

namespace MAGMA\AppBundle\Controller;

use MAGMA\AppBundle\Entity\User;

require_once 'data.php';

class LoginController extends GeneralController {

    public function getVars() {
        parent::getVars();
        $this->data->g_profil = $GLOBALS['g_profil'];
    }

    public function loginAction() {
        $this->getVars();
        if ($this->request->isMethod('POST')) {
            return $this->verifConnexion();
        }
        return $this->render('MAGMAAppBundle:Login:index.html.twig');
    }

    public function logoutAction() {
        $this->getVars();
        $this->session->remove('personnel_id');
        $this->session->remove('personnel_nom');
        $this->session->remove('personnel_prrnom');
        $this->session->remove('profil');
        return $this->redirect($this->generateUrl('login'));
    }

    function verifConnexion() {
        $mp = $this->request->get('mp');
        $login = $this->request->get('login');

        if (empty($login)) {
            $this->session->getFlashBag()->add('msg', 'Veuillez entrer votre login');
            return $this->redirect($this->generateUrl('login'));
        }

        if (empty($mp)) {
            $this->session->getFlashBag()->add('msg', 'Veuillez entrer votre mot de passe');
            return $this->redirect($this->generateUrl('login'));
        }

        $perosnnelsData = $this->entityManager->getRepository($this->personnelRepository)->findBy(
                array('login' => $login, 'mp' => $mp)
        );


        if (isset($perosnnelsData) && !empty($perosnnelsData)) {
            $perosnnelData = $perosnnelsData[0];
            $this->session->set('personnel_id', $perosnnelData->getId());
            $this->session->set('personnel_nom', $perosnnelData->getNom());
            $this->session->set('personnel_prenom', $perosnnelData->getPrenom());
            return $this->redirect($this->generateUrl('home'));
        } else {
            
        }
        $this->session->getFlashBag()->add('msg', 'Veuillez verifier votre login et mot de passe');
        return $this->redirect($this->generateUrl('login'));
    }

}
