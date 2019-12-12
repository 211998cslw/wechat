<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"><link rel="icon" href="https://jscdn.com.cn/highcharts/images/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        /* css 代码  */
    </style>
    <script src="https://code.highcharts.com.cn/highcharts/highcharts.js"></script>
    <script src="https://code.highcharts.com.cn/highcharts/highcharts-more.js"></script>
    <script src="https://code.highcharts.com.cn/highcharts/modules/exporting.js"></script>
    <script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>
</head>


<body>
<div>


    <h4>一周天气展示</h4>
    城市：<input type="text" name="city">
    <input type="button" value="搜索" id="search">
    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
</div>
<br>
<br>
<script>
    // JS 代码
</script>
</body>
</html>
<script src="/js/jquery.min.js?v=2.1.4"></script>
<script src="/js/bootstrap.min.js?v=3.3.6"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:"http://www.wechat.com/api/weather",
        data:{city:"北京"},
        dataType:"json",
        success:function(res){
            //展示天气图标
            weather(res.result);
        }
    })
    $('#search').on('click',function(){
        // alert(1);
        // 城市名
        var city = $('[name="city"]').val();
        // console.log(city);
        if (city == '') {
            alert('请填写城市名');
            return;
        }
        // 正则 校验 只能是汉字和拼音
        var reg = /^[a-zA-Z]+$|^[\u4e00-\u9fa5]+$/;
        var res = reg.test(city);
        if (!res) {
            alert('城市名只能填写汉字或者拼音');
            return;
        }
        $.ajax({
            url:"http://www.wechat.com/api/weather",
            data:{city:city},
            dataType:"json",
            success:function(res){
                //展示天气图标
                weather(res.result);
            }
        })
    })
    function weather(weatherData) {
        console.log(weatherData);
        var categories = [];
        var data = [];
        $.each(weatherData,function(i,v){
            categories.push(v.days);
            var arr = [parseInt(v.temp_low),parseInt(v.temp_high)];
            data.push(arr)
        })
        var chart = Highcharts.chart('container', {
            chart: {
                type: 'columnrange', // columnrange 依赖 highcharts-more.js
                inverted: true
            },
            title: {
                text: '一周温度变化范围'
            },
            subtitle: {
                text: weatherData[0]['citynm']
            },
            xAxis: {
                categories: categories
            },
            yAxis: {
                title: {
                    text: '温度 ( °C )'
                }
            },
            tooltip: {
                valueSuffix: '°C'
            },
            plotOptions: {
                columnrange: {
                    dataLabels: {
                        enabled: true,
                        formatter: function () {
                            return this.y + '°C';
                        }
                    }
                }
            },
            legend: {
                enabled: false
            },
            series: [{
                name: '温度',
                data: data
            }]
        });
    }
</script>