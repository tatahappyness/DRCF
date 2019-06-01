<?php

class RejeterDossier
{
    private $id;
    private $rejetDosEnregBeId;
    private $rejetDosUserId;
    private $rejetDosDateCrea;
    private $rejetDosMotifDesc;
    private $rejetDosMotifType;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getRejetDosEnregBeId(): ?EnregistrementBe
    {
        return $this->rejetDosEnregBeId;
    }

    public function setRejetDosEnregBeId(?EnregistrementBe $rejetDosEnregBeId): self
    {
        $this->rejetDosEnregBeId = $rejetDosEnregBeId;

        return $this;
    }

    public function getRejetDosUserId(): ?User
    {
        return $this->rejetDosUserId;
    }

    public function setRejetDosUserId(User $rejetDosUserId): self
    {
        $this->rejetDosUserId = $rejetDosUserId;

        return $this;
    }

    public function getRejetDosDateCrea(): ?string
    {
        return $this->rejetDosDateCrea;
    }

    public function setRejetDosDateCrea(string $rejetDosDateCrea): self
    {
        $this->rejetDosDateCrea = $rejetDosDateCrea;

        return $this;
    }

    public function getRejetDosMotifDesc(): ?string
    {
        return $this->rejetDosMotifDesc;
    }

    public function setRejetDosMotifDesc(string $rejetDosMotifDesc): self
    {
        $this->rejetDosMotifDesc = $rejetDosMotifDesc;

        return $this;
    }

    public function getRejetDosMotifType(): ?string
    {
        return $this->rejetDosMotifType;
    }

    public function setRejetDosMotifType(string $rejetDosMotifType): self
    {
        $this->rejetDosMotifType = $rejetDosMotifType;

        return $this;
    }
}
