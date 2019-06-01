<?php

class AffectationDossier
{
    private $id;
    private $affectDosEnregBeLivreNum;
    private $affectDosEnregBeNum;
    private $affectDosDateCrea;
    private $affectDosUserId;
    private $affectDosEtat;
    private $affectDosEtatAcceptation;

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

    public function getAffectDosEnregBeLivreNum(): ?int
    {
        return $this->affectDosEnregBeLivreNum;
    }

    public function setAffectDosEnregBeLivreNum(int $affectDosEnregBeLivreNum): self
    {
        $this->affectDosEnregBeLivreNum = $affectDosEnregBeLivreNum;

        return $this;
    }

    public function getAffectDosEnregBeNum(): ?string
    {
        return $this->affectDosEnregBeNum;
    }

    public function setAffectDosEnregBeNum(string $affectDosEnregBeNum): self
    {
        $this->affectDosEnregBeNum = $affectDosEnregBeNum;

        return $this;
    }

    public function getAffectDosDateCrea(): ?string
    {
        return $this->affectDosDateCrea;
    }

    public function setAffectDosDateCrea(?string $affectDosDateCrea): self
    {
        $this->affectDosDateCrea = $affectDosDateCrea;

        return $this;
    }

    public function getAffectDosUserId(): ?User
    {
        return $this->affectDosUserId;
    }

    public function setAffectDosUserId(?User $affectDosUserId): self
    {
        $this->affectDosUserId = $affectDosUserId;

        return $this;
    }

    public function getAffectDosUserIdExp(): ?User
    {
        return $this->affectDosUserIdExp;
    }

    public function setAffectDosUserIdExp(?User $affectDosUserIdExp): self
    {
        $this->affectDosUserIdExp = $affectDosUserIdExp;

        return $this;
    }

    public function getAffectDosEtat(): ?bool
    {
        return $this->affectDosEtat;
    }

    public function setAffectDosEtat(?bool $affectDosEtat): self
    {
        $this->affectDosEtat = $affectDosEtat;

        return $this;
    }

    public function getAffectDosEtatAcceptation(): ?bool
    {
        return $this->affectDosEtatAcceptation;
    }

    public function setAffectDosEtatAcceptation(?bool $affectDosEtatAcceptation): self
    {
        $this->affectDosEtatAcceptation = $affectDosEtatAcceptation;

        return $this;
    }
    
}
