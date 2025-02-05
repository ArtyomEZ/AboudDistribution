<?php

namespace Model\BO;

class UtilisateurBO
{
    private int $id_uti;
    private String $login_uti;
    private String $mdp_uti;
    private String $adr_mail;

    public function __construct($id_uti, $login_uti, $mdp_uti, $adr_mail) {
        $this->id_uti = $id_uti;
        $this->login_uti = $login_uti;
        $this->mdp_uti = $mdp_uti;
        $this->adr_mail = $adr_mail ?? 'Non renseigné';
    }

    public function getIdUti(): int
    {
        return $this->id_uti;
    }

    public function setIdUti(int $id_uti): void
    {
        $this->id_uti = $id_uti;
    }

    public function getLoginUti(): string
    {
        return $this->login_uti;
    }

    public function setLoginUti(string $login_uti): void
    {
        $this->login_uti = $login_uti;
    }

    public function getMdpUti(): string
    {
        return $this->mdp_uti;
    }

    public function setMdpUti(string $mdp_uti): void
    {
        $this->mdp_uti = $mdp_uti;
    }

    public function getAdrMail(): string
    {
        return $this->adr_mail;
    }

    public function setAdrMail(string $adr_mail): void
    {
        $this->adr_mail = $adr_mail;
    }

}