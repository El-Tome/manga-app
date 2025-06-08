<?php

namespace App\Entity;

use App\Repository\ScanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScanRepository::class)]
class Scan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $chapter = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $language = null;

    /**
     * @var Collection<int, ScanRead>
     */
    #[ORM\OneToMany(targetEntity: ScanRead::class, mappedBy: 'id_scan', orphanRemoval: true)]
    private Collection $scanReads;

    public function __construct()
    {
        $this->scanReads = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getChapter(): ?int
    {
        return $this->chapter;
    }

    public function setChapter(?int $chapter): static
    {
        $this->chapter = $chapter;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): static
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return Collection<int, ScanRead>
     */
    public function getScanReads(): Collection
    {
        return $this->scanReads;
    }

    public function addScanRead(ScanRead $scanRead): static
    {
        if (!$this->scanReads->contains($scanRead)) {
            $this->scanReads->add($scanRead);
            $scanRead->setIdScan($this);
        }

        return $this;
    }

    public function removeScanRead(ScanRead $scanRead): static
    {
        if ($this->scanReads->removeElement($scanRead)) {
            // set the owning side to null (unless already changed)
            if ($scanRead->getIdScan() === $this) {
                $scanRead->setIdScan(null);
            }
        }

        return $this;
    }
}
