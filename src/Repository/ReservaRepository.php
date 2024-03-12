<?php

namespace App\Repository;

use App\Entity\Reserva;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reserva>
 *
 * @method Reserva|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reserva|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reserva[]    findAll()
 * @method Reserva[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reserva::class);
    }

    //    /**
    //     * @return Reserva[] Returns an array of Reserva objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Reserva
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function ConsultaEdad(): array {
        return $this->createQueryBuilder("r")
        ->innerJoin("r.dni_cliente", "c") 
        ->innerJoin("r.numero_habitacion", "h")
        ->select("c.nombre", "c.edad", "h.camas", "h.precio", "r.fecha_reserva","r.fecha_llegada", "r.fecha_salida")
        ->orderBy("c.edad", "ASC")
        ->getQuery()
        ->getResult();
      }
    public function ConsultaTempVerano($año): array
    {
      $fechaInicio = new \DateTime($año . "-06-15");
      $fechaFin = new \DateTime($año . "-09-15");

    return $this->createQueryBuilder("r")
      ->innerJoin("r.dni_cliente", "c")
      ->innerJoin("r.numero_habitacion", "h")
      ->select("c.nombre", "c.edad", "h.camas", "h.precio", "r.fecha_reserva", "r.fecha_llegada", "r.fecha_salida")
      ->where("r.fecha_llegada >= :fechaInicio")
      ->andWhere("r.fecha_llegada <= :fechaFin")
      ->orderBy("c.edad", "ASC")
      ->setParameter("fechaInicio", $fechaInicio)
      ->setParameter("fechaFin", $fechaFin)
      ->getQuery()
      ->getResult();
    }

    public function ConsultaXDias($dias): array
    {
    return $this->createQueryBuilder("r")
      ->innerJoin("r.dni_cliente", "c")
      ->innerJoin("r.numero_habitacion", "h")
      ->select("c.nombre", "c.edad", "h.camas", "h.precio", "r.fecha_reserva", "r.fecha_llegada", "r.fecha_salida")
      ->where("r.fecha_salida - r.fecha_llegada >= :dias")
      ->orderBy("r.fecha_llegada")
      ->setParameter("dias", $dias)
      ->getQuery()
      ->getResult();
    }    
}
