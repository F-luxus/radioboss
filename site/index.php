<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script
			  src="https://code.jquery.com/jquery-3.6.0.js"
			  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
			  crossorigin="anonymous">
			
	</script>
	<title>RadioBoss controller</title>
	<link rel="stylesheet" type="text/css" href="style.css?<?php echo time(); ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<center>

	<div STYLE="display: none" class="in">
        <div class="player">
            <div class="playing_now">...</div>
            <div class="playing_time">
                <span class="now_time">00:00:00</span>
                <span class="end_time">-00:00:00</span>
            </div>

            <div class="playing_next_label">Kita daina:</div>
            <div class="playing_next">...</div>
        </div>
        <div class="buttons">
            <span onclick="change()" class="mic_button">🎙️ MIC</span>
            <span onclick="playNext()" class="next_button"><i class="fa-solid fa-forward"></i></span>
        </div>

<!--		<input onclick="events()" type="button" id="data" class="butt" value="Rodyti eventus" />-->
<!--		<p id="eventai">Laukiama atsakymo</p>-->
	</div>

	
</center>
<script type="text/javascript">


    $( document ).ready(function() {
        getmic()
        INIT()
        realtime();
        setInterval(realtime, 1000);
    });

	function change()
	{

		var server = window.location.hostname;
		var port = "9001";
		var pass = "0000000000";
        $('.mic_button').addClass('activetemp')
		$.ajax({
		   type: "POST",
			data: {
			 server: server,
			 port: port,
			 pass: pass,
			 action: "mic"
			 },
		   url: "req.php",
		   success: function(msg){
               if (msg === 'FAILED') { alert('Patikrink RadioBoss API nustatymus'); return 1; }
               if($('.mic_button.active').length){
                   $('.mic_button').removeClass('active')
                   $('.mic_button').removeClass('activetemp')
               }else{
                   $('.mic_button').addClass('active')
                   $('.mic_button').addClass('activetemp')
               }
		   }
		});
	    
	}
</script>
<script type="text/javascript">
	function songs()
	{
		var server = window.location.hostname;
		var port = "9001";
		var pass = "0000000000";
		$.ajax({
		   type: "POST",
			data: {
			 server: server,
			 port: port,
			 pass: pass,
			 action: "songs"
			 },
		   url: "req.php",
		   success: function(msg){
               if (msg === 'FAILED') { alert('Patikrink RadioBoss API nustatymus'); return 1; }
		        document.getElementById('daina').innerHTML=msg;
		   }
		});
	    
	}
    const toHms = totalSeconds => {
        const h = String(Math.floor(totalSeconds / 3600)).padStart(2, '0');
        const m = String(Math.floor(totalSeconds % 3600 / 60)).padStart(2, '0');
        const s = String(totalSeconds % 60).padStart(2, '0');
        if(m < 0){
            return `00:00:00`;
        }
        return `${h}:${m}:${s}`;
    }
    function realtime()
	{
		var server = window.location.hostname;
		var port = "9001";
		var pass = "0000000000";
		$.ajax({
		   type: "POST",
			data: {
			 server: server,
			 port: port,
			 pass: pass,
			 action: "realtime"
			 },
		   url: "req.php",
		   success: function(msg){
               if(msg.current_song){
                   $('.playing_now').text(msg.current_song)
                   const posHms  = toHms(Math.floor(msg.song_position / 1000));
                   const leftHms = toHms(msg.song_left);
                   $('.now_time').text(posHms)
                   $('.end_time').text('-'+leftHms)
                   $('.playing_next').text(msg.next_song)

               }
		   }
		});

	}
</script>
<script type="text/javascript">
	function playNext()
	{
		var server = window.location.hostname;
		var port = "9001";
		var pass = "0000000000";
		$.ajax({
		   type: "POST",
			data: {
			 server: server,
			 port: port,
			 pass: pass,
			 action: "next"
			 },
		   url: "req.php",
		   success: function(msg){
               if (msg === 'FAILED') { alert('Patikrink RadioBoss API nustatymus'); return 1; }
		   }
		});
	    
	}		
</script>
<script type="text/javascript">
	function events()
	{
		var server = window.location.hostname;
		var port = "9001";
		var pass = "0000000000";
		$.ajax({
		   type: "POST",
			data: {
			 server: server,
			 port: port,
			 pass: pass,
			 action: "events"
			 },
		   url: "req.php",
		   success: function(msg){
               if (msg === 'FAILED') { alert('Patikrink RadioBoss API nustatymus'); return 1; }
		     document.getElementById('eventai').innerHTML=msg;
		   }
		});
	    
	}
    function getmic()
	{
		var server = window.location.hostname;
		var port = "9001";
		var pass = "0000000000";
		$.ajax({
		   type: "POST",
			data: {
			 server: server,
			 port: port,
			 pass: pass,
			 action: "getmic"
			 },
		   url: "req.php",
		   success: function(msg){
               if (msg === 'FAILED') { alert('Patikrink RadioBoss API nustatymus'); return 1; }
               if(msg){
                   $('.mic_button').addClass('active')
                   $('.mic_button').addClass('activetemp')
               }
		   }
		});

	}
    function INIT()
    {

        var server = window.location.hostname;
        var port = "9001";
        var pass = "0000000000";
        $.ajax({
            type: "POST",
            data: {
                server: server,
                port: port,
                pass: pass,
                action: "events"
            },
            url: "req.php",
            success: function(msg){
                if(msg === 'FAILED'){
                    alert('Patikrink RadioBoss API nustatymus ir perkrauk puslapį')
                }else{
                    $('.in').show();
                }

            }
        });

    }


</script>

<script type="text/javascript">
	function runevent(a, b)
	{
		var server = window.location.hostname;
		var port = "9001";
		var pass = "0000000000";
		var typeId = document.getElementById('eventai').getAttribute('data-typeId');
		$.ajax({
		   type: "POST",
			data: {
			 server: server,
			 port: port,
			 pass: pass,
			 id: a,
			 name: b,
			 action: "run"
			 },
		   url: "req.php",
		   success: function(msg){
               if (msg === 'FAILED') { alert('Patikrink RadioBoss API nustatymus'); return 1; }
		     document.getElementById('eventai').innerHTML=msg;
		   }
		});
	    
	}		
</script>

</body>
</html>