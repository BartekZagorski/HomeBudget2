<?php
    session_start();
    if (!isset($_SESSION['loggedInUserId'])) {
        header('Location: index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>HomeBudget</title>
    <meta name="description" content="Program pomagający zapanować nad finansami domowymi">
	<meta name="keywords" content="finanse, budżet, pieniądze, bilans, saldo, wydatki, przychody, zakupy, oszczędności">
	<meta name="author" content="Bartłomiej Zagórski">
    <meta http-equiv="X-Ua-Compatible" content="IE=edge">
	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/main.css">
	<link rel="stylesheet" href="./css/fontello.css">
	<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400&display=swap" rel="preload" as="style">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400&display=swap" rel="stylesheet">  
	<!--[if lt IE 9]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
</head>

<body>

    <?php    
    require_once "headerAndNavbar.php"; 
    ?> 

    <main>
        <article id="main-content" class="py-5 height-navbar">
            <div class="container">
                <div class="row">
                    <div class="col px-0">
                        <div class="dropdown">
                            <button type="button" class="btn btn-success dropdown-toggle float-right" data-toggle="dropdown">
                                wybierz okres
                            </button>
                            <div class="dropdown-menu dropdown-menu-right py-0">
                                <button type="button" class="dropdown-item" id="currentMonth">Bieżący Miesiąc</button>
                                <button type="button" class="dropdown-item" id="previousMonth">Poprzedni Miesiąc</button>
                                <button type="button" class="dropdown-item" id="currentYear">Bieżący Rok</button>
                                <button type="button" class="dropdown-item" data-toggle="modal" data-target="#choose-period">Inny okres</button>
                            </div>
                        </div>
                        
                    </div>
                </div>
             
                <div class="row" id="browseStatement">
                    <?php    
                        require_once "browseStatementOfCurrentMonth.php";
                    ?>    
                </div>
                <div class="row mx-auto">
                    <div class="col" id="piechart"></div>
                </div>
                
            </div>
        </article>
    </main>

    <!--modal choose period-->

    <div class="modal bd-example-modal-sm fade" id="choose-period">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Wybierz okres</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="anotherPeriod">
                        <label class="control-label mb-1">Wybierz datę początkową:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text px-2"><i class="icon-calendar"></i></span>
                            </div>
                            <input type="date" name="start-date" id="start-date" class="form-control" min="2000-01-01" required>
                        </div>
                        <label class="control-label mb-1">Wybierz datę końcową:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend d-flex justify-content-center">
                                <span class="input-group-text"><i class="icon-calendar"></i></span>
                            </div>
                            <input type="date" name="end-date" id="end-date" class="form-control" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-outline-success py-1"><i class="icon-plus-circled"></i>zatwierdź</button>
                            <button type="button" class="btn btn-outline-danger py-1" data-dismiss="modal"><i class="icon-cancel-circled"></i>anuluj</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery-->
    <script src="./js/jquery-3.5.1.min.js"></script>
    <!--bootstrap js-->
    <script src="./js/bootstrap.bundle.min.js"></script>

    <script>
            $(document).ready(function(){
                    $("#currentMonth").click(function()
                    {
                        $("#browseStatement").load("browseStatementOfCurrentMonth.php", function(){drawChart();});
                    });

                    $("#previousMonth").click(function()
                    {
                        $("#browseStatement").load("browseStatementOfPreviousMonth.php", function(){drawChart();});
                    });

                    $("#currentYear").click(function()
                    {
                        $("#browseStatement").load("browseStatementOfCurrentYear.php", function(){drawChart();});
                    });

                    $(document).on('submit', '#anotherPeriod',function()
                    {
                        $("#browseStatement").load("browseStatementOfAnotherPeriod.php",
                            {
                                beginDate: $("#start-date").val(),
                                endDate: $("#end-date").val()
                            }, function(){drawChart();});
                        $('#choose-period').modal('hide');
                        return false;
                    });

                    let today = new Date();
                    let date = new Date(today.getFullYear(), today.getMonth()+1, 0);
                    let yr = date.getFullYear();
                    let month = date.getMonth() < 9 ? '0' + (date.getMonth()+1) : date.getMonth()+1;
                    let day = date.getDate()  < 10 ? '0' + date.getDate()  : date.getDate();
                    let lastDayOfThisMonth = yr + '-' + month + '-' + day;
                    $("#start-date").attr("max", lastDayOfThisMonth);
                    $("#end-date").attr("max", lastDayOfThisMonth);

                    $("#start-date").change(function(){
                        $("#end-date").attr("min", $("#start-date").val());
                    });
                    $("#end-date").change(function(){
                        $("#start-date").attr("max", $("#end-date").val());
                    });
                });
                $(window).resize(function(){
                    drawChart();
                });

    </script>




<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
    let expensesAccordingToCattegories = [];
    let dataFromTable = document.getElementById("expenses-according-to-cattegories");
    if (!dataFromTable)
    {
        $("#piechart").html("");
    }
    else
    {
        let lengthOfDataFromTable = dataFromTable.rows.length;

        for (i=0; i<lengthOfDataFromTable-1; i++)
        {
            var row = dataFromTable.rows.item(i).cells;
            var tab = [];

            for (j=1; j < row.length; j++)
            {
                if (j%2 == 0)
                tab.push(parseFloat(row.item(j).innerText.trim()));
                else
                tab.push(row.item(j).innerText.trim());
            }
            expensesAccordingToCattegories.push(tab);
        }
        let data = google.visualization.arrayToDataTable(expensesAccordingToCattegories, true);

        // Optional; add a title and set the width and height of the chart
        let options = {'title':'Wydatki według kategorii', 'fontFamily': 'Josefin Sans', 'height': '500', 'is3D': 'true', 'backgroundColor': {
                fill:'none'}, 'titleTextStyle': {
                color: 'white', fontSize: 22, fontName: 'Josefin Sans'}, 'legend': {
                'textStyle': {
                    color: 'white',
                    fontName: 'Josefin Sans'
                }, 
                position: 'bottom',
                alignment: 'center'}, 
                'pieSliceTextStyle': {fontName: 'Josefin Sans'},
                    'sliceVisibilityThreshold': 0};

        // Display the chart inside the <div> element with id="piechart"
        let chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }
}
</script>

</body>
</html>