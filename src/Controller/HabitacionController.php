<?php

namespace App\Controller;

use App\Entity\Habitacion;
use App\Form\HabitacionActualizacionType;
use App\Form\HabitacionType;
use App\Repository\HabitacionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/habitacion', name: 'habitacion_')]
class HabitacionController extends AbstractController
{
    #[Route('/insertar', name: 'insertar')]
    public function index(EntityManagerInterface $GE, Request $request): Response
    {

        $habitacion = new Habitacion();

        $formulario = $this->createForm(HabitacionType::class, $habitacion);
        $formulario->handleRequest($request);

        if($formulario->isSubmitted() && $formulario->isValid())
        {
            $GE->persist($habitacion);
            $GE->flush();
            return $this->redirectToRoute('habitacion_mostrar');

        }else{
            return $this->render('habitacion/index.html.twig', [
            'controller_name' => 'Inserción de habitación',
            'miform' => $formulario
        ]);
        }

        
    }
   #[Route('/mostrar', name: 'mostrar')]
    public function mostrar(HabitacionRepository $AR): Response
    {
        $habitaciones =  $AR->findAll();
 
        $json = array();
        foreach ($habitaciones as $habitacion) {
            $json[] = array(
                'Numero' => $habitacion->getNumero(),
                'Camas' => $habitacion->getCamas(),
                'Bano' => $habitacion->isBano(),
                'Precio' => $habitacion->getPrecio(),

            );
 
        }
        return $this->render('habitacion/index.html.twig', [
            'Tabla'=> $json,
        ]);
    }

     #[Route('/actualizar/{Numero}', name: 'actualizar')]
    public function actualizar($Numero, EntityManagerInterface $GE, Request $request):Response{

        $DatosHabitacion =  $GE->getRepository(Habitacion::class)->findOneBy(['numero' => $Numero]);

        $habitacion = new Habitacion();
        $habitacion->setNumero($Numero);
        $habitacion->setBano($DatosHabitacion->isBano());
        $habitacion->setCamas($DatosHabitacion->getCamas());
        $habitacion->setPrecio($DatosHabitacion->getPrecio());

        $formulario = $this->createForm(HabitacionActualizacionType::class, $habitacion);
        $formulario->handleRequest($request);

        if($formulario->isSubmitted() && $formulario->isValid())
        {
            $datosFormulario = $formulario->getData();
            $DatosHabitacion->setBano($datosFormulario->isBano());
            $DatosHabitacion->setPrecio($datosFormulario->getPrecio());
            $DatosHabitacion->setCamas($datosFormulario->getCamas());
            $GE->flush();
            return $this->redirectToRoute('habitacion_mostrar');

        }else{
            return $this->render('habitacion/index.html.twig', [
            'controller_name' => 'Actualización de habitación',
            'miform' => $formulario
        ]);
        }     
    }

    #[Route('/borrar/{Numero}', name: 'borrar')]
    public function borrar($Numero, EntityManagerInterface $GE):Response{
        $DatosHabitacion =  $GE->getRepository(Habitacion::class)->findOneBy(['numero' => $Numero]);
        $GE->remove($DatosHabitacion);
        $GE->flush();
        return $this->redirectToRoute('habitacion_mostrar');
    }
}
