<?php

namespace App\Entity;

use App\Repository\ReservaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservaRepository::class)]
class Reserva
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $FechaReserva = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $FechaEntrada = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $FechaSalida = null;

    #[ORM\Column]
    private ?bool $Pagado = null;

    #[ORM\ManyToOne(inversedBy: 'ID_reserva')]
    #[ORM\JoinColumn(nullable: false, name:"DNI_huesped", referencedColumnName:"DNI")]
    private ?Cliente $DNI_huesped = null;

    #[ORM\ManyToOne(inversedBy: 'ID_reserva')]
    #[ORM\JoinColumn(nullable: false, name:"NumeroHabitacion", referencedColumnName:"Numero")]
    private ?Habitacion $NumeroHabitacion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaReserva(): ?\DateTimeInterface
    {
        return $this->FechaReserva;
    }

    public function setFechaReserva(\DateTimeInterface $FechaReserva): static
    {
        $this->FechaReserva = $FechaReserva;

        return $this;
    }

    public function getFechaEntrada(): ?\DateTimeInterface
    {
        return $this->FechaEntrada;
    }

    public function setFechaEntrada(\DateTimeInterface $FechaEntrada): static
    {
        $this->FechaEntrada = $FechaEntrada;

        return $this;
    }

    public function getFechaSalida(): ?\DateTimeInterface
    {
        return $this->FechaSalida;
    }

    public function setFechaSalida(\DateTimeInterface $FechaSalida): static
    {
        $this->FechaSalida = $FechaSalida;

        return $this;
    }

    public function isPagado(): ?bool
    {
        return $this->Pagado;
    }

    public function setPagado(bool $Pagado): static
    {
        $this->Pagado = $Pagado;

        return $this;
    }

    public function getDNIHuesped(): ?Cliente
    {
        return $this->DNI_huesped;
    }

    public function setDNIHuesped(?Cliente $DNI_huesped): static
    {
        $this->DNI_huesped = $DNI_huesped;

        return $this;
    }

    public function getNumeroHabitacion(): ?Habitacion
    {
        return $this->NumeroHabitacion;
    }

    public function setNumeroHabitacion(?Habitacion $NumeroHabitacion): static
    {
        $this->NumeroHabitacion = $NumeroHabitacion;

        return $this;
    }
}
