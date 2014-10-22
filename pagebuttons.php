<?php
    function pageButtons($totalhits, $currentpagevalue, $filterpartij, $filterjaar)
    {
        $lasthits = $totalhits % 10;
        $totalpages = ($totalhits - $lasthits) / 10;

        echo "<br>";

        if ($currentpagevalue > 0)
        {
            $pagenrvalue = $currentpagevalue - 1;
            echo "<button type=\"button\" class=\"btn btn btn-default\" value=\"$pagenrvalue\" onclick=\"searchDatabase(this.value, '$filterpartij', '$filterjaar'); scroll(0,0)\" \">Previous</button>";
        }

        if ($currentpagevalue > 4) {
            $buttonnr = ($currentpagevalue - 4 + 10);

            for ($i = $currentpagevalue - 4; $i <= $buttonnr; $i++)
            {
                $pagenrvalue = $i - 1;
                echo "<button type=\"button\" class=\"btn btn btn-default\" value=\"$pagenrvalue\" ";

                if ($i != $currentpagevalue+1)
                {
                    echo "onclick=\"searchDatabase(this.value, '$filterpartij', '$filterjaar'); scroll(0,0)\" ";
                } else {
                    echo "style=\"background-color:#C4C4C4\" ";
                }

                echo "\">$i</button>";

                if ($totalpages + 1 == $i) {
                    break;
                }
            }
        }
        else
        {
            for ($i = 1; $i <= 10; $i++)
            {
                $pagenrvalue = $i - 1;
                echo "<button type=\"button\" class=\"btn btn btn-default\" value=\"$pagenrvalue\" ";

                if ($i != $currentpagevalue+1)
                {
                    echo "onclick=\"searchDatabase(this.value, '$filterpartij', '$filterjaar');scroll(0,0)\" ";
                } else {
                    echo "style=\"background-color:#C4C4C4\" ";
                }

                echo "\">$i</button>";

                if ($totalpages+1 == $i)
                {
                    break;
                }
            }
        }
        if ($totalpages != $currentpagevalue) {
            $pagenrvalue = $currentpagevalue + 1;
            echo "<button type=\"button\" class=\"btn btn btn-default\" value=\"$pagenrvalue\" onclick=\"searchDatabase(this.value, '$filterpartij', '$filterjaar');scroll(0,0)\" \">Next</button>";
        }
    }
?>