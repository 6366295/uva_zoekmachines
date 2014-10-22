<?php
    function facetJaar($filterjaar, $filterpartij, $buckets) {
        echo "<div id=\"facetdiv\" class=\"panel panel-default\"><div class=\"panel-heading\"><h3 class=\"panel-title\">Jaar</h3></div><div class=\"panel-body\">";

        if ($filterjaar == "0")
        {
            foreach ($buckets as $value)
            {
                echo "<button type=\"button\" class=\"btn btn-xs btn-default\" style=\"width:75%\" onclick=\"searchDatabase(0, '$filterpartij','".$value['key']."');document.getElementById('facetdiv').scrollIntoView()\">";
                echo $value['key']." ";
                echo "</button>";
                echo "<span class=\"label label-default\">";
                echo $value['doc_count'];
                echo "</span>"; 
            }
        } else {
            foreach ($buckets as $value)
            {
                if ($filterjaar == $value['key'])
                {
                    echo "<button type=\"button\" class=\"btn btn-xs btn-primary\" style=\"width:75%\" onclick=\"searchDatabase(0, '$filterpartij', 0);document.getElementById('facetdiv').scrollIntoView()\">";
                    echo $value['key']." ";
                    echo "</button>";
                    echo "<span class=\"label label-default\">";
                    echo $value['doc_count'];
                    echo "</span>";
                }
                /*
                else
                {
                    echo "<button type=\"button\" class=\"btn btn-xs btn-default\" onclick=\"searchDatabase(0, '$filterpartij', '".$value['key']."');document.getElementById('facetdiv').scrollIntoView()\">";
                    echo $value['key']." ";
                    echo "</button>";
                    echo "<span class=\"badge\">";
                    echo $value['doc_count']; 
                    echo "</span>";
                }  
                */
            }
        }


  
        echo "</div></div>";
    }
?>