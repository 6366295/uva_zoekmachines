<?php
    function facetPartij($filterpartij, $filterjaar, $buckets) {
        echo "<div class=\"panel panel-default\"><div class=\"panel-heading\"><h3 class=\"panel-title\">Partij</h3></div><div class=\"panel-body\">";



        if ($filterpartij == "0")
        {
            foreach ($buckets as $value)
            {
                echo "<button type=\"button\" class=\"btn btn-xs btn-default\" style=\"width:75%\" onclick=\"searchDatabase(0, '".$value['key']."', '$filterjaar');document.getElementById('facetdiv').scrollIntoView()\">";
                echo $value['key']." ";
                echo "</button>";
                echo "<span class=\"label label-default\">";
                echo $value['doc_count'];
                echo "</span>";
            }
        } else {
            foreach ($buckets as $value)
            {
                if ($filterpartij == $value['key'])
                {
                    echo "<button type=\"button\" class=\"btn btn-xs btn-primary\" style=\"width:75%\" onclick=\"searchDatabase(0, 0, '$filterjaar');document.getElementById('facetdiv').scrollIntoView()\">";
                    echo $value['key']." ";
                    echo "</button>";
                    echo "<span class=\"label label-default\">";
                    echo $value['doc_count'];
                    echo "</span>";
                }
                /*
                else
                {
                    echo "<button type=\"button\" class=\"btn btn-xs btn-default\" onclick=\"searchDatabase(0, '".$value['key']."', '$filterjaar');document.getElementById('facetdiv').scrollIntoView()\">";
                    echo $value['key']." ";
                    echo "<span class=\"badge\">";
                    echo $value['doc_count'];
                    echo "</span>";
                    echo "</button>"; 
                }  
                */
            }
        }


  
        echo "</div></div>";
    }
?>