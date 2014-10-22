<?php
    require 'F:/xampp/phpMyAdmin/vendor/autoload.php';
    require 'pagebuttons.php';
    require 'searchresults.php';
    require 'facetpartij.php';
    require 'facetjaar.php';
    require 'jsonparams.php';
    require 'jsonparams2.php';

    $client = new Elasticsearch\Client();

    // get data from index.php
    $query=$_REQUEST["q"];
    $qVraag=$_REQUEST["qv"];
    $qAntwoord=$_REQUEST["qa"];
    $qIndiener=$_REQUEST["qi"];
    $mode=$_REQUEST["m"];
    $currentpagevalue=$_REQUEST["p"];
    $fpartij=$_REQUEST["fp"];
    $fjaar=$_REQUEST["fj"];

    // select index and type
    $getParams = array();
    $getParams['index'] = 'kamervragen';
    $getParams['type'] = 'xml';

    // set search parameters
    if ($mode == 0)
    {
        $getParams = searchParamsNormal($getParams, $currentpagevalue, $query, $fpartij, $fjaar);
    }
    else
    {
        $getParams = searchParamsAdvanced($getParams, $currentpagevalue, $qVraag, $qAntwoord, $qIndiener, $fpartij, $fjaar);
    }

    // send to elasticsearch
    $retDoc = $client->search($getParams);



    echo "<div class=\"col-md-3\">";

    if ($fpartij != "0" && $fjaar != "0")
    {
        facetJaar($fjaar, $fpartij, $retDoc['aggregations']['aggsjaar']['aggsjaar2']['buckets']);
        echo "<button type=\"button\" class=\"btn btn-xs btn-default\" style=\"width:100%\" onclick=\"searchDatabase('$currentpagevalue', '0', '0')\">Reset filters</button><br><br>";
        facetPartij($fpartij, $fjaar, $retDoc['aggregations']['aggspartij']['aggspartij2']['buckets']);
    }
    else if ($fpartij != "0" && $fjaar == "0")
    {
        facetJaar($fjaar, $fpartij, $retDoc['aggregations']['aggsjaar']['aggsjaar2']['buckets']);
        facetPartij($fpartij, $fjaar, $retDoc['aggregations']['aggspartij']['buckets']);
    }
    else if ($fpartij == "0" && $fjaar != "0")
    {
        facetJaar($fjaar, $fpartij, $retDoc['aggregations']['aggsjaar']['buckets']);
        facetPartij($fpartij, $fjaar, $retDoc['aggregations']['aggspartij']['aggspartij2']['buckets']);
    }
    else
    {
        facetJaar($fjaar, $fpartij, $retDoc['aggregations']['aggsjaar']['buckets']);
        facetPartij($fpartij, $fjaar, $retDoc['aggregations']['aggspartij']['buckets']);
    }

    // col-md-3 div
    echo "</div>";




    echo "<div class=\"col-md-9\">";



    // display search results
    if ($retDoc['hits']['total'] == 0)
    {
        echo "<h4>No results!</h4>";
    }
    else
    {
        // display pagenr and total hits
        $currentpagenr = $currentpagevalue + 1;
        pageData($currentpagenr, $retDoc['hits']['total']);

        foreach ($retDoc['hits']['hits'] as $value) {
            echo "<div class=\"row\">";



            // generate search results
            echo "<div class=\"col-md-8\">";
            searchResults($value);
            echo "</div>";

            // temporary, for checking the score
            //echo "Score: ";
            //echo $value['_score'];

            // Wordcloud div here
            echo "<div class=\"col-md-4\">";
            echo "<div class=\"panel panel-default\"><div class=\"panel-body\">";

            $t = explode(".", $value['_source']['doc_id']);
            echo "<img src=\""."images\\".$t[0].".png"."\" style=\"width:60%\">";

            echo "</div></div>";
            echo "</div>";



            // row div
            echo "</div>";
        }
    
        // generate page navigation buttons
        pageButtons($retDoc['hits']['total'], $currentpagevalue, $fpartij, $fjaar);
    }



    // col-md-9 div
    echo "</div>";
?>