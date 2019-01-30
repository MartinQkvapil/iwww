<?php

class DataTable
{
    private $dataSet;
    private $columns;

    public function __construct($dataSet)
    {
        $this->dataSet = $dataSet;
    }

    public function addColumn($databaseColumnName, $tableHeadTitle)
    {
        $this->columns[$databaseColumnName] = array("table-head-title" => $tableHeadTitle);
    }

    public function addButton($databaseColumnName, $tableHeadTitle)
    {
        $this->columns[$databaseColumnName] = array("table-head-title" => $tableHeadTitle);
    }

    public function render()
    {
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        foreach ($this->columns as $key => $value) {
            echo "<th>" . $value["table-head-title"] . "</th>";
        }
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($this->dataSet as $row) {
            echo "<tr>";
            foreach ($this->columns as $key => $value) {
                echo "<td>" . $row[$key] . "</td>";
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "Total rows: " . sizeof($this->dataSet);
    }

    public function renderSpecial(string $id)
    {

        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        foreach ($this->columns as $key => $value) {
            echo "<th>" . $value["table-head-title"] . "</th>";
        }
        switch ($id) {
            case 'udalost':
                echo "<th>" . "AKCE" . "</th>";
                echo "<th>" . "AKCE" . "</th>";
                break;
            case 'detailUdalosti':
                echo "<th>" . "AKCE" . "</th>";
                echo "<th>" . "AKCE" . "</th>";
                break;
            case 'mistnost':
                echo "<th>" . "AKCE" . "</th>";
                echo "<th>" . "AKCE" . "</th>";
                break;
            case 'vybaveni':
                echo "<th>" . "AKCE" . "</th>";
                echo "<th>" . "AKCE" . "</th>";
                break;
            default:
                break;
        }
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($this->dataSet as $row) {
            echo "<tr>";
            foreach ($this->columns as $key => $value) {
                echo "<td>" . $row[$key] . "</td>";
            }
            switch ($id) {
                case 'udalost':
                    echo "<td>" . "<a href='?page=udalost&action=editUdalost&id={$row['idudalost']}'>edituj</a>" . "</td>";
                    echo "<td>" . "<a href='?page=udalost&action=smazUdalost&id={$row['idudalost']}'>Smaž</a>" . "</td>";
                    break;
                case 'detailUdalosti':
                    echo "<td>" . "<a href='?page=udalost&action=editdetailUdalosti&id={$row['iddetail_udalosti']}'>edituj</a>" . "</td>";
                    echo "<td>" . "<a href='?page=udalost&action=smazdetailUdalosti&id={$row['iddetail_udalosti']}'>Smaž</a>" . "</td>";
                    break;
                case 'mistnost':
                    echo "<td>" . "<a href='?page=mistnosti&action=editMistnost&id={$row['idmistnost']}'>edituj</a>" . "</td>";
                    echo "<td>" . "<a href='?page=mistnosti&action=smazMistnost&id={$row['idmistnost']}'>Smaž</a>" . "</td>";
                    break;
                case 'vybaveni':
                    echo "<td>" . "<a href='?page=mistnosti&action=editVybaveni&id={$row['idvybaveni']}'>edituj</a>" . "</td>";
                    echo "<td>" . "<a href='?page=mistnosti&action=smazVybaveni&id={$row['idvybaveni']}'>Smaž</a>" . "</td>";
                    break;
                default:
                    break;
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "Total rows: " . sizeof($this->dataSet);
    }
}