<?php

class ViserDossier
{
    private $id;
    private $viseDosUserId;
    private $viseDosEnregBeId;
    private $viseDosDateCrea;

    public function __construct() 
    {
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id ;
        return $this;
    }

    public function getViseDosUserId(): ?User
    {
        return $this->viseDosUserId;
    }

    public function setViseDosUserId(?User $viseDosUserId): self
    {
        $this->viseDosUserId = $viseDosUserId;

        return $this;
    }

    public function getViseDosEnregBeId(): ?EnregistrementBe
    {
        return $this->viseDosEnregBeId;
    }

    public function setViseDosEnregBeId(?EnregistrementBe $viseDosEnregBeId): self
    {
        $this->viseDosEnregBeId = $viseDosEnregBeId;

        return $this;
    }

    public function getViseDosDateCrea(): ?string
    {
        return $this->viseDosDateCrea;
    }

    public function setViseDosDateCrea(string $viseDosDateCrea): self
    {
        $this->viseDosDateCrea = $viseDosDateCrea;

        return $this;
    }
}
