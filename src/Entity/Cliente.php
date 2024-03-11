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
    private ?string $dni = null;

    #[ORM\Column(length: 40)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $edad = null;

    #[ORM\OneToMany(targetEntity: Reserva::class, mappedBy: 'dni_cliente')]
    private Collection $reservas;

    public function __construct()
    {
        $this->reservas = new ArrayCollection();
    }

    public function getdni(): ?string
    {
        return $this->dni;
    }

    public function setdni(string $dni): static
    {
        $this->dni = $dni;

        return $this;
    }

    public function getnombre(): ?string
    {
        return $this->nombre;
    }

    public function setnombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getedad(): ?int
    {
        return $this->edad;
    }

    public function setedad(int $edad): static
    {
        $this->edad = $edad;

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
            $reserva->setDniCliente($this);
        }

        return $this;
    }

    public function removeReserva(Reserva $reserva): static
    {
        if ($this->reservas->removeElement($reserva)) {
            // set the owning side to null (unless already changed)
            if ($reserva->getDniCliente() === $this) {
                $reserva->setDniCliente(null);
            }
        }

        return $this;
    }
}
