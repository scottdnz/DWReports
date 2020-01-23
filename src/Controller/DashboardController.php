<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\MClient;

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
            []
        );
    }

    /**
     * Returns JSON
     * @Route("/dashboard/graph", name="graph")
     */
    public function graph(Request $request, MClient $client) {
        $status = "ok";

        $from = $request->query->get("date_from");
        $to = $request->query->get("date_to");
        $daysOnVRFISelected = $request->query->get("daysOnVRFISelected");

        $mapping = [
            '1|All' => 'Days on VRFI for Applications',
            "1|10" => "Applications On VRFI On Day 10 Or Less",
            '11|15' => "Applications On VRFI Between 11 And 15 Days",
            '16|20' => "Applications On VRFI Between 16 And 20 Days",
            '21|All' => "Applications On VRFI On Day 21 Or More"
        ];

        $graphTitle = null;
        if (array_key_exists($daysOnVRFISelected, $mapping)) {
            $graphTitle = $mapping[$daysOnVRFISelected];
        }

//        $client = new MClient();
        $res = $client->findGraphResultsInDateRange("results",
            $from,
            $to,
            $graphTitle);

        return new JsonResponse(
            [
                "status" => $status,
                "res" => json_encode($res),
                "graphTitle" => $graphTitle
            ]
        // JsonResponse::HTTP_CREATED
        );;
    }

    /**
    * Returns JSON
    * @Route("/dashboard/table", name="table")
    */
    public function table(Request $request, MClient $client)
    {
        $status = "ok";

        $from = $request->query->get("date_from");
        $to = $request->query->get("date_to");

//        $client = new MClient();
        $res = $client->findTabularResultsInDateRange("results",
            $from,
            $to);

        return new JsonResponse(
            [
                "status" => $status,
                "res" => json_encode($res),
                "from" => $from,
                "to" => $to
            ]
        );
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
