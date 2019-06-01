<?php

class VerificationDossier
{
   
    private $id;
    private $verifDosModePass;
    private $verifDosDateEtNum;
    private $verifDosNumCompt;
    private $verifDosIntituleActivPrest;
    private $verifDosRealisePysique;
    private $verifDosMontant;
    private $verifDosVisaCf;
    private $verifDosCasPossible;
    private $verifDosDateCrea;
    private $verifDosEnregBeId;
    private $verifDosUserId;

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

    public function getVerifDosModePass(): ?string
    {
        return $this->verifDosModePass;
    }

    public function setVerifDosModePass(string $verifDosModePass): self
    {
        $this->verifDosModePass = $verifDosModePass;

        return $this;
    }

    public function getVerifDosDateEtNum(): ?string
    {
        return $this->verifDosDateEtNum;
    }

    public function setVerifDosDateEtNum(string $verifDosDateEtNum): self
    {
        $this->verifDosDateEtNum = $verifDosDateEtNum;

        return $this;
    }

    public function getVerifDosNumCompt(): ?string
    {
        return $this->verifDosNumCompt;
    }

    public function setVerifDosNumCompt(string $verifDosNumCompt): self
    {
        $this->verifDosNumCompt = $verifDosNumCompt;

        return $this;
    }

    public function getVerifDosIntituleActivPrest(): ?string
    {
        return $this->verifDosIntituleActivPrest;
    }

    public function setVerifDosIntituleActivPrest(string $verifDosIntituleActivPrest): self
    {
        $this->verifDosIntituleActivPrest = $verifDosIntituleActivPrest;

        return $this;
    }

    public function getVerifDosRealisePysique(): ?string
    {
        return $this->verifDosRealisePysique;
    }

    public function setVerifDosRealisePysique(string $verifDosRealisePysique): self
    {
        $this->verifDosRealisePysique = $verifDosRealisePysique;

        return $this;
    }

    public function getVerifDosMontant(): ?float
    {
        return $this->verifDosMontant;
    }

    public function setVerifDosMontant(float $verifDosMontant): self
    {
        $this->verifDosMontant = $verifDosMontant;

        return $this;
    }

    public function getVerifDosVisaCf(): ?string
    {
        return $this->verifDosVisaCf;
    }

    public function setVerifDosVisaCf(string $verifDosVisaCf): self
    {
        $this->verifDosVisaCf = $verifDosVisaCf;

        return $this;
    }

    public function getVerifDosCasPossible(): ?string
    {
        return $this->verifDosCasPossible;
    }

    public function setVerifDosCasPossible(string $verifDosCasPossible): self
    {
        $this->verifDosCasPossible = $verifDosCasPossible;

        return $this;
    }

    public function getVerifDosDateCrea(): ?string
    {
        return $this->verifDosDateCrea;
    }

    public function setVerifDosDateCrea(string $verifDosDateCrea): self
    {
        $this->verifDosDateCrea = $verifDosDateCrea;

        return $this;
    }

    public function getVerifDosEnregBeId(): ?EnregistrementBe
    {
        return $this->verifDosEnregBeId;
    }

    public function setVerifDosEnregBeId(?EnregistrementBe $verifDosEnregBeId): self
    {
        $this->verifDosEnregBeId = $verifDosEnregBeId;

        return $this;
    }

    public function getVerifDosUserId(): ?User
    {
        return $this->verifDosUserId;
    }

    public function setVerifDosUserId(?User $verifDosUserId): self
    {
        $this->verifDosUserId = $verifDosUserId;

        return $this;
    }
}
