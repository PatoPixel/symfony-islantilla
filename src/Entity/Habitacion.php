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
    private ?int $numero = null;
    #[ORM\Column]
    private ?int $precio = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $camas = null;

    #[ORM\Column]
    private ?bool $bano = null;

    #[ORM\OneToMany(targetEntity: Reserva::class, mappedBy: 'numero_habitacion')]
    private Collection $reservas;

    public function __construct()
    {
        $this->reservas = new ArrayCollection();
    }
    public function getprecio(): ?int
    {
        return $this->precio;
    }

    public function setprecio(int $precio): static
    {
        $this->precio = $precio;

        return $this;
    }

    public function getcamas(): ?int
    {
        return $this->camas;
    }

    public function setcamas(int $camas): static
    {
        $this->camas = $camas;

        return $this;
    }

    public function getnumero(): ?int
    {
        return $this->numero;
    }

    public function setnumero(int $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function isbano(): ?bool
    {
        return $this->bano;
    }

    public function setbano(bool $bano): static
    {
        $this->bano = $bano;

        return $this;
    }

    /**
     * @return Collection<int, Reserva>
     */
    public function getReservas(): Collection
    {
        return $this->reservas;
    }

    public function addReserva(Reserva $reserva): static
    {
        if (!$this->reservas->contains($reserva)) {
            $this->reservas->add($reserva);
            $reserva->setNumeroHabitacion($this);
        }

        return $this;
    }

    public function removeReserva(Reserva $reserva): static
    {
        if ($this->reservas->removeElement($reserva)) {
            // set the owning side to null (unless already changed)
            if ($reserva->getNumeroHabitacion() === $this) {
                $reserva->setNumeroHabitacion(null);
            }
        }

        return $this;
    }

}
