<?php

namespace App\Controller;

use App\Entity\Reserva;
use App\Entity\Habitacion;
use App\Entity\Cliente;
use App\Form\ActualizacionReservaType;
use App\Form\ReservaType;
use App\Repository\ClienteRepository;
use App\Repository\HabitacionRepository;
use App\Repository\ReservaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/reserva', name: 'reserva_')]
class ReservaController extends AbstractController
{
    #[Route('/insertar', name: 'insertar')]
    public function index(EntityManagerInterface $GE, Request $request): Response
    {

        $reserva = new Reserva();
        $formulario = $this->createForm(ReservaType::class, $reserva);
        $formulario->handleRequest($request);
        if($formulario->isSubmitted() && $formulario->isValid())
        {
            $GE->persist($reserva);
            $GE->flush();
            return $this->redirectToRoute('reserva_mostrar');

        }else{
            return $this->render('reserva/index.html.twig', [
            'controller_name' => 'Inserción de nueva reserva',
            'miform' => $formulario
        ]);
        }

        
    }
   #[Route('/mostrar', name: 'mostrar')]
    public function mostrar(ReservaRepository $RR): Response
    {
        // endpoint de ejemplo: http://127.0.0.1:8000/cliente/mostrar
        // Desde el gestor de entidades, saco el repositorio de mi clase
        $reservas =  $RR->findAll();
 
        $json = array();
        foreach ($reservas as $reserva) {
            $json[] = array(
                'Numero' => $reserva->getNumeroHabitacion()->getnumero(),
                'Cliente' => $reserva->getDniCliente()->getdni(),
                'FechaReserva' => $reserva->getFechaReserva(),
                'FechaLlegada' => $reserva->getFechaLlegada(),
                'FechaSalida' => $reserva->getFechaSalida(),
                'ID'=> $reserva->getId(),

            );
 
        }
        return $this->render('reserva/index.html.twig', [
            'Tabla'=> $json,
        ]);
    }

    #[Route('/actualizar/{id}', name: 'actualizar')]
    public function actualizar($id, EntityManagerInterface $GE, Request $request):Response{

        $DatosReserva =  $GE->getRepository(Reserva::class)->find($id);
    
        $reserva = new Reserva();
        
        $reserva->setNumeroHabitacion($DatosReserva->getNumeroHabitacion());
        $reserva->setDniCliente($DatosReserva->getDniCliente());
        $reserva->setFechaReserva($DatosReserva->getFechaReserva());
        $reserva->setFechaLlegada($DatosReserva->getFechaLlegada());
        $reserva->setFechaSalida($DatosReserva->getFechaSalida());
    
        $formulario = $this->createForm(ActualizacionReservaType::class, $reserva);
        $formulario->handleRequest($request);
    
        if($formulario->isSubmitted() && $formulario->isValid())
        {
            $datosFormulario = $formulario->getData();
            
            $repoHabitacion = $GE->getRepository(Habitacion::class);
            $numeroHabitacion = $datosFormulario->getNumeroHabitacion();
            $habitacion = $repoHabitacion->findOneBy(['numero' => $numeroHabitacion]);
            $DatosReserva->setNumeroHabitacion($habitacion);
            
            $repoCliente = $GE->getRepository(Cliente::class);
            $DNICliente = $datosFormulario->getDniCliente();
            $Cliente = $repoCliente->findOneBy(['dni' => $DNICliente]);
            $DatosReserva->setDniCliente($Cliente);

            $DatosReserva->setFechaReserva($datosFormulario->getFechaReserva());
            $DatosReserva->setFechaLlegada($datosFormulario->getFechaLlegada());
            $DatosReserva->setFechaSalida($datosFormulario->getFechaSalida());
            $GE->flush();
            return $this->redirectToRoute('reserva_mostrar');
    
        }else{
            return $this->render('reserva/index.html.twig', [
            'controller_name' => 'Actualización de reseva',
            'miform' => $formulario
        ]);
        }     
    }

     #[Route('/borrar/{id}', name: 'borrar')]
    public function borrar($id, EntityManagerInterface $GE):Response{
        $DatosReserva =  $GE->getRepository(Reserva::class)->find($id);
        $GE->remove($DatosReserva);
        $GE->flush();
        return $this->redirectToRoute('reserva_mostrar');
    }
}
