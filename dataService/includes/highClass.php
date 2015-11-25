<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of highClass
 *
 * @author admin
 */
class highClass {
    //put your code here
    public function gauge($div,$width,$text,$cutmin,$cutmax,$value) {
     
    $chart="<script>
        $(function () {

        $('#".$div."').highcharts({
            chart: {
                type: 'gauge',
                plotBackgroundColor: null,
                plotBackgroundImage: null,
                plotBorderWidth: 0,
                width: ".$width.",
                height:".$width.",
                plotShadow: false
            },
            title: {
                text: '".$text."',
                style: {
                fontSize: '13px',
                fontWeight: 'bold'
            }
            },
            pane: {
                startAngle: -90,
                endAngle: 90,
                background: [{
                        backgroundColor: '#fff',
                        borderWidth: 0
                    }]
            },

            yAxis: {
                min: 0,
                max: 100,
                minorTickInterval: 'auto',
                minorTickWidth: 1,
                minorTickLength: 10,
                minorTickPosition: 'inside',
                minorTickColor: '#666',
                tickPixelInterval: 30,
                tickWidth: 2,
                tickPosition: 'inside',
                tickLength: 15,
                tickColor: '#666',
                labels: {
                    step: 2,
                    rotation: 'auto'
                },
                title: {
                    text: 'ร้อยละ(%)'
                },
                plotBands: [{
                        from: 0,
                        to: ".$cutmin.",
                        color: '#FF0000' // 1
                    }, {
                        from: ".$cutmin.",
                        to: ".$cutmax.",
                        color: '#80FF00' // 4
                    }, {
                        from: ".$cutmax.",
                        to: 100,
                        color: '#088A08' // 5
                    }]
            },
                credits: {
                    enabled: false
                },
                exporting: { 
                    enabled: false 
                },
            series: [{
                    name: 'ร้อยละ',
                    data: [".$value."],
                    dataLabels: {
                        format: '<div style=\"text-align:center\">{y:.2f} % </span></div>',
                        enabled: true,
                        style: {
                            //fontWeight:'bold',
                            fontSize: '12px'
                        }
                    },
                    tooltip: {
                        valueSuffix: ' ร้อยละ(%)'
                    }
                }]

        },
               
// Add some life
        function (chart) {
            if (!chart.renderer.forExport) {

            }
        });
    });
    </script>
    " ;

        //$chart="llllll";
    return $chart;
        
    }
}
