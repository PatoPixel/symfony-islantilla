<?php

namespace App\Controller;

use App\Repository\HabitacionRepository;
use App\Repository\ReservaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType as TypeIntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\Range;

use function PHPUnit\Framework\returnSelf;

#[Route('/consultas', name: 'consultas_')]
class ConsultasController extends AbstractController
{

    /* -------------------------------------------------------------------------------- */


                        /* CONSULTA POR EDAD */


    /* -------------------------------------------------------------------------------- */    
    
    #[Route('/edad', name: 'edad')]
    public function edad(ReservaRepository $RR): Response
    {
            $consultas = $RR->ConsultaEdad();
                    $json = array();
                    foreach ($consultas as $consulta) {
                        $json[] = array(
                            'Nombre' => $consulta["nombre"],
                            'Edad' => $consulta["edad"],
                            'Camas' => $consulta["camas"],
                            'Precio' => $consulta["precio"],
                            'FechaReserva' => $consulta["fecha_reserva"],
                            'FechaLlegada' => $consulta["fecha_llegada"],
                            'FechaSalida' => $consulta["fecha_salida"],
                        );}     

        return $this->render('consultas/index.html.twig', [
            'nombre_tabla' => 'Consulta por edad',
            'Consulta_Edad' => $json
        ]);
    }

    /* -------------------------------------------------------------------------------- */


                        /* CONSULTA TEMPORADA DE VERANO */


    /* -------------------------------------------------------------------------------- */


    #[Route('/verano', name: 'verano')]
    public function verano(ReservaRepository $RR, Request $request): Response
    {
        $Formulario = $this->createFormBuilder()
        ->add('ano', TypeIntegerType::class, [
            'constraints' => [
                new Range(['min' => 2000, 'max' => 2024])],
            'label'=>'Año', 
            'label_attr'=>['class' =>'fw-bolder']])

        ->add('guardar', SubmitType::class,
                ["label"=> "Buscar", 'attr' => ['class' => 'btn btn-primary']])
        
                ->getForm();
        $Formulario->handleRequest($request);

        if($Formulario->isSubmitted() && $Formulario->isValid()){
            $año = $Formulario->get('ano')->getData();
            $consultas = $RR->ConsultaTempVerano($año);
                    $json = array();
                    foreach ($consultas as $consulta) {
                        $json[] = array(
                            'Nombre' => $consulta["nombre"],
                            'Edad' => $consulta["edad"],
                            'Camas' => $consulta["camas"],
                            'Precio' => $consulta["precio"],
                            'FechaLlegada' => $consulta["fecha_llegada"]->format('Y-m-d'),
                            'FechaSalida' => $consulta["fecha_salida"]->format('Y-m-d'),
                        );}     
        return $this->redirectToRoute('consultas_mostrar', ['año' => $año, 'json' => $json, ]);
        }else{
        return $this->render('consultas/index.html.twig', [
            'form' => $Formulario,
            'nombre_tabla' => 'Consulta por edad',
        ]);
    }
    }

    #[Route('/mostrar/{año}', name: 'mostrar')]    
    public function mostrarResultados(Request $request): Response
    {
        $consultas = $request->get('json');
        $año = $request->get('año');

    return $this->render('consultas/index.html.twig', [
        'nombre_tabla' => 'Consulta temporada de verano año: ' . $año,
        'Consulta_Verano' => $consultas,
        ]);
    }

    /* -------------------------------------------------------------------------------- */


                        /* CONSULTA SI HAY BAÑO O NO */


    /* -------------------------------------------------------------------------------- */

    #[Route('/baño', name: 'baño')] 
    public function baño(HabitacionRepository $HR): Response
    {
        $habitaciones =  $HR->ConsultaBaño();
 
        $json = array();
        foreach ($habitaciones as $habitacion) {
            $json[] = array(
                'Numero' => $habitacion["numero"],
                'Camas' => $habitacion["camas"],
                'Bano' => $habitacion["bano"],
                'Precio' => $habitacion["precio"],

            );
 
        }
        return $this->render('consultas/index.html.twig', [
            'nombre_tabla' => 'Consulta si tiene baño o no',
            'Consulta_Baño'=> $json,
        ]);
    
    }

    #[Route('/mostrarJsonBaño', name: 'mostrarJSONBaño')]
    public function mostrarResultadosBañoJSON(HabitacionRepository $HR): JsonResponse
    {  
        $habitaciones =  $HR->ConsultaBaño();
 
        $json = array();
        foreach ($habitaciones as $habitacion) {
            $json[] = array(
                'Numero' => $habitacion["numero"],
                'Camas' => $habitacion["camas"],
                'Bano' => $habitacion["bano"],
                'Precio' => $habitacion["precio"],

            );
       }    
       return new JsonResponse($json); 
    }
    /* -------------------------------------------------------------------------------- */


                        /* CONSULTA POR DIAS DE ESTANCIA */


    /* -------------------------------------------------------------------------------- */

    #[Route('/dias', name: 'dias')]
    public function dias(ReservaRepository $RR, Request $request): Response
    {
        $Formulario = $this->createFormBuilder()
        ->add('dias', TypeIntegerType::class, [
            'constraints' => [
                new Range(['min' => 1])],
            'label'=>'Dias', 
            'label_attr'=>['class' =>'fw-bolder']])

        ->add('guardar', SubmitType::class,
                ["label"=> "Buscar", 'attr' => ['class' => 'btn btn-primary']])
                ->getForm();
        $Formulario->handleRequest($request);

        
        if($Formulario->isSubmitted() && $Formulario->isValid()){
            $dias = $Formulario->get('dias')->getData();
            $consultas = $RR->ConsultaXDias($dias);
                    $json = array();
                    foreach ($consultas as $consulta) {
                        $json[] = array(
                            'Nombre' => $consulta["nombre"],
                            'Edad' => $consulta["edad"],
                            'Camas' => $consulta["camas"],
                            'Precio' => $consulta["precio"],
                            'FechaLlegada' => $consulta["fecha_llegada"]->format('Y-m-d'),
                            'FechaSalida' => $consulta["fecha_salida"]->format('Y-m-d'),
                        );}
            return $this->redirectToRoute('consultas_mostrar2', ['dias' => $dias, 'json' => $json]);
            }else{
        return $this->render('consultas/index.html.twig', [
            'nombre_tabla' => 'Consulta por edad',
            'form2' => $Formulario
        ]);
    }
    }

    #[Route('/mostrar2', name: 'mostrar2')]    
    public function mostrarResultadosDias(Request $request): Response
    {
        $consultas = $request->get('json');
        $dias = $request->get('dias');
    return $this->render('consultas/index.html.twig', [
        'nombre_tabla' => 'Consulta reservas de más de: ' . $dias . " días",
        'Consulta_Dias' => $consultas,
        'dias' => $dias
        ]);
        }

    #[Route('/mostrarJsonDias/{dias}', name: 'mostrarJSON')]
    public function mostrarResultadosDiasJSON(ReservaRepository $RR, $dias): JsonResponse
    {  
        $consultas = $RR->ConsultaXDias($dias);
                    $json = array();
                    foreach ($consultas as $consulta) {
                        $json[] = array(
                            'Nombre' => $consulta["nombre"],
                            'Edad' => $consulta["edad"],
                            'Camas' => $consulta["camas"],
                            'Precio' => $consulta["precio"],
                            'Fechas:' => array(
                            'FechaLlegada' => $consulta["fecha_llegada"]->format('Y-m-d'),
                            'FechaSalida' => $consulta["fecha_salida"]->format('Y-m-d'),)
                        );}

        return new JsonResponse($json);
    }


}