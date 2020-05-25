<?php

namespace App\Controller;

use App\Entity\ExchangeRates;
use App\Repository\ExchangeRatesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExchangeRatesController extends AbstractController
{

    /**
     * @Route("/exchange/rates", name="exchange_rates" )
     */
    public function index()
    {
        $exchangeRates = $this->getDoctrine()->getRepository(ExchangeRates::class);
        die(var_dump($exchangeRates->find(1)));
        return new JsonResponse($data, Response::HTTP_OK);
        return $this->render('exchange_rates/index.html.twig', [
            'controller_name' => 'ExchangeRatesController',
        ]);
    }
}
