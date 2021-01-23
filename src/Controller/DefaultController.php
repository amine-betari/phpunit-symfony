<?php


namespace App\Controller;

use App\Entity\Enclosure;
use App\Factory\DinosaurFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        $enclosures = $this->getDoctrine()
            ->getRepository(Enclosure::class)
            ->findAll();

        return $this->render('default/index.html.twig', [
            'enclosures' => $enclosures,
        ]);
        //  return new Response('OK', 200);
    }

    /**
     * @Route("/grow", name="grow_dinosaur")
     */
    public function growAction(Request $request, DinosaurFactory $dinosaurFactory)
    {
        $manager = $this->getDoctrine()->getManager();

        $enclosure = $manager->getRepository(Enclosure::class)
            ->find($request->request->get('enclosure'));

        $specification = $request->request->get('specification');
        $dinosaur = $dinosaurFactory->growFromSpecification($specification);

        $dinosaur->setEnclosure($enclosure);
        $enclosure->addDinosaur($dinosaur);

        $manager->flush();

        $this->addFlash('success', sprintf(
            'Grew a %s in enclosure #%d',
            mb_strtolower($specification),
            $enclosure->getId()
        ));

        return $this->redirectToRoute('homepage');
    }

}