<?php namespace App\Lib;

class Csv
{

    private $data = array();

    public function __construct($csvFile)
    {

        if ( file_exists($csvFile) ) {
            $return = $this->parseCSV($csvFile);
        }
        else {
            $return = $this->returnValue(false, "Ingredients CSV file does not exist");
        }

        return $return;

    }

    private function parseCSV($csvFile)
    {
        if (($handle = fopen($csvFile, "r")) !== FALSE) {

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                $num = count($data);

                if ( $num != 4 ) {
                    //TODO : display message that a row was not processed
                }
                else {
                    // add row
                    $this->addRow($data);
                }

            }

            fclose($handle);

            $return = $this->returnValue(true);
        }
        else {

            $return = $this->returnValue(false, "could not open " . $csvFile . " for reading");

        }

        return $return;
    }

    private function returnValue($valid, $message = "")
    {
        return array(
            "valid" => $valid,
            "message" => $message
        );
    }

    private function addRow($row = array())
    {
        $formattedRow = array();

        foreach($row as $pos => $col) {

            switch( $pos ) {
                case 0:
                    $formattedRow["name"] = $col;
                    break;

                case 1:
                    $formattedRow["amount"] = $col;
                    break;

                case 2:
                    $formattedRow["unit"] = $col;
                    break;

                case 3:
                    $date = \DateTime::createFromFormat('d/m/Y+', $col); // format - 25/12/2014
                    $checkdate = \DateTime::getLastErrors();

                    // invalid date format
                    if ( $checkdate["error_count"] == 0 ) {
                        $formattedRow["usedby"] = $date;
                        $formattedRow["usedbytime"] = $date->getTimestamp();
                    }
                    else {
                        $formattedRow["usedby"] = null;
                        $formattedRow["usedbytime"] = null;
                    }

                    break;
            }


        }

        $currentTime = new \DateTime();

        // only add ingredients which are not expired
        if ( ! is_null($formattedRow["usedbytime"]) && $formattedRow["usedbytime"] > $currentTime->getTimestamp() ) {
            $this->data[] = $formattedRow;
        }

        return $this;
    }

    public function get()
    {
        return $this->data;
    }

    public function count()
    {
        return count($this->data);
    }

    public function sort($col = "usedbytime")
    {
        return usort($this->data, function($a, $b) use ($col) {
            return $a[$col] - $b[$col];
        });
    }
}