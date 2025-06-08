<?php

namespace App\Entity;

use App\Repository\ScanReadRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScanReadRepository::class)]
class ScanRead
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'scanReads')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $id_user = null;

    #[ORM\ManyToOne(inversedBy: 'scanReads')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Scan $id_scan = null;

    #[ORM\Column]
    private ?int $lastChapterRead = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $DateLastChapRead = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?User
    {
        return $this->id_user;
    }

    public function setIdUser(?User $id_user): static
    {
        $this->id_user = $id_user;

        return $this;
    }

    public function getIdScan(): ?Scan
    {
        return $this->id_scan;
    }

    public function setIdScan(?Scan $id_scan): static
    {
        $this->id_scan = $id_scan;

        return $this;
    }

    public function getLastChapterRead(): ?int
    {
        return $this->lastChapterRead;
    }

    public function setLastChapterRead(int $lastChapterRead): static
    {
        $this->lastChapterRead = $lastChapterRead;

        return $this;
    }

    public function getDateLastChapRead(): ?\DateTime
    {
        return $this->DateLastChapRead;
    }

    public function setDateLastChapRead(\DateTime $DateLastChapRead): static
    {
        $this->DateLastChapRead = $DateLastChapRead;

        return $this;
    }
}
