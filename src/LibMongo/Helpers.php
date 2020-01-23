<?php
namespace App\LibMongo;

require_once __DIR__ . "/../../vendor/autoload.php";

class Helpers
{
    public static function createTestData()
    {
        $client = new MClient();

        $client->clearCollection();

        // Graph data
        $fNames = [
            "vrfi_1_10_days.json",
            "vrfi_11_15_days.json",
            "vrfi_16_20_days.json",
            "vrfi_21plus_days.json",
            "vrfi_all.json"
        ];

        $paths = [
            __DIR__ . "/../data/vrfi_last_year/",
            __DIR__ . "/../data/vrfi_2020/",
        ];

        $initialTestRecords = [];
        foreach ($paths as $path) {
            foreach ($fNames as $fName) {
                $string = file_get_contents($path . $fName);
                $jsonArr = json_decode($string, true);

                $client->insertOne("results", $jsonArr);
                $initialTestRecords[] = $jsonArr;
            }
        }

        // Tabular data
        $fNames = ["month_Feb_2019.json",
            "month_Feb_2019.json",
            "month_Nov_2019.json",
            "month_Dec_2019.json",
            "month_Jan_2020.json",
            "vrfi_all_2019.json"
        ];
        $path = __DIR__ . "/../data/tbl_vrfi_last_year/";

        foreach ($fNames as $fName) {
            $string = file_get_contents($path . $fName);
            $jsonArr = json_decode($string, true);

            $client->insertOne("results", $jsonArr);
            $initialTestRecords[] = $jsonArr;
        }

//        $numRecordsInserted = $client->insertMany("results", $initialTestRecords);
//        echo $numRecordsInserted . PHP_EOL;
        unset($client);
    }


}

//Helpers::test();
