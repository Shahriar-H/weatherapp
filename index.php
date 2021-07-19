<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Applications</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body>
    <div class="district">
        <select onchange="getdis(this.value)" name="district" id="district">
            <option selected value="Dhaka">Dhaka</option>
            <option value="Kushtia">Kushtia</option>
            <option value="Rajshahi">Rajshahi</option>
            <option value="Pabna">Pabna</option>

        </select>
    </div>
    <div class="maindiv">
        <div class="carddiv">
            <h2><i class="fas fa-map-marker-alt"></i> <span id="districtnameis"></span>, BD</h2>
            <p>Todays weather of this selected location</p>
            <i id="weathdericon" class="fas  fa-3x"></i>
        </div>
        <div class="div1"></div>
        <div class="div3"></div>
        <div class="div2"> </div>
        <div class="temp">
            <h1 id="temp"><img style="max-width:30px" src="./unnamed.gif" alt=""></h1>
            <p> <span id="condition"></span> Weather at  <?php date_default_timezone_set("Asia/Dhaka"); echo date('h:i a'); ?> | <?php echo date('d-M') ?></p>
        </div>
    </div>
    <script>

        function getweater(dist){ //all the data fatch through this function
            document.getElementById('districtnameis').innerHTML=dist;
            var jx = new XMLHttpRequest();
            jx.open('GET','http://api.openweathermap.org/data/2.5/weather?q='+dist+'&appid=af014872cebca3f582cd696d0a2f59cd',true);
            jx.onreadystatechange = function(){
                if(jx.readyState==4 && jx.status==200){
                    var data = jx.response;
                    var newdata = JSON.parse(data);
                    var condition = newdata.weather[0].main;
                    var tempa = newdata.main.temp-273.15;
                    var tempa2 = tempa.toFixed(2);
                    if(condition=='Haze'){
                        document.getElementById('weathdericon').classList.add('fa-smog');
                    }else if(condition=='Clouds'){
                        document.getElementById('weathdericon').classList.add('fa-cloud');
                    }else if(condition=='Sunny'){
                        document.getElementById('weathdericon').classList.add('fa-sun');
                    }else if(condition=='Rain'){
                        document.getElementById('weathdericon').classList.add('fa-cloud-rain');
                    }
                    else if(condition=='Drizzle'){
                        document.getElementById('weathdericon').classList.add('fa-cloud-sun');
                    }
                    
                    document.getElementById('temp').innerHTML = tempa2+'<sup> o</sup>C';
                    document.getElementById('condition').innerHTML = condition;
                    console.log(tempa2);
                }
            }
            jx.send();
        }
        getweater('Dhaka'); //initially district fixed as dhaka
       var nameofdist = '';
        function alldist(){ //all the district name will get through this function
            var htp = new XMLHttpRequest();
            htp.open('GET','bddistricts.json',true);

            htp.onreadystatechange = function(){
                if(htp.readyState==4 && htp.status==200){
                    var disdata = htp.response;
                    var objdata = JSON.parse(disdata);
                    console.log(objdata.districts);
                     for(var i=0; i<=63; i++){
                        //console.log(objdata.districts[i].name);
                        var nameis = objdata.districts[i].name;
                        nameofdist += '<option value="'+nameis+'">'+nameis+'</option>'
                     }
                     //console.log(nameofdist);
                     document.getElementById('district').innerHTML = nameofdist;

                }
            }

            htp.send();
        }
        alldist();

        function getdis(dis){ //function for change district wise data
            getweater(dis);
        }
    </script>
</body>
</html>