<?php

class DistributionDossier
{
    public $id;
    private $distDosEnregBeId;
    private $distDosDateCrea;
    private $distDosAction;
    private $distDosDateEnvoi;
    private $distDosUserId;

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

    public function getDistDosEnregBeId(): ?EnregistrementBe
    {
        return $this->distDosEnregBeId;
    }

    public function setDistDosEnregBeId(?EnregistrementBe $distDosEnregBeId): self
    {
        $this->distDosEnregBeId = $distDosEnregBeId;

        return $this;
    }

    public function getDistDosDateCrea(): ?string
    {
        return $this->distDosDateCrea;
    }

    public function setDistDosDateCrea(string $distDosDateCrea): self
    {
        $this->distDosDateCrea = $distDosDateCrea;

        return $this;
    }

    public function getDistDosAction(): ?string
    {
        return $this->distDosAction;
    }

    public function setDistDosAction(string $distDosAction): self
    {
        $this->distDosAction = $distDosAction;

        return $this;
    }

    public function getDistDosDateEnvoi(): ?string
    {
        return $this->distDosDateEnvoi;
    }

    public function setDistDosDateEnvoi(string $distDosDateEnvoi): self
    {
        $this->distDosDateEnvoi = $distDosDateEnvoi;

        return $this;
    }

    public function getDistDosUserId(): ?User
    {
        return $this->distDosUserId;
    }

    public function setDistDosUserId(?User $distDosUserId): self
    {
        $this->distDosUserId = $distDosUserId;

        return $this;
    }
}
