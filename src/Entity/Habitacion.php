<?php

namespace App\Entity;

use App\Repository\HabitacionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HabitacionRepository::class)]
class Habitacion
{
    #[ORM\Id]
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $Numero = null;
    #[ORM\Column]
    private ?int $Precio = null;

    #[ORM\Column]
    private ?bool $Baño = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $Camas = null;

    #[ORM\OneToMany(targetEntity: Reserva::class, mappedBy: 'NumeroHabitacion')]
    private Collection $ID_reserva;

    public function __construct()
    {
        $this->ID_reserva = new ArrayCollection();
    }

    public function getPrecio(): ?int
    {
        return $this->Precio;
    }

    public function setPrecio(int $Precio): static
    {
        $this->Precio = $Precio;

        return $this;
    }

    public function isBaño(): ?bool
    {
        return $this->Baño;
    }

    public function setBaño(bool $Baño): static
    {
        $this->Baño = $Baño;

        return $this;
    }

    public function getCamas(): ?int
    {
        return $this->Camas;
    }

    public function setCamas(int $Camas): static
    {
        $this->Camas = $Camas;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->Numero;
    }

    public function setNumero(int $Numero): static
    {
        $this->Numero = $Numero;

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
            $iDReserva->setNumeroHabitacion($this);
        }

        return $this;
    }

    public function removeIDReserva(Reserva $iDReserva): static
    {
        if ($this->ID_reserva->removeElement($iDReserva)) {
            // set the owning side to null (unless already changed)
            if ($iDReserva->getNumeroHabitacion() === $this) {
                $iDReserva->setNumeroHabitacion(null);
            }
        }

        return $this;
    }
}
