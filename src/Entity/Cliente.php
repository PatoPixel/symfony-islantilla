<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClienteRepository::class)]
class Cliente
{
    #[ORM\Id]
    #[ORM\Column(length: 9)]
    private ?string $DNI = null;

    #[ORM\Column(length: 40)]
    private ?string $Nombre = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $Edad = null;

    #[ORM\OneToMany(targetEntity: Reserva::class, mappedBy: 'DNI_huesped')]
    private Collection $ID_reserva;

    public function __construct()
    {
        $this->ID_reserva = new ArrayCollection();
    }

    public function getDNI(): ?string
    {
        return $this->DNI;
    }

    public function setDNI(string $DNI): static
    {
        $this->DNI = $DNI;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): static
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    public function getEdad(): ?int
    {
        return $this->Edad;
    }

    public function setEdad(int $Edad): static
    {
        $this->Edad = $Edad;

        return $this;
    }

    /**
     * @return Collection<int, Reserva>
     */
    public function getIDReserva(): Collection
    {
        return $this->ID_reserva;
    }

    public function addIDReserva(Reserva $iDReserva): static
    {
        if (!$this->ID_reserva->contains($iDReserva)) {
            $this->ID_reserva->add($iDReserva);
            $iDReserva->setDNIHuesped($this);
        }

        return $this;
    }

    public function removeIDReserva(Reserva $iDReserva): static
    {
        if ($this->ID_reserva->removeElement($iDReserva)) {
            // set the owning side to null (unless already changed)
            if ($iDReserva->getDNIHuesped() === $this) {
                $iDReserva->setDNIHuesped(null);
            }
        }

        return $this;
    }
}
