<?php

class EnregistrementDef
{
    private $id;
    private $enregDefEnregBe;
    private $enregDefNum;
    private $enregDefObjet;
    private $enregDefTitulaire;
    private $enregDefMontant;
    private $enregDefService;
    private $enregDefDateCrea;
    private $enregDefVisa;
    private $enregDefUserId;
    private $enregDefEnregBeLivreNum;
    private $enregDefMotifType;
    private $enregDefMotifDesc;
    private $enregDefEtatViser;
    private $enregDefEtatRejeter;
    private $enregDefEtatViseAfterReject;
    private $enregDefDateDaraphe;

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

    public function getEnregDefNum(): ?int
    {
        return $this->enregDefNum;
    }

    public function setEnregDefNum(int $enregDefNum): self
    {
        $this->enregDefNum = $enregDefNum;

        return $this;
    }

    public function getEnregDefObjet(): ?string
    {
        return $this->enregDefObjet;
    }

    public function setEnregDefObjet(string $enregDefObjet): self
    {
        $this->enregDefObjet = $enregDefObjet;

        return $this;
    }

    public function getEnregDefTitulaire(): ?string
    {
        return $this->enregDefTitulaire;
    }

    public function setEnregDefTitulaire(string $enregDefTitulaire): self
    {
        $this->enregDefTitulaire = $enregDefTitulaire;

        return $this;
    }

    public function getEnregDefMontant(): ?float
    {
        return $this->enregDefMontant;
    }

    public function setEnregDefMontant(float $enregDefMontant): self
    {
        $this->enregDefMontant = $enregDefMontant;

        return $this;
    }

    public function getEnregDefService(): ?string
    {
        return $this->enregDefService;
    }

    public function setEnregDefService(string $enregDefService): self
    {
        $this->enregDefService = $enregDefService;

        return $this;
    }

    public function getEnregDefDateCrea(): ?string
    {
        return $this->enregDefDateCrea;
    }

    public function setEnregDefDateCrea(string $enregDefDateCrea): self
    {
        $this->enregDefDateCrea = $enregDefDateCrea;

        return $this;
    }

    public function getEnregDefVisa(): ?int
    {
        return $this->enregDefVisa;
    }

    public function setEnregDefVisa(int $enregDefVisa): self
    {
        $this->enregDefVisa = $enregDefVisa;

        return $this;
    }

    public function getEnregDefUserId(): ?User
    {
        return $this->enregDefUserId;
    }

    public function setEnregDefUserId(?User $enregDefUserId): self
    {
        $this->enregDefUserId = $enregDefUserId;

        return $this;
    }

    public function getEnregDefEnregBeLivreNum(): ?int
    {
        return $this->enregDefEnregBeLivreNum;
    }

    public function setEnregDefEnregBeLivreNum(int $enregDefEnregBeLivreNum): self
    {
        $this->enregDefEnregBeLivreNum = $enregDefEnregBeLivreNum;

        return $this;
    }

    public function getEnregDefMotifType(): ?string
    {
        return $this->enregDefMotifType;
    }

    public function setEnregDefMotifType(string $enregDefMotifType): self
    {
        $this->enregDefMotifType = $enregDefMotifType;

        return $this;
    }

    public function getEnregDefMotifDesc(): ?string
    {
        return $this->enregDefMotifDesc;
    }

    public function setEnregDefMotifDesc(string $enregDefMotifDesc): self
    {
        $this->enregDefMotifDesc = $enregDefMotifDesc;

        return $this;
    }

    public function getEnregDefEtatViser(): ?bool
    {
        return $this->enregDefEtatViser;
    }

    public function setEnregDefEtatViser(bool $enregDefEtatViser): self
    {
        $this->enregDefEtatViser = $enregDefEtatViser;

        return $this;
    }

    public function getEnregDefEtatRejeter(): ?bool
    {
        return $this->enregDefEtatRejeter;
    }

    public function setEnregDefEtatRejeter(bool $enregDefEtatRejeter): self
    {
        $this->enregDefEtatRejeter = $enregDefEtatRejeter;

        return $this;
    }

    public function getEnregDefEtatViseAfterReject(): ?bool
    {
        return $this->enregDefEtatViseAfterReject;
    }

    public function setEnregDefEtatViseAfterReject(bool $enregDefEtatViseAfterReject): self
    {
        $this->enregDefEtatViseAfterReject = $enregDefEtatViseAfterReject;

        return $this;
    }

    public function getEnregDefDateDaraphe(): ?string
    {
        return $this->enregDefDateDaraphe;
    }

    public function setEnregDefDateDaraphe(string $enregDefDateDaraphe): self
    {
        $this->enregDefDateDaraphe = $enregDefDateDaraphe;

        return $this;
    }
}
