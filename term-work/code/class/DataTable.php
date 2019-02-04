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

    public function addSpecialColumn($databaseColumnName, $tableHeadTitle)
    {
        $array[$databaseColumnName] = array("table-head-title" => $tableHeadTitle);
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
            case 'uzivatel':
                echo "<th>" . "AKCE" . "</th>";
                echo "<th>" . "AKCE" . "</th>";
                echo "<th>" . "AKCE" . "</th>";
                break;
            case 'storno':
                echo "<th>" . "AKCE" . "</th>";
                echo "<th>" . "STATUS" . "</th>";
                break;
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
            case 'listky':
                echo "<th>" . "ČINNOST" . "</th>";

                break;
            case 'listky-sp':
                echo "<th>" . "ČINNOST" . "</th>";
                break;
            case 'sp-listku':
                echo "<th>" . "ČINNOST" . "</th>";
                echo "<th>" . "ČINNOST" . "</th>";
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
                case 'uzivatel':
                    echo "<td>" . "<a class='button' href='?page=uzivatelFinal&action=read-one&id={$row['iduzivatel']}'>ZOBRAZIT</a>" . "</td>";
                    echo "<td>" . "<a  class='button' href='?page=uzivatelFinal&action=edit&id={$row['iduzivatel']}'>UPRAVIT</a>" . "</td>";
                    echo "<td>" . "<a  class='button' href='?page=uzivatelFinal&action=delete&id={$row['iduzivatel']}'>SMAZAT</a>" . "</td>";
                    break;
                case 'storno':
                    echo "<td>" . "<a class='button' href='?page=deleteListek&id={$row['idfaktura']}'>STORNO</a>" . "</td>";
                    echo "<td>" . self::status($row['zaplaceno']) . "</td>";
                    break;
                case 'udalost':
                    echo "<td>" . "<a class='button' href='?page=udalost&action=editUdalost&id={$row['idudalost']}'>PŘIDEJ ROČNÍK</a>" . "</td>";
                    echo "<td>" . "<a class='button' href='?page=udalost&action=smazUdalost&id={$row['idudalost']}'>SMAŽ</a>" . "</td>";
                    break;
                case 'detailUdalosti':
                    echo "<td>" . "<a class='button' href='?page=udalost&action=editdetailUdalosti&id={$row['iddetail_udalosti']}'>edituj</a> " . "</td>";
                    echo "<td>" . "<a class='button' href='?page=udalost&action=smazdetailUdalosti&id={$row['iddetail_udalosti']}'>Smaž</a>" . "</td>";
                    break;
                case 'mistnost':
                    echo "<td>" . "<a class='button' href='?page=mistnosti&action=editMistnost&id={$row['idmistnost']}'>edituj</a>" . "</td>";
                    echo "<td>" . "<a class='button' href='?page=mistnosti&action=smazMistnost&id={$row['idmistnost']}'>Smaž</a>" . "</td>";
                    break;
                case 'vybaveni':
                    echo "<td>" . "<a class='button' href='?page=mistnosti&action=editVybaveni&id={$row['idvybaveni']}'>edituj</a>" . "</td>";
                    echo "<td>" . "<a class='button' href='?page=mistnosti&action=smazVybaveni&id={$row['idvybaveni']}'>Smaž</a>" . "</td>";
                    break;
                case 'listky':
                    echo "<td>" . "<a class='button' href='?page=buy-ticket&id={$row['iddetail_udalosti']}'>Koupit lístky</a>" . "</td>";

                    break;
                case 'listky-sp':
                    echo "<td>" . "<a class='button' href='?page=sp-tickett&id={$row['iddetail_udalosti']}'>SPRAVOVAT LÍSTKY</a>" . "</td>";

                    break;
                case 'sp-listku':
                    echo "<td>" . "<a class='button' href='?page=deleteListek&id={$row['idfaktura']}'>STORNO</a>" . "</td>";
                    echo "<td>" . "<a class='button' href='?page=zaplaceno&id={$row['idfaktura']}'>ZAPLACENO</a>" . "</td>";
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

    public static function status($tmp)
    {
        switch ($tmp) {
            case 1:
                return "<img src=\"./pics/orange.png\" width='20' height='20'>";
                break;
            case 2:
                return "<img src=\"./pics/red.png\" width='20' height='20'>";
                break;
            case 3:
                return "<img src=\"./pics/green.png\" width='20' height='20' >";
                break;
            case 4:
                return "<td><img src=\"./pics/red.png\" width='20' height='20' ></td>";
                break;
            case 5:
                break;
            default:
                return "<div class=\"good\">" . "Neznámý stav!" . "</div>";
                echo "<img src='../pics/red.png' border='0' />, ";
                break;


        }
    }
}