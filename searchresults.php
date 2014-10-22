<?php
    function pageData($currentpagenr, $totalhits)
    {
        echo "Page ".$currentpagenr." of ".$totalhits." results";
    }

    function searchResults($hit)
    {
        // inhoud and link to document
        echo "<a href=\"KVR\\".$hit['_source']['doc_id']."\"><h4>";

        if ($hit['_source']['inhoud'] == "")
        {
            if ($hit['_source']['trefwoorden'] == "")
            {
                echo $hit['_source']['doc_id'];
            }
            else
            {
                $splitTref = explode(" ", $hit['_source']['trefwoorden']);

                foreach (array_slice($splitTref, 0, 15) as $token)
                {
                    echo $token;
                    echo " ";
                }

                if (count($splitTref) > 15) {
                    echo "...";
                }
            }
        } else {
            $splitInhoud = explode(" ", $hit['_source']['inhoud']);
            //$splitInhoud = explode(" ", $hit['highlight']['inhoud'][0]);

            foreach (array_slice($splitInhoud, 0, 15) as $token)
            {
                echo $token;
                echo " ";
            }

            if (count($splitInhoud) > 15) {
                echo "...";
            }
        }
        echo "</h4></a>";



        // some document contents
        $splitVraag = explode(" ",$hit['_source']['vraag']);

        foreach (array_slice($splitVraag, 0, 50) as $token)
        {
            echo $token;
            echo " ";
        }

        if (count($splitVraag) > 50)
        {
            echo "...";
        }
        elseif (count($splitVraag) < 50)
        {
            $splitAnt = explode(" ", $hit['_source']['antwoord']);

            foreach (array_slice($splitAnt, 0, 50 - count($splitVraag)) as $token)
            {
                echo $token;
                echo " ";
            }

            echo "...";
        }
        echo "<br>";

        // doc-id
        echo "<span class=\"label label-info\">"."Jaar: ".$hit['_source']['jaar']."</span>  ";
        $temp = explode(", ",$hit['_source']['partij']);
        $temp = array_unique($temp);
        echo "<span class=\"label label-default\">"."Partij: ";
        $i = 0;
        foreach ($temp as $word) {
            echo $word;
            if ($i != count($temp) - 1)
                echo ", ";
            $i++;
        }
        echo "</span>";
    }
?>