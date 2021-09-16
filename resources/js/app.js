
const { default: axios } = require('axios');

require('./bootstrap');

   
    var message_form = document.getElementById("message_form");
    var start_game_form = document.getElementById("start_game_form");
    var message_el = document.getElementById("messages");
    var username_input = document.getElementById("username");
    var gamestarted = document.getElementById('gamestarted').value;
    var numberofusers = document.getElementById('numberofusers').value;
    var userid = document.getElementById('userid').value;
    

    document.getElementById("game_container").style.visibility = "hidden";

    

    if(gamestarted == '1')
    {

     
        username_input.style.visibility = "hidden";
        document.getElementById("start_game_form").style.visibility = "visible";
        document.getElementById("start_game_btn").disabled = true;
        document.getElementById("start_game_btn").style.color = "white";
        document.getElementById("message_form").remove();
       

    }

    if(parseInt(numberofusers) > 1)
    {
        document.getElementById("start_game_btn").disabled = false;
        document.getElementById("start_game_btn").style.color = "white";
        document.getElementById("wait_msg").remove();
    }
    
    start_game_form.addEventListener('submit', function (e)
    {
        
        

        e.preventDefault();

        const options = {
            method: 'post',
            url:'/posts/startgame',
            data: {
                username: "startgame",
                message: 1
                
            }
        }


        axios(options);

        

    });
    
    message_form.addEventListener('submit', function (e)
    {
        
        

        e.preventDefault();
       
        let has_errors = false;

        if(username_input.value == '')
        {
            alert("Please enter your name!");
            has_errors = true;
            
        }

        if(has_errors)
        {
            return;
        }

        
        if(gamestarted != '1')
        {
    
         
            username_input.style.visibility = "hidden";
            document.getElementById("start_game_form").style.visibility = "visible";
            document.getElementById("start_game_btn").disabled = true;
            document.getElementById("start_game_btn").style.color = "gray";
            document.getElementById("message_form").remove();
           
    
        }
       


        const options = {
            method: 'post',
            url:'/posts/game',
            data: {
                username: username_input.value,
                message: 1
                
            }
        }


        axios(options);
    });




window.Echo.channel('chat').listen('.message', (e) => 
{
    
   
    if(e.username == "users")
    {
        var result = JSON.parse(e.message);

        message_el.innerHTML = "";

        if(result.length > 1)
        {
            document.getElementById("start_game_btn").disabled = false;
            document.getElementById("start_game_btn").style.color = "white";
            document.getElementById("wait_msg").remove();
        }
        
        for(var i = 0; i < result.length; i++)
        {
        
            message_el.innerHTML += '<div id = "divuser'+result[i].id+'">'+result[i].alias+' SCORE:0 </div>';
        }
    }

    if(e.username == "startgame")
    {
        if(!document.getElementById("gamecanvas"))
        {
            document.getElementById("start_game_form").style.visibility = "hidden";
            document.getElementById("page_title").style.visibility = "hidden";
            document.getElementById("game_container").style.visibility = "visible";
        
            startGame();
        }

        
    }

    if(e.username == "gamescore" && parseInt(document.getElementById("percentageval").value) > 0)
    {
        var result = JSON.parse(e.message);
        
       

        if(document.getElementById("divuser"+result.userid))
        {
           var curStr = document.getElementById("divuser"+result.userid).innerHTML;
           curStr = curStr.substring(0, curStr.lastIndexOf(':') + 1);
           var res = (result.score).replace(/\D/g, "");
           document.getElementById("divuser"+result.userid).innerHTML = curStr+res+' '+result.winner;

            
                
        }

        if(result.userid == userid)
        {
            document.getElementById("scoretxt").innerHTML = res;
        }


        
    }

   
    

   

});
