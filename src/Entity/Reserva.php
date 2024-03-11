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
    private ?\DateTimeInterface $fecha_reserva = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_llegada = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_salida = null;

    #[ORM\ManyToOne(inversedBy: 'reservas')]
    #[ORM\JoinColumn(name:"dni_cliente", referencedColumnName:"dni", nullable: false)]
    private ?Cliente $dni_cliente = null;

    #[ORM\ManyToOne(inversedBy: 'reservas')]
    #[ORM\JoinColumn(name:"numero_habitacion", referencedColumnName:"numero", nullable: false)]
    private ?Habitacion $numero_habitacion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaReserva(): ?\DateTimeInterface
    {
        return $this->fecha_reserva;
    }

    public function setFechaReserva(\DateTimeInterface $fecha_reserva): static
    {
        $this->fecha_reserva = $fecha_reserva;

        return $this;
    }

    public function getFechaLlegada(): ?\DateTimeInterface
    {
        return $this->fecha_llegada;
    }

    public function setFechaLlegada(\DateTimeInterface $fecha_llegada): static
    {
        $this->fecha_llegada = $fecha_llegada;

        return $this;
    }

    public function getFechaSalida(): ?\DateTimeInterface
    {
        return $this->fecha_salida;
    }

    public function setFechaSalida(\DateTimeInterface $fecha_salida): static
    {
        $this->fecha_salida = $fecha_salida;

        return $this;
    }

    public function getDniCliente(): ?Cliente
    {
        return $this->dni_cliente;
    }

    public function setDniCliente(?Cliente $dni_cliente): static
    {
        $this->dni_cliente = $dni_cliente;

        return $this;
    }

    public function getNumeroHabitacion(): ?Habitacion
    {
        return $this->numero_habitacion;
    }

    public function setNumeroHabitacion(?Habitacion $numero_habitacion): static
    {
        $this->numero_habitacion = $numero_habitacion;

        return $this;
    }
}
