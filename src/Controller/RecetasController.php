<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Receta;
use App\Form\RecetaFormType;
use Symfony\Component\HttpFoundation\Request;

class RecetasController extends AbstractController
{
    #[Route('/', name: 'app-recetas')]
    public function index(): Response
    {
        return $this->render('recetas/index.html.twig');
    }   

    #[Route("/insert/receta")]
    public function insertarReceta(EntityManagerInterface $doctrine)
        {
          $guisoCarrero = new Receta();
          $guisoCarrero ->setTitulo(titulo:"Guiso Carrero");
          $guisoCarrero ->setPais(pais:"Argentina");
          $guisoCarrero ->setIngredientes(ingredientes:"500 gramos de carne vacuna, 1 cebolla, 1 pimiento rojo o verde, 1 diente de ajo, 1 diente de ajo,  1 zanahoria, 1 papa, 1 batata, 500 gramos de calabaza, 1 choclo, ½ vaso de vino, caldo de verdura c/n, sal, laurel, pimentón, pimienta, ají molido a gusto");
          $guisoCarrero ->setElaboracion(elaboracion:"1. Inicia la preparación del guiso de carne argentino pelando y picando el ajo y la cebolla.
          2. También lava el pimiento, córtalo al medio, quita el cabo, las nervaduras y semillas, corta en pequeños cubos. Reserva.
          3. Posteriormente pela y corta la zanahoria en rueditas, reserva.
          4. Limpia la carne que hayas elegido, retirando el exceso de grasa. Corta en cubos y reserva. Truco: las carnes más apropiadas para los guisos argentinos son aquellas que tienen un poco de grasa y fibra intramuscular, como paleta, aguja o roast beef, carnaza, tortuguita, palomita, etc.
          5. Enciende la hornalla y pon a calentar la olla. Cuando tome temperatura, vierte 1 cucharada de aceite y echa la carne para sellarla a fuego fuerte. Truco: dado que los guisos requieren una cocción larga, es recomendable utilizar ollas de barro, de hierro o de fondo grueso.
          6. Cuando la carne esté ligeramente dorada, retírala y reserva. Ahora, vierte otra cucharada sopera de aceite y dora la cebolla, el pimiento y el ajo.
          7.Vierte el vino para levantar el fondo de cocción y una vez que evapore el alcohol, vuelve a añadir la carne. Agrega las zanahorias, el tomate cubeteado junto con su jugo y la cantidad de caldo necesario para cubrir los ingredientes. Condimenta con sal, pimienta, pimentón, ají molido y 1 hoja de laurel. Cuando rompa hervor, baja el fuego al mínimo, tapa y deja cocinar 45 / 50 minutos, revolviendo cada tanto para vigilar que no se pegue. Si notas que le falta líquido, agrega más caldo.
          8. Mientras tanto, pela y corta la calabaza, la batata y la papa en cubos y el choclo en rodajas.
          9.Transcurrido el tiempo indicado, incorpora la calabaza, la batata, la papa y el choclo. Chequea si es necesario agregar más caldo y continúa cocinando hasta que estos últimos ingredientes estén hechos y el guiso espese un poco.
          10. El guiso carrero ya está listo. ¡Vamos a comer!");

          $doctrine->persist($guisoCarrero);
          $doctrine->flush();
        }

        #[Route("/new/receta", name:"subir-receta")] 
    public function newReceta(EntityManagerInterface $doctrine, Request $request) {
         $form = $this->createForm(RecetaFormType::class);

         $form->handleRequest($request);

         if ($form->isSubmitted() && $form->isValid()) {
            $receta = $form->getData();
            $doctrine->persist($receta);
            $doctrine->flush();
         }

         return $this->render('receta/crearReceta.html.twig', ['recetaForm' => $form->createView()]);
    }

    #[Route("/listado/receta", name:"listado-recetas")]
    public function listRecetas(EntityManagerInterface $doctrine) {
         $repo = $doctrine->getRepository(Receta::class);
         $recetas = $repo->findAll();

         return $this->render('receta/listado.html.twig',["recetas" => $recetas]);
    }

    #[Route("/contacto", name:"contacto-recetas")]
    public function contact(): Response
    {
        return $this->render('contacto/contacto.html.twig');
    }  
}