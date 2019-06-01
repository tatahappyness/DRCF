<?php

class EnregistrementTef
{
    private $id;
    private $enregTefEnregBeLivreNum;
    private $enregTefEnregBeNum;
    private $enregTefNum;
    private $enregTefObjet;
    private $enregTefDateCrea;
    private $enregTefUserId;
    private $enregTefEtat;
    private $enregTefDate;
    private $enregTtefNumVisa;

    public function __construct()
    {
        
    }

    public function getEnregTefEnregBeLivreNum(): ?int
    {
        return $this->enregTefEnregBeLivreNum;
    }

    public function setEnregTefEnregBeLivreNum(int $enregTefEnregBeLivreNum): self
    {
        $this->enregTefEnregBeLivreNum = $enregTefEnregBeLivreNum;

        return $this;
    }

    public function getEnregTefEnregBeNum(): ?string
    {
        return $this->enregTefEnregBeNum;
    }

    public function setEnregTefEnregBeNum(string $enregTefEnregBeNum): self
    {
        $this->enregTefEnregBeNum = $enregTefEnregBeNum;

        return $this;
    }

    public function getEnregTefNum(): ?string
    {
        return $this->enregTefNum;
    }

    public function setEnregTefNum(?string $enregTefNum): self
    {
        $this->enregTefNum = $enregTefNum;

        return $this;
    }

    public function getEnregTefDateCrea(): ?string
    {
        return $this->enregTefDateCrea;
    }

    public function setEnregTefDateCrea(?string $enregTefDateCrea): self
    {
        $this->enregTefDateCrea = $enregTefDateCrea;

        return $this;
    }

    public function getEnregTefUserId(): ?User
    {
        return $this->enregTefUserId;
    }

    public function setEnregTefUserId(?User $enregTefUserId): self
    {
        $this->enregTefUserId = $enregTefUserId;

        return $this;
    }

    public function getEnregTefEtat(): ?bool
    {
        return $this->enregTefEtat;
    }

    public function setEnregTefEtat(?bool $enregTefEtat): self
    {
        $this->enregTefEtat = $enregTefEtat;

        return $this;
    }

    public function getEnregTefObjet(): ?string
    {
        return $this->enregTefObjet;
    }

    public function setEnregTefObjet(?string $enregTefObjet): self
    {
        $this->enregTefObjet = $enregTefObjet;

        return $this;
    }

    public function getEnregTefDate(): ?string
    {
        return $this->enregTefDate;
    }

    public function setEnregTefDate(?string $enregTefDate): self
    {
        $this->enregTefDate = $enregTefDate;

        return $this;
    }

    public function getEnregTtefNumVisa(): ?string
    {
        return $this->enregTtefNumVisa;
    }

    public function setEnregTtefNumVisa(?string $enregTtefNumVisa): self
    {
        $this->enregTtefNumVisa = $enregTtefNumVisa;

        return $this;
    }

}