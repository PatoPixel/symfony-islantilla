<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Form\ClienteType;
use App\Form\ClienteActualizacionType;
use App\Repository\ClienteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/cliente', name: 'cliente_')]
class ClienteController extends AbstractController
{
    #[Route('/insertar', name: 'insertar')]
    public function index(EntityManagerInterface $GE, Request $request): Response
    {

        $cliente = new Cliente();

        $formulario = $this->createForm(ClienteType::class, $cliente);
        $formulario->handleRequest($request);

        if($formulario->isSubmitted() && $formulario->isValid())
        {
            $GE->persist($cliente);
            $GE->flush();
            return $this->redirectToRoute('cliente_mostrar');

        }else{
            return $this->render('cliente/index.html.twig', [
            'controller_name' => 'Inserción Cliente',
            'miform' => $formulario
        ]);
        }

        
    }
    #[Route('/mostrar', name: 'mostrar')]
    public function mostrar(ClienteRepository $CR): Response
    {
        // endpoint de ejemplo: http://127.0.0.1:8000/cliente/mostrar
        // Desde el gestor de entidades, saco el repositorio de mi clase
        $clientes =  $CR->findAll();
 
        $json = array();
        foreach ($clientes as $cliente) {
            $json[] = array(
                'DNI' => $cliente->getDNI(),
                'Nombre' => $cliente->getNombre(),
                'Edad' => $cliente->getEdad(),
            );
 
        }
        return $this->render('cliente/index.html.twig', [
            'controller_name' => 'ClienteController',
            'Tabla'=> $json,
        ]);
    }

    #[Route('/actualizar/{DNI}', name: 'actualizar')]
    public function actualizar($DNI, EntityManagerInterface $GE, Request $request):Response{

        $DatosCliente =  $GE->getRepository(Cliente::class)->findOneBy(['dni' => $DNI]);

        $cliente = new Cliente();
        $cliente->setDNI($DNI);
        $cliente->setNombre($DatosCliente->getNombre());
        $cliente->setEdad($DatosCliente->getEdad());

        $formulario = $this->createForm(ClienteActualizacionType::class, $cliente);
        $formulario->handleRequest($request);

        if($formulario->isSubmitted() && $formulario->isValid())
        {
            $datosFormulario = $formulario->getData();
            $DatosCliente->setNombre($datosFormulario->getNombre());
            $DatosCliente->setEdad($datosFormulario->getedad());
            $GE->flush();
            return $this->redirectToRoute('cliente_mostrar');

        }else{
            return $this->render('cliente/index.html.twig', [
            'controller_name' => 'Actualizar Cliente',
            'miform' => $formulario
        ]);
        }     
    }

    #[Route('/borrar/{DNI}', name: 'borrar')]
    public function borrar($DNI, EntityManagerInterface $GE):Response{
        $DatosCliente =  $GE->getRepository(Cliente::class)->findOneBy(['dni' => $DNI]);
        $GE->remove($DatosCliente);
        $GE->flush();
        return $this->redirectToRoute('cliente_mostrar');
    }
}
