<?php
namespace App\LibMongo;

require_once __DIR__ . "/../../vendor/autoload.php";

class Helpers
{
    public static function createTestData()
    {
        $client = new MClient();

        $client->clearCollection();

        $fNames = [
            "month_Feb_2019.json",
            "month_Nov_2019.json",
            "month_Dec_2019.json",
            "month_Jan_2020.json",
            "vrfi_all_2019.json",
            "vrfi_graph.json"
        ];
        $initialTestRecords = [];
        $i = 0;
        foreach ($fNames as $fName) {
            $string = file_get_contents(__DIR__ . "/../data/" . $fName);
            $jsonArr = json_decode($string, true);

//            if ($i > 3) {
//                var_dump($jsonArr);
//            }
            //    var_dump($jsonArr);

            $client->insertOne("results", $jsonArr);
            $initialTestRecords[] = $jsonArr;
            $i++;
        }

//        $numRecordsInserted = $client->insertMany("results", $initialTestRecords);
//        echo $numRecordsInserted . PHP_EOL;
        unset($client);
    }


}

//Helpers::test();
