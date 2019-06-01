<?php

class EnregistrementVisa
{
    private $id;
    private $enregVisaLivreNum;
    private $enregVisaLivreDateCrea;
    private $enregVisaNum;
    private $enregVisaDate;
    private $enregVisaUserId;
    private $enregVisaEnregBeId;

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

    public function getEnregVisaLivreNum(): ?int
    {
        return $this->enregVisaLivreNum;
    }

    public function setEnregVisaLivreNum(int $enregVisaLivreNum): self
    {
        $this->enregVisaLivreNum = $enregVisaLivreNum;

        return $this;
    }

    public function getEnregVisaLivreDateCrea(): ?string
    {
        return $this->enregVisaLivreDateCrea;
    }

    public function setEnregVisaLivreDateCrea(string $enregVisaLivreDateCrea): self
    {
        $this->enregVisaLivreDateCrea = $enregVisaLivreDateCrea;

        return $this;
    }

    public function getEnregVisaNum(): ?string
    {
        return $this->enregVisaNum;
    }

    public function setEnregVisaNum(string $enregVisaNum): self
    {
        $this->enregVisaNum = $enregVisaNum;

        return $this;
    }

    public function getEnregVisaDate(): ?string
    {
        return $this->enregVisaDate;
    }

    public function setEnregVisaDate(string $enregVisaDate): self
    {
        $this->enregVisaDate = $enregVisaDate;

        return $this;
    }

    public function getEnregVisaUserId(): ?User
    {
        return $this->enregVisaUserId;
    }

    public function setEnregVisaUserId(?User $enregVisaUserId): self
    {
        $this->enregVisaUserId = $enregVisaUserId;

        return $this;
    }

    public function getEnregVisaEnregBeId(): ?EnregistrementBe
    {
        return $this->enregVisaEnregBeId;
    }

    public function setEnregVisaEnregBeId(?EnregistrementBe $enregVisaEnregBeId): self
    {
        $this->enregVisaEnregBeId = $enregVisaEnregBeId;

        return $this;
    }

}
