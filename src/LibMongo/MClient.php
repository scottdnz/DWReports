<?php
namespace App\LibMongo;

require_once __DIR__ . "/../../vendor/autoload.php";

class MClient
{
    private $client;

    public function __construct()
    {
//        if (is_null($this->client)) {
            $this->client = new \MongoDB\Client("mongodb://localhost:27017");
//        }
    }

    public function clearCollection($collectionName="results") {
        if ($collectionName === "results") {
            $collection = $this->client->dwreports->results;
        }
//        if( $collection->countDocuments() > 0) {
            $collection->drop();
//        }
    }

    public function insertMany($collectionName="results", $records=null) {
        $resultCount = 0;
        if ($collectionName === "results") {
            $collection = $this->client->dwreports->results;
        }

        if (! empty($records)) {
            $result = $collection->insertMany($records);
            $resultCount = $result->getInsertedCount();
        }
        return $resultCount;
    }

    public function insertOne($collectionName="results", $record=null) {
        if ($collectionName === "results") {
            $collection = $this->client->dwreports->results;
        }

        if (! empty($record)) {
            $result = $collection->insertOne($record);
//            var_dump($result);
        }
    }

    //        "from": "2019-11-01 00:00:00",
    //        "to": "2019-11-30 23:59:59"
    public function findResultsInDateRange($collectionName="results", $dateFrom, $dateTo) {
        if ($collectionName === "results") {
            $collection = $this->client->dwreports->results;
        }
        $filters = [
            'from' => $dateFrom,
            'to' => $dateTo
        ];
        $result = $collection->findOne($filters);
        return $result;
    }

    //"from": "2019-02-01 00:00:00",
    //"to": "2020-01-31 23:59:59",
    public function findGraphResultsInDateRange($collectionName="results", $dateFrom, $dateTo) {
//        if ($collectionName === "results") {
            $collection = $this->client->dwreports->results;
//        }
        $filters = [
            'data_type' => "graph",
            'from' => $dateFrom,
            'to' => $dateTo
        ];

        $result = $collection->findOne($filters);

        $periods = [];
        foreach ($result["attributes"]["tooltipValueLookups"] as $period) {
            $periods[] = [
                "period" => $period["period"],
                "value" => $period["value"]
            ];
        }

        $doc = [
            "title" => $result["attributes"]["title"],
            "the_number" => $result["the_number"],
            "periods" => $periods
        ];

        return $doc;
    }

}




