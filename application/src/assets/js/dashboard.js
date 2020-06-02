// Session time
function dateChart1(){
    $(document).ready(function(){
        $(document).on("click", ".date-chart-1", function(){
            var startDate = $(this).attr("startdate");
            var finishDate = $(this).attr("finishdate");
            $('#chartSessionTime').remove(); // this is my <canvas> element
            $('#chartSessionTimeControl').append('<canvas height="150" id="chartSessionTime"><canvas>');
            $.ajax({
                url: '/graphics/session',
                type: 'POST',
                dataType: 'json',
                data: {"startDate": startDate, "finishDate":finishDate},
                success: function(data){
                     var color = Chart.helpers.color;
                        window.chartColors = {
                        red: 'rgb(255, 99, 132)',
                        orange: 'rgb(255, 159, 64)',
                        yellow: 'rgb(255, 205, 86)',
                        green: 'rgb(75, 192, 192)',
                        blue: 'rgb(54, 162, 235)',
                        purple: 'rgb(153, 102, 255)',
                        grey: 'rgb(201, 203, 207)',
                        tomato: 'rgb(255,99,71)',
                        darksalmon: 'rgb(233,150,122)',
                        brown: 'rgb(165,42,42)',
                    };
                        var ctx2 = document.getElementById("chartSessionTime").getContext("2d");

                        var string = "";
                        var labeldata = new Array();
                        var myData = new Array()
                        for(x in data.date){
                            labeldata[x] =  data.date[x];
                            myData[x] = data.duration[x];
                        }
                        
                        var data = {
                            labels: labeldata,
                            datasets: [
                                {
                                    label: "Minutos",
                                    backgroundColor: color(window.chartColors.yellow).alpha(0.5).rgbString(),
                                    borderColor: window.chartColors.yellow,
                                    data: myData
                                },                   
                            ]
                                
                        };

                        var myBarChart = new Chart(ctx2, {
                            type: 'line',
                            fill: false,
                            data: data,
                            options: {
                                barValueSpacing: 20,
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            min: 0,
                                        }
                                    }]
                                }
                            }
                        });
                    
                }
            })
        })
    })
}

// Session avarage 
function dateChart2(){
    $(document).ready(function(){
        $(document).on("click", ".date-chart-2", function(){
            var startDate = $(this).attr("startdate");
            var finishDate = $(this).attr("finishdate");
            $('#chartSessionAvarage').remove(); // this is my <canvas> element
            $('#chartSessionAvarageControl').append('<canvas height="150" id="chartSessionAvarage"><canvas>');
            $.ajax({
                url: '/graphics/session_average',
                type: 'POST',
                dataType: 'json',
                data: {"startDate": startDate, "finishDate":finishDate},
                success: function(data){
                     var color = Chart.helpers.color;
                        window.chartColors = {
                        red: 'rgb(255, 99, 132)',
                        orange: 'rgb(255, 159, 64)',
                        yellow: 'rgb(255, 205, 86)',
                        green: 'rgb(75, 192, 192)',
                        blue: 'rgb(54, 162, 235)',
                        purple: 'rgb(153, 102, 255)',
                        grey: 'rgb(201, 203, 207)',
                        tomato: 'rgb(255,99,71)',
                        darksalmon: 'rgb(233,150,122)',
                        brown: 'rgb(165,42,42)',
                    };
                        var ctx2 = document.getElementById("chartSessionAvarage").getContext("2d");

                        var string = "";
                        var labeldata = new Array();
                        var myData = new Array()
                        for(x in data.date){
                            labeldata[x] =  data.date[x];
                            myData[x] = data.duration[x];
                        }
                        
                        var data = {
                            labels: labeldata,
                            datasets: [
                                {
                                    label: "Minutos",
                                    backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
                                    borderColor: window.chartColors.red,
                                    data: myData
                                },                   
                            ]
                                
                        };

                        var myBarChart = new Chart(ctx2, {
                            type: 'line',
                            fill: false,
                            data: data,
                            options: {
                                barValueSpacing: 20,
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            min: 0,
                                        }
                                    }]
                                }
                            }
                        });
                    
                }
            })
        })
    })
}

// Session total
function dateChart3(){
    $(document).ready(function(){
        $(document).on("click", ".date-chart-3", function(){
            var startDate = $(this).attr("startdate");
            var finishDate = $(this).attr("finishdate");
            $('#chartSessionTotal').remove(); // this is my <canvas> element
            $('#chartSessionTotalControl').append('<canvas height="150" id="chartSessionTotal"><canvas>');
            $.ajax({
                url: '/graphics/session_total',
                type: 'POST',
                dataType: 'json',
                data: {"startDate": startDate, "finishDate":finishDate},
                success: function(data){
                     var color = Chart.helpers.color;
                        window.chartColors = {
                        red: 'rgb(255, 99, 132)',
                        orange: 'rgb(255, 159, 64)',
                        yellow: 'rgb(255, 205, 86)',
                        green: 'rgb(75, 192, 192)',
                        blue: 'rgb(54, 162, 235)',
                        purple: 'rgb(153, 102, 255)',
                        grey: 'rgb(201, 203, 207)',
                        tomato: 'rgb(255,99,71)',
                        darksalmon: 'rgb(233,150,122)',
                        brown: 'rgb(165,42,42)',
                    };
                        var ctx2 = document.getElementById("chartSessionTotal").getContext("2d");

                        var string = "";
                        var labeldata = new Array();
                        var myData = new Array()
                        for(x in data.date){
                            labeldata[x] =  data.date[x];
                            myData[x] = data.total[x];
                        }
                        
                        var data = {
                            labels: labeldata,
                            datasets: [
                                {
                                    label: "Total",
                                    backgroundColor: color(window.chartColors.purple).alpha(0.5).rgbString(),
                                    borderColor: window.chartColors.purple,
                                    data: myData
                                },                   
                            ]
                                
                        };

                        var myBarChart = new Chart(ctx2, {
                            type: 'bar',
                            fill: false,
                            data: data,
                            options: {
                                barValueSpacing: 20,
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            min: 0,
                                        }
                                    }]
                                }
                            }
                        });
                    
                }
            })
        })
    })
}




// Custom date to session time
function dateChart4(){
    $(document).ready(function(){
        $(document).on("click", ".chart1_personalize", function(){
            var startDate = $(this).prev('input').val();
            var finishDate = $(this).prev('input').prev('input').val();
            $('#chartSessionTime').remove(); // this is my <canvas> element
            $('#chartSessionTimeControl').append('<canvas height="150" id="chartSessionTime"><canvas>');
            $.ajax({
                url: '/graphics/session',
                type: 'POST',
                dataType: 'json',
                data: {"startDate": startDate, "finishDate":finishDate},
                success: function(data){
                     var color = Chart.helpers.color;
                        window.chartColors = {
                        red: 'rgb(255, 99, 132)',
                        orange: 'rgb(255, 159, 64)',
                        yellow: 'rgb(255, 205, 86)',
                        green: 'rgb(75, 192, 192)',
                        blue: 'rgb(54, 162, 235)',
                        purple: 'rgb(153, 102, 255)',
                        grey: 'rgb(201, 203, 207)',
                        tomato: 'rgb(255,99,71)',
                        darksalmon: 'rgb(233,150,122)',
                        brown: 'rgb(165,42,42)',
                    };
                    var ctx2 = document.getElementById("chartSessionTime").getContext("2d");

                    var string = "";
                    var labeldata = new Array();
                    var myData = new Array()
                    for(x in data.date){
                        labeldata[x] =  data.date[x];
                        myData[x] = data.duration[x];
                    }

                    var data = {
                        labels: labeldata,
                        datasets: [
                            {
                                label: "Minutos",
                                backgroundColor: color(window.chartColors.yellow).alpha(0.5).rgbString(),
                                borderColor: window.chartColors.yellow,
                                data: myData
                            },                   
                        ]
                            
                    };

                    var myBarChart = new Chart(ctx2, {
                        type: 'line',
                        fill: false,
                        data: data,
                        options: {
                            barValueSpacing: 20,
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        min: 0,
                                    }
                                }]
                            }
                        }
                    });
                }
            })
        })
    })
}

// Custom date to session avarage
function dateChart5(){
    $(document).ready(function(){
        $(document).on("click", ".chart2_personalize", function(){
            var startDate = $(this).prev('input').val();
            var finishDate = $(this).prev('input').prev('input').val();
            $('#chartSessionAvarage').remove(); // this is my <canvas> element
            $('#chartSessionAvarageControl').append('<canvas height="150" id="chartSessionAvarage"><canvas>');
            $.ajax({
                url: '/graphics/session_average',
                type: 'POST',
                dataType: 'json',
                data: {"startDate": startDate, "finishDate":finishDate},
                success: function(data){
                     var color = Chart.helpers.color;
                        window.chartColors = {
                        red: 'rgb(255, 99, 132)',
                        orange: 'rgb(255, 159, 64)',
                        yellow: 'rgb(255, 205, 86)',
                        green: 'rgb(75, 192, 192)',
                        blue: 'rgb(54, 162, 235)',
                        purple: 'rgb(153, 102, 255)',
                        grey: 'rgb(201, 203, 207)',
                        tomato: 'rgb(255,99,71)',
                        darksalmon: 'rgb(233,150,122)',
                        brown: 'rgb(165,42,42)',
                    };
                        var ctx2 = document.getElementById("chartSessionAvarage").getContext("2d");

                        var string = "";
                        var labeldata = new Array();
                        var myData = new Array()
                        for(x in data.date){
                            labeldata[x] =  data.date[x];
                            myData[x] = data.duration[x];
                        }
                        
                        var data = {
                            labels: labeldata,
                            datasets: [
                                {
                                    label: "Minutos",
                                    backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
                                    borderColor: window.chartColors.red,
                                    data: myData
                                },                   
                            ]
                                
                        };

                        var myBarChart = new Chart(ctx2, {
                            type: 'line',
                            fill: false,
                            data: data,
                            options: {
                                barValueSpacing: 20,
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            min: 0,
                                        }
                                    }]
                                }
                            }
                        });   
                }
            })
        })
    })
}

// Custom date to total session
function dateChart6(){
    $(document).ready(function(){
        $(document).on("click", ".chart3_personalize", function(){
            var startDate = $(this).prev('input').val();
            var finishDate = $(this).prev('input').prev('input').val();
            $('#chartSessionTotal').remove(); // this is my <canvas> element
            $('#chartSessionTotalControl').append('<canvas height="150" id="chartSessionTotal"><canvas>');
            $.ajax({
                url: '/graphics/session_total',
                type: 'POST',
                dataType: 'json',
                data: {"startDate": startDate, "finishDate":finishDate},
                success: function(data){
                     var color = Chart.helpers.color;
                        window.chartColors = {
                        red: 'rgb(255, 99, 132)',
                        orange: 'rgb(255, 159, 64)',
                        yellow: 'rgb(255, 205, 86)',
                        green: 'rgb(75, 192, 192)',
                        blue: 'rgb(54, 162, 235)',
                        purple: 'rgb(153, 102, 255)',
                        grey: 'rgb(201, 203, 207)',
                        tomato: 'rgb(255,99,71)',
                        darksalmon: 'rgb(233,150,122)',
                        brown: 'rgb(165,42,42)',
                    };
                        var ctx2 = document.getElementById("chartSessionTotal").getContext("2d");

                        var string = "";
                        var labeldata = new Array();
                        var myData = new Array()
                        for(x in data.date){
                            labeldata[x] =  data.date[x];
                            myData[x] = data.total[x];
                        }
                        
                        var data = {
                            labels: labeldata,
                            datasets: [
                                {
                                    label: "Total",
                                    backgroundColor: color(window.chartColors.purple).alpha(0.5).rgbString(),
                                    borderColor: window.chartColors.purple,
                                    data: myData
                                },                   
                            ]
                                
                        };

                        var myBarChart = new Chart(ctx2, {
                            type: 'bar',
                            fill: false,
                            data: data,
                            options: {
                                barValueSpacing: 20,
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            min: 0,
                                        }
                                    }]
                                }
                            }
                        });
                    
                }
            })
        })
    })
}


// Courses
function dateChart7(){
    $(document).ready(function(){
        $('#courses').remove(); // this is my <canvas> element
        $('#coursesControl').append('<canvas height="150" id="courses"><canvas>');
        $.ajax({
            url: '/graphics/chart_course',
            type: 'POST',
            dataType: 'json',
            success: function(data){
                 var color = Chart.helpers.color;
                    window.chartColors = {
                    red: 'rgb(255, 99, 132)',
                    orange: 'rgb(255, 159, 64)',
                    yellow: 'rgb(255, 205, 86)',
                    green: 'rgb(75, 192, 192)',
                    blue: 'rgb(54, 162, 235)',
                    purple: 'rgb(153, 102, 255)',
                    grey: 'rgb(201, 203, 207)',
                    tomato: 'rgb(255,99,71)',
                    darksalmon: 'rgb(233,150,122)',
                    brown: 'rgb(165,42,42)',
                };
                var ctx2 = document.getElementById("courses").getContext("2d");
                    var data = {
                        labels: ["Finalizados", "En progreso", "No iniciados"],
                            datasets: [
                                {
                                    label: "TeamA Score",
                                        data: [data.done,data.progress,data.null],
                                        backgroundColor: [
                                        color(window.chartColors.green).alpha(0.5).rgbString(),
                                        color(window.chartColors.yellow).alpha(0.5).rgbString(),
                                        color(window.chartColors.red).alpha(0.5).rgbString(),
                                        ],

                                        borderColor: [
                                            color(window.chartColors.green).alpha(0.5).rgbString(),
                                            color(window.chartColors.yellow).alpha(0.5).rgbString(),
                                            color(window.chartColors.red).alpha(0.5).rgbString(),
                                        ]
                                            
                                },
                                                    
                            ]
                                        
                    };

                    var myBarChart = new Chart(ctx2, {
                        type: 'doughnut',
                        fill: false,
                        data: data,
                        options: {
                            barValueSpacing: 20,
                            scales: {
                            yAxes: [{
                            ticks: {
                                min: 0,
                            }
                            }]
                            }
                        }
                    });
            }
        })
    })
}

// Sales
function salesChart(){
    $(document).ready(function(){
        $(document).on("click", ".sales", function(){
            var startDate = $(this).attr("startdate");
            var finishDate = $(this).attr("finishdate");
            $('#chartSales').remove(); // this is my <canvas> element
            $('#chartSalesControl').append('<canvas height="150" id="chartSales"><canvas>');
            $.ajax({
                url: '/graphics/sales',
                type: 'POST',
                dataType: 'json',
                data: {"startDate": startDate, "finishDate":finishDate},
                success: function(data){
                     var color = Chart.helpers.color;
                        window.chartColors = {
                        red: 'rgb(255, 99, 132)',
                        orange: 'rgb(255, 159, 64)',
                        yellow: 'rgb(255, 205, 86)',
                        green: 'rgb(75, 192, 192)',
                        blue: 'rgb(54, 162, 235)',
                        purple: 'rgb(153, 102, 255)',
                        grey: 'rgb(201, 203, 207)',
                        tomato: 'rgb(255,99,71)',
                        darksalmon: 'rgb(233,150,122)',
                        brown: 'rgb(165,42,42)',
                    };
                        var ctx2 = document.getElementById("chartSales").getContext("2d");

                        var string = "";
                        var labeldata = new Array();
                        var myData = new Array()
                        for(x in data.date){
                            labeldata[x] =  data.date[x];
                            myData[x] = data.total[x];
                        }
                        
                        var data = {
                            labels: labeldata,
                            datasets: [
                                {
                                    label: "Total $",
                                    backgroundColor: color(window.chartColors.green).alpha(0.5).rgbString(),
                                    borderColor: window.chartColors.green,
                                    data: myData
                                },                   
                            ]
                                
                        };

                        var myBarChart = new Chart(ctx2, {
                            type: 'line',
                            fill: false,
                            data: data,
                            options: {
                                barValueSpacing: 20,
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            min: 0,
                                        }
                                    }]
                                }
                            }
                        });
                    
                }
            })
        })
    })
}


// Sales personalize
function salesChartPersonalize(){
    $(document).ready(function(){
        $(document).on("click", ".sales_personalize", function(){
            var startDate = $(this).prev('input').val();
            var finishDate = $(this).prev('input').prev('input').val();
            $('#chartSales').remove(); // this is my <canvas> element
            $('#chartSalesControl').append('<canvas height="150" id="chartSales"><canvas>');
            $.ajax({
                url: '/graphics/sales',
                type: 'POST',
                dataType: 'json',
                data: {"startDate": startDate, "finishDate":finishDate},
                success: function(data){
                     var color = Chart.helpers.color;
                        window.chartColors = {
                        red: 'rgb(255, 99, 132)',
                        orange: 'rgb(255, 159, 64)',
                        yellow: 'rgb(255, 205, 86)',
                        green: 'rgb(75, 192, 192)',
                        blue: 'rgb(54, 162, 235)',
                        purple: 'rgb(153, 102, 255)',
                        grey: 'rgb(201, 203, 207)',
                        tomato: 'rgb(255,99,71)',
                        darksalmon: 'rgb(233,150,122)',
                        brown: 'rgb(165,42,42)',
                    };
                        var ctx2 = document.getElementById("chartSales").getContext("2d");

                        var string = "";
                        var labeldata = new Array();
                        var myData = new Array()
                        for(x in data.date){
                            labeldata[x] =  data.date[x];
                            myData[x] = data.total[x];
                        }
                        
                        var data = {
                            labels: labeldata,
                            datasets: [
                                {
                                    label: "Total $",
                                    backgroundColor: color(window.chartColors.green).alpha(0.5).rgbString(),
                                    borderColor: window.chartColors.green,
                                    data: myData
                                },                   
                            ]
                                
                        };

                        var myBarChart = new Chart(ctx2, {
                            type: 'line',
                            fill: false,
                            data: data,
                            options: {
                                barValueSpacing: 20,
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            min: 0,
                                        }
                                    }]
                                }
                            }
                        });
                    
                }
            })
        })
    })
}

// Start charts
function startCharts(){
    $(document).ready(function(){
        $('.start').each(function(){
            $(this).click();
        })
    })
}