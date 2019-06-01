<?php

class EnregistrementBe
{
        
    public $id;
    private $enregBeNum;
    private $enregBeDate;
    private $enregBeServTitulaire;
    private $enregBeContenu;
    private $enregBeobserve;
    private $enregBeDateCrea;
    private $enregBeLivreNum;
    private $enregBeServLieu;
    private $enregBeUserId;
    private $enregBeEtatLire;
    private $enregBeEtatVerifier;
    private $enregBeEtatRejeter;
    private $enregBeEtatViser;
    private $enregBeEtatVisa;
    private $enregBeEtatVerifAfterRejet;
    private $enregBeEtatVisefAfterRejet;
    private $enregBeEtatBetweenDelegChek;


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

    public function getEnregBeNum(): ?string
    {
        return $this->enregBeNum;
    }

    public function setEnregBeNum(string $enregBeNum): self
    {
        $this->enregBeNum = $enregBeNum;

        return $this;
    }

    public function getEnregBeDate(): ?string
    {
        return $this->enregBeDate;
    }

    public function setEnregBeDate(string $enregBeDate): self
    {
        $this->enregBeDate = $enregBeDate;

        return $this;
    }

    public function getEnregBeServTitulaire(): ?string
    {
        return $this->enregBeServTitulaire;
    }

    public function setEnregBeServTitulaire(string $enregBeServTitulaire): self
    {
        $this->enregBeServTitulaire = $enregBeServTitulaire;

        return $this;
    }

    public function getEnregBeContenu(): ?string
    {
        return $this->enregBeContenu;
    }

    public function setEnregBeContenu(string $enregBeContenu): self
    {
        $this->enregBeContenu = $enregBeContenu;

        return $this;
    }

    public function getEnregBeobserve(): ?string
    {
        return $this->enregBeobserve;
    }

    public function setEnregBeobserve(string $enregBeobserve): self
    {
        $this->enregBeobserve = $enregBeobserve;

        return $this;
    }

    public function getEnregBeDateCrea(): ?string
    {
        return $this->enregBeDateCrea;
    }

    public function setEnregBeDateCrea(string $enregBeDateCrea): self
    {
        $this->enregBeDateCrea = $enregBeDateCrea;

        return $this;
    }

    public function getEnregBeLivreNum(): ?int
    {
        return $this->enregBeLivreNum;
    }

    public function setEnregBeLivreNum(int $enregBeLivreNum): self
    {
        $this->enregBeLivreNum = $enregBeLivreNum;

        return $this;
    }

    public function getEnregBeServLieu(): ?string
    {
        return $this->enregBeServLieu;
    }

    public function setEnregBeServLieu(string $enregBeServLieu): self
    {
        $this->enregBeServLieu = $enregBeServLieu;

        return $this;
    }

    public function getEnregBeUserId(): ?User
    {
        return $this->enregBeUserId;
    }

    public function setEnregBeUserId(?User $enregBeUserId): self
    {
        $this->enregBeUserId = $enregBeUserId;

        return $this;
    }

    public function getEnregBeEtatLire(): ?bool
    {
        return $this->enregBeEtatLire;
    }

    public function setEnregBeEtatlire(bool $enregBeEtatLire): self
    {
        $this->enregBeEtatLire = $enregBeEtatLire;

        return $this;
    }

    public function getEnregBeEtatVerifier(): ?bool
    {
        return $this->enregBeEtatVerifier;
    }

    public function setEnregBeEtatVerifier(?bool $enregBeEtatVerifier): self
    {
        $this->enregBeEtatVerifier = $enregBeEtatVerifier;

        return $this;
    }

    public function getEnregBeEtatRejeter(): ?bool
    {
        return $this->enregBeEtatRejeter;
    }

    public function setEnregBeEtatRejeter(?bool $enregBeEtatRejeter): self
    {
        $this->enregBeEtatRejeter = $enregBeEtatRejeter;

        return $this;
    }

    public function getEnregBeEtatViser(): ?bool
    {
        return $this->enregBeEtatViser;
    }

    public function setEnregBeEtatViser(?bool $enregBeEtatViser): self
    {
        $this->enregBeEtatViser = $enregBeEtatViser;

        return $this;
    }

    public function getEnregBeEtatVisa(): ?bool
    {
        return $this->enregBeEtatVisa;
    }

    public function setEnregBeEtatVisa(?bool $enregBeEtatVisa): self
    {
        $this->enregBeEtatVisa = $enregBeEtatVisa;

        return $this;
    }

    public function getEnregBeEtatVerifAfterRejet(): ?bool
    {
        return $this->enregBeEtatVerifAfterRejet;
    }

    public function setEnregBeEtatVerifAfterRejet(?bool $enregBeEtatVerifAfterRejet): self
    {
        $this->enregBeEtatVerifAfterRejet = $enregBeEtatVerifAfterRejet;

        return $this;
    }

    public function getEnregBeEtatViseAfterRejet(): ?bool
    {
        return $this->enregBeEtatViseAfterRejet;
    }

    public function setEnregBeEtatViseAfterRejet(?bool $enregBeEtatViseAfterRejet): self
    {
        $this->enregBeEtatViseAfterRejet = $enregBeEtatViseAfterRejet;

        return $this;
    }

    public function getEnregBeEtatBetweenDelegChek(): ?bool
    {
        return $this->enregBeEtatBetweenDelegChek;
    }

    public function setEnregBeEtatBetweenDelegChek(?bool $enregBeEtatBetweenDelegChek): self
    {
        $this->enregBeEtatBetweenDelegChek = $enregBeEtatBetweenDelegChek;

        return $this;
    }

}
