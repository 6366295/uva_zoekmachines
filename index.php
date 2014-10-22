<!DOCTYPE html>
<html>
    <head>
        <title>Kamervragen Zoekmachine</title>

        <!-- Bootstrap core CSS -->
        <link href="bootstrap-3.2.0-dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="bootstrap-3.2.0-dist/css/grid.css" rel="stylesheet">
        
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
        <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <script>
    function runScript(e) {
        if (e.keyCode == 13) {
            searchDatabase('0', '0', '0')
        }
    }

    var mode = 0;

    function searchDatabase(p, fpartij, fjaar)
    {
        var xmlhttp;

        var str1 = document.getElementById("q_all").value;
        var str2 = document.getElementById("q_vraag").value;
        var str3 = document.getElementById("q_antwoord").value;
        var str4 = document.getElementById("q_indiener").value;

        var pagenr = p;

        if (str1.length < 3)
        { 
            document.getElementById("myResults").innerHTML="";
            return;
        }
        if (str2.length < 3 && str3.length < 3 && str4.length < 3)
        { 
            document.getElementById("myResults").innerHTML="";
            return;
        }

        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById("myResults").innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","results.php?q="+str1+"&qa="+str2+"&qi="+str4+"&qv="+str3+"&m="+mode+"&p="+pagenr+"&fp="+fpartij+"&fj="+fjaar,true);
        xmlhttp.send();

        if(typeof(Storage) !== "undefined") {
            var sessionstate = [];
            sessionstate.push(str1);
            sessionstate.push(str2);
            sessionstate.push(str3);
            sessionstate.push(str4);
            sessionstate.push(mode);
            sessionstate.push(fpartij);
            sessionstate.push(fjaar);
            sessionstate.push(pagenr);
            sessionStorage.setItem('sessionstate', JSON.stringify(sessionstate));
        }
    }

    function toggleMode()
    {
        if (document.getElementById("toggleButton").innerHTML == "Advanced Search") { 
            document.getElementById("toggleButton").innerHTML="Normal Search";
            document.getElementById("advanced").style.display="block";
            document.getElementById("normal").style.display="none";
            document.getElementById("q_all").value="    ";
            document.getElementById("q_vraag").value="";
            document.getElementById("q_antwoord").value="";
            document.getElementById("q_indiener").value="";

            mode = 1;
        }
        else
        {
            document.getElementById("toggleButton").innerHTML="Advanced Search";
            document.getElementById("advanced").style.display="none";
            document.getElementById("normal").style.display="block";
            document.getElementById("q_all").value="";
            document.getElementById("q_vraag").value="    ";
            document.getElementById("q_antwoord").value="    ";
            document.getElementById("q_indiener").value="    ";

            mode = 0;
        }
    }

    </script>

    </head>
    <body>
        <!-- Fixed navbar -->
        <div class="navbar navbar-default" role="navigation">
            <div class="container">
                <div class="col-md-3">
                    <h4><span class="label label-info">Kamervragen Zoekmachine</span></h4>
                </div>
                <div class="col-md-5" id=form1>
                    <div id="normal">
                        <input class="form-control" type="text" id="q_all" autocomplete="off" onkeypress="return runScript(event)"/>
                    </div>
                    <div id="advanced" style="display:none">
                        Vraag:
                        <input class="form-control" type="text" id="q_vraag" autocomplete="off" value="    " onkeypress="return runScript(event)"/>
                        <br>
                        Antwoord:
                        <input class="form-control" type="text" id="q_antwoord" autocomplete="off" value="    " onkeypress="return runScript(event)"/>
                        <br>
                        Indiener:
                        <input class="form-control" type="text" id="q_indiener" autocomplete="off" value="    " onkeypress="return runScript(event)"/>
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn btn-default" onclick="searchDatabase(0, 0, 0)">Search</button>
                    <button type="button" class="btn btn btn-default" onclick="toggleMode()" id="toggleButton">Advanced Search</button>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row" id="myResults">
            </div>
        </div>
    </body>
</html>

<script>

if(typeof(Storage) !== "undefined")
{
    if(sessionStorage.getItem('sessionstate') != null)
    {
        var sessionstate = JSON.parse(sessionStorage.getItem('sessionstate'));
        document.getElementById("q_all").value = sessionstate[0];

        if(sessionstate[4] == 1)
        {
            toggleMode();
            document.getElementById("q_vraag").value = sessionstate[1];
            document.getElementById("q_antwoord").value = sessionstate[2];
            document.getElementById("q_indiener").value = sessionstate[3];
        }

        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                document.getElementById("myResults").innerHTML=xmlhttp.responseText;
            }
        }

        xmlhttp.open("GET","results.php?q="+sessionstate[0]+"&qa="+sessionstate[1]+"&qi="+sessionstate[3]+"&qv="+sessionstate[2]+"&m="+sessionstate[4]+"&p="+sessionstate[7]+"&fp="+sessionstate[5]+"&fj="+sessionstate[6],true);
        xmlhttp.send();
    }
}
</script>