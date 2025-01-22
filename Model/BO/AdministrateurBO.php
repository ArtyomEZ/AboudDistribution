<?php

namespace Model\BO;

class AdministrateurBO
{
    private int $id_admin;
    private String $login_admin;
    private String $mdp_admin;

    public function Administrateur(int $id_admin, String $login_admin, String $mdp_admin)
    {
        $this->id_admin = $id_admin;
        $this->login_admin = $login_admin;
        $this->mdp_admin = $mdp_admin;
    }

    public function getIdAdmin(): int
    {
        return $this->id_admin;
    }

    public function setIdAdmin(int $id_admin): void
    {
        $this->id_admin = $id_admin;
    }

    public function getLoginAdmin(): string
    {
        return $this->login_admin;
    }

    public function setLoginAdmin(string $login_admin): void
    {
        $this->login_admin = $login_admin;
    }

    public function getMdpAdmin(): string
    {
        return $this->mdp_admin;
    }

    public function setMdpAdmin(string $mdp_admin): void
    {
        $this->mdp_admin = $mdp_admin;
    }

}