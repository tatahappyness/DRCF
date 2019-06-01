<?php

class MouvementHistorique
{
    private $id;
    private $mouvHistoEnregBeLivreNum;
    private $mouvHistoEnregBeNum;
    private $mouvHistoExp;
    private $mouvHistoDest;
    private $mouvHistoType;
    private $mouvHistoDateEnvoiCrea;
    private $mouvHistoDateRetourCrea;
    private $mouvHistoDateReceptionCrea	;
    private $mouvHistoEtatEnvoi;
    private $mouvHistoEtatRetour;
    private $mouvHistoEtatReception;

    public function __construct()
    {
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getMouvHistoEnregBeLivreNum(): ?int
    {
        return $this->mouvHistoEnregBeLivreNum;
    }

    public function setMouvHistoEnregBeLivreNum(int $mouvHistoEnregBeLivreNum): self
    {
        $this->mouvHistoEnregBeLivreNum = $mouvHistoEnregBeLivreNum;

        return $this;
    }

    public function getMouvHistoEnregBeNum(): ?string
    {
        return $this->mouvHistoEnregBeNum;
    }

    public function setMouvHistoEnregBeNum(string $mouvHistoEnregBeNum): self
    {
        $this->mouvHistoEnregBeNum = $mouvHistoEnregBeNum;

        return $this;
    }

    public function getMouvHistoExp(): ?User
    {
        return $this->mouvHistoExp;
    }

    public function setMouvHistoExp(?User $mouvHistoExp): self
    {
        $this->mouvHistoExp = $mouvHistoExp;

        return $this;
    }

    public function getMouvHistoDest(): ?User
    {
        return $this->mouvHistoDest;
    }

    public function setMouvHistoDest(?User $mouvHistoDest): self
    {
        $this->mouvHistoDest = $mouvHistoDest;

        return $this;
    }

    public function getMouvHistoType(): ?string
    {
        return $this->mouvHistoType;
    }

    public function setMouvHistoType(?string $mouvHistoType): self
    {
        $this->mouvHistoType = $mouvHistoType;

        return $this;
    }

    public function getMouvHistoDateEnvoiCrea(): ?string
    {
        return $this->mouvHistoDateEnvoiCrea;
    }

    public function setMouvHistoDateEnvoiCrea(?string $mouvHistoDateEnvoiCrea): self
    {
        $this->mouvHistoDateEnvoiCrea = $mouvHistoDateEnvoiCrea;

        return $this;
    }

    public function getMouvHistoDateRetourCrea(): ?string
    {
        return $this->mouvHistoDateRetourCrea;
    }

    public function setMouvHistoDateRetourCrea(?string $mouvHistoDateRetourCrea): self
    {
        $this->mouvHistoDateRetourCrea = $mouvHistoDateRetourCrea;

        return $this;
    }

    public function getMouvHistoDateReceptionCrea(): ?string
    {
        return $this->mouvHistoDateReceptionCrea;
    }

    public function setMouvHistoDateReceptionCrea(?string $mouvHistoDateReceptionCrea): self
    {
        $this->mouvHistoDateReceptionCrea = $mouvHistoDateReceptionCrea;

        return $this;
    }

    public function getMouvHistoEtatEnvoi(): ?bool
    {
        return $this->mouvHistoEtatEnvoi;
    }

    public function setMouvHistoEtatEnvoi(?bool $mouvHistoEtatEnvoi): self
    {
        $this->mouvHistoEtatEnvoi = $mouvHistoEtatEnvoi;

        return $this;
    }

    public function getMouvHistoEtatRetour(): ?bool
    {
        return $this->mouvHistoEtatRetour;
    }

    public function setMouvHistoEtatRetour(?bool $mouvHistoEtatRetour): self
    {
        $this->mouvHistoEtatRetour = $mouvHistoEtatRetour;

        return $this;
    }

    public function getMouvHistoEtatReception(): ?bool
    {
        return $this->mouvHistoEtatReception;
    }

    public function setMouvHistoEtatReception(?bool $mouvHistoEtatReception): self
    {
        $this->mouvHistoEtatReception = $mouvHistoEtatReception;

        return $this;
    }

}