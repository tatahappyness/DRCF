<?php

class LectureDossier
{
    private $id;
    private $lectDosSituation;
    private $lectDosParapheDateCrea;
    private $lectDosEnregBeId;
    private $lectDosUserId;

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

    public function getLectDosSituation(): ?string
    {
        return $this->lectDosSituation;
    }

    public function setLectDosSituation(string $lectDosSituation): self
    {
        $this->lectDosSituation = $lectDosSituation;

        return $this;
    }

    public function getLectDosParapheDateCrea(): ?string
    {
        return $this->lectDosParapheDateCrea;
    }

    public function setLectDosParapheDateCrea(string $lectDosParapheDateCrea): self
    {
        $this->lectDosParapheDateCrea = $lectDosParapheDateCrea;

        return $this;
    }

    public function getLectDosEnregBeId(): ?EnregistrementBe
    {
        return $this->lectDosEnregBeId;
    }

    public function setLectDosEnregBeId(?EnregistrementBe $lectDosEnregBeId): self
    {
        $this->lectDosEnregBeId = $lectDosEnregBeId;

        return $this;
    }

    public function getLectDosUserId(): ?User
    {
        return $this->lectDosUserId;
    }

    public function setLectDosUserId(?User $lectDosUserId): self
    {
        $this->lectDosUserId = $lectDosUserId;

        return $this;
    }
    
}
