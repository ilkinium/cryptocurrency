<?php

namespace App\Controller;

use App\Entity\ExchangeRates;
use App\Repository\ExchangeRatesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExchangeRatesController extends AbstractController
{

    /**
     * @Route("/api/rates/{from?}/{to?}", name="api_rates" )
     * @param  Request  $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        // use this to get all the available attributes (not only routing ones):
        $allAttributes = $request->attributes->all();
        $from = $request->attributes->get('from');
        $to = $request->attributes->get('from');
        if ( $from || $to ) {
            $exchangeRates = $this->getDoctrine()->getRepository(ExchangeRates::class)->findByDateRange(
                $from,
                $to
            );
        } else {
            $exchangeRates = $this->getDoctrine()->getRepository(ExchangeRates::class)->findAll();
        }

        $newData = $this->groupBy("datetime", $exchangeRates);

        return $this->json($newData, Response::HTTP_OK);

    }

    /**
     * Function that groups an array of associative arrays by some key.
     *
     * @param  string  $key
     * @param  array  $exchangeRates
     * @return array
     */
    private function groupBy(string $key = 'datetime', array $exchangeRates = []): array {
        $result = array();
        $data = [];

        foreach ($exchangeRates as $exchangeRate) {
            $data[] = [
                'id' => $exchangeRate->getId(),
                'code' => $exchangeRate->getCode(),
                'value' => $exchangeRate->getValue(),
                'datetime' => (string)$exchangeRate->getDateTime()->format('Y-m-d H:i:s'),
            ];
        }

        foreach($data as $val) {
            if(array_key_exists($key, $val)){
                $result[$val[$key]][] = $val;
            }else{
                $result[""][] = $val;
            }
        }

        return $result;
    }
}
