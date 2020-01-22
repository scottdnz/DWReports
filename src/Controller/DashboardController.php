<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\LibMongo\MClient;

class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="default")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function default() {
        return $this->render("index.html.twig", [] );
    }

    /**
     * Returns HTML template
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard()
    {
        return $this->render("dashboard/dashboard.html.twig",
            [
                "test" => "test message"
            ]
        );
    }

    /**
     * Returns JSON
     * @Route("/dashboard/graph", name="graph")
     */
    public function graph(Request $request) {
        $status = "ok";

        $from = $request->query->get("date_from");
        $to = $request->query->get("date_to");
//        $data = json_decode(
//            $request->getContent(),
//            true
//        );

        $client = new MClient();
        $res = $client->findGraphResultsInDateRange("results",
            $from,
            $to);

        return new JsonResponse(
            [
                "status" => $status,
                "res" => json_encode($res)

            ]
        // JsonResponse::HTTP_CREATED
        );;
    }

    /**
     * Returns HTML template
     * @Route("/dashboard_test", name="dashboard_test")
     */
    public function dashboardTest()
    {
        return $this->render("dashboard/dashboard_test.html.twig",
            [
                "test" => "test message"
            ]
        );
    }
}