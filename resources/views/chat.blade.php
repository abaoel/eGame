
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chat Here</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        canvas {
            border:1px solid #d3d3d3;
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

    <div class="float-left  p-6 " style="width:50%;height">
        <header>

            <div class="float-left  p-6 "  id="game_container" style="position: absolute;">
                <div id="canvas_container"></div>
                <button onmousedown="accelerate(-0.2)" onmouseup="accelerate(0.05)" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">{{ __('ACCELERATE') }}</button>
                <p>{{ __('Use the Accelerate button to stay in the air.') }}</p>
                <p>{{ __('Avoid hitting the wall.') }}</p>
                <p>{{ __('You will be the winner if you reach 2 minutes!') }}</p>
                </br>
                
                {{ __('Score:') }}<p id="scoretxt">0</p>
                {{ __('Energy:') }}<p id="energytxt">100</p>
                <progress value="100" max="100" id="progressBar"></progress>
                </br>
                {{ __('Game ends in') }} <span id="timer">09:00<span> minutes!
                
            </div> 

            <h1 id="page_title">{{ __('Welcome To Game 1') }}</h1>
            <input type="text" name="username" id="username" placeholder="{{ __('Please enter your name') }}" class="bg-gray-100 border-2 w-full p-4 rounded-lg"/>
            <input type="hidden" id="gamestarted"  value="{{ Session::get("gamestarted") }}">
            <input type="hidden" id="numberofusers" value="{{ count($users) }}">
            <input type="hidden" id="userid"  value="{{ \Auth::id()  }}">
            <input type="hidden" id="percentageval"  value="100">
            
            
        </header>
        
        <form action="" id="message_form">
           
            <button type="submit" id="message_send" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">{{ __('Join Game') }}</button>
        </form>

        <form action="" id="start_game_form" style="visibility: hidden;">
            <h4 id="wait_msg">{{ __('Please wait for others to join...') }}</h4>
            <button type="submit" id="start_game_btn" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">{{ __('Start Game') }}</button>
           
        </form>
    </div>

    <div class="float-right bg-white p-6 rounded-lg" style="margin: 10px;">
        <h1><strong>{{ __('Players Online') }}</strong></h1>
        <div id="messages">
        @foreach ($users as $user)
            <div id="divuser{{  $user->id }}">{{ $user->alias }} SCORE:0</div>
        @endforeach
        </div>
    </div>
        
    
    
    <script src = "./js/app.js"></script>
    <script>

        var myGamePiece;
        var myObstacles = [];
        var totalenergy = 100;
        var gameInterval;
        var timerInterval;
        var minute = 1;
        var sec = 60;

        //var myScore;
        
        function startGame() {
            myGamePiece = new component(30, 30, "blue", 10, 120);
            myGamePiece.gravity = 0.05;
            //myScore = new component("30px", "Consolas", "black", 280, 40, "text");
            myGameArea.start();

            timerInterval = setInterval(updateTime, 1000);

            function updateTime()
            {
                document.getElementById("timer").innerHTML =
                  minute + " : " + sec;
               sec--;
               if (sec == 00 && minute >= 0) {
                  minute--;
                  sec = 60;
                  
               }
            }
           
           
        }
        
        var myGameArea = {
            canvas : document.createElement("canvas"),
            start : function() {
                this.canvas.id = "gamecanvas";
                this.canvas.width = 480;
                this.canvas.height = 270;
                this.context = this.canvas.getContext("2d");
                document.getElementById("canvas_container").appendChild(this.canvas);
                //document.body.insertBefore(this.canvas, document.body.childNodes[0]);
                this.frameNo = 0;
                //this.interval = setInterval(updateGameArea, 20);
                gameInterval = setInterval(updateGameArea, 20);
                },
            clear : function() {
                this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
            }
        }
        
        function component(width, height, color, x, y, type) {
            this.type = type;
            this.score = 0;
            this.width = width;
            this.height = height;
            this.speedX = 0;
            this.speedY = 0;    
            this.x = x;
            this.y = y;
            this.gravity = 0;
            this.gravitySpeed = 0;
            this.update = function() {
                ctx = myGameArea.context;
                if (this.type == "text") {
                    ctx.font = this.width + " " + this.height;
                    ctx.fillStyle = color;
                    ctx.fillText(this.text, this.x, this.y);
                } else {
                    ctx.fillStyle = color;
                    ctx.fillRect(this.x, this.y, this.width, this.height);
                }
            }
            this.newPos = function() {
                this.gravitySpeed += this.gravity;
                this.x += this.speedX;
                this.y += this.speedY + this.gravitySpeed;
                this.hitBottom();
            }
            this.hitBottom = function() {
                var rockbottom = myGameArea.canvas.height - this.height;
                if (this.y > rockbottom) {
                    this.y = rockbottom;
                    this.gravitySpeed = 0;
                }
            }
            this.crashWith = function(otherobj) {
                
                var myleft = this.x;
                var myright = this.x + (this.width);
                var mytop = this.y;
                var mybottom = this.y + (this.height);
                var otherleft = otherobj.x;
                var otherright = otherobj.x + (otherobj.width);
                var othertop = otherobj.y;
                var otherbottom = otherobj.y + (otherobj.height);
                var crash = true;
                if ((mybottom < othertop) || (mytop > otherbottom) || (myright < otherleft) || (myleft > otherright)) {
                    crash = false;
                }
                return crash;
            }
        }
        
        var iscrashed = false;
        var curMSeconds = 0;
        function updateGameArea() 
        {
            if( minute < 0)
            {
                document.getElementById("timer").innerHTML = "00:00 ";

                clearInterval(gameInterval);
                clearInterval(timerInterval);
                

                const options = {
                    method: 'post',
                    url:'/posts/score',
                    data: {
                        userid: userid,
                        score: "SCORE: " + myGameArea.frameNo,
                        iswinner: 1
                        
                        
                    }
                }


                axios(options);

                if (confirm(`{{ __('Great Job! You Won! Yo you want to try again?') }}`)) 
                {
                    const options = {
                        method: 'post',
                        url:'/posts/score',
                        data: {
                            userid: userid,
                            score: "SCORE: 0",
                            iswinner: 0
                            
                            
                        }
                    }


                    axios(options);
                    location.reload();
                } 
                
                
                
            }

            curMSeconds = curMSeconds + 20;
            if(curMSeconds >= 5000 && totalenergy <= 100){
                curMSeconds = 0;
                totalenergy = totalenergy + 1;
                document.getElementById("percentageval").value = totalenergy;
            }

            var x, height, gap, minHeight, maxHeight, minGap, maxGap;
            for (i = 0; i < myObstacles.length; i += 1) 
            {
                if (myGamePiece.crashWith(myObstacles[i])) 
                {
                    
                    if(!iscrashed)
                    {
                        
                        iscrashed = true;
                        totalenergy = totalenergy - 25;
                        
                        document.getElementById("energytxt").innerHTML = totalenergy;
                        document.getElementById("percentageval").value = totalenergy;
                        document.getElementById("progressBar").value = totalenergy;
                       
                        if(totalenergy <= 0)
                        {
                            clearInterval(gameInterval);
                            clearInterval(timerInterval);

                            document.getElementById("energytxt").innerHTML = "0";
                            document.getElementById("percentageval").value = 0;
                            document.getElementById("progressBar").value = 0;

                            const options = {
                                method: 'post',
                                url:'/posts/score',
                                data: {
                                    userid: userid,
                                    score: "SCORE: 0"
                                    
                                    
                                }
                            }


                            axios(options);

                            
                            if (confirm(`{{ __('Sorry you lose, do you want to try again?') }}`)) 
                            {
                                const options = {
                                    method: 'post',
                                    url:'/posts/score',
                                    data: {
                                        userid: userid,
                                        score: "SCORE: 0",
                                        iswinner: 0
                                        
                                        
                                    }
                                }


                                axios(options);
                                location.reload();
                            } 
                            

                            
                        }

                        

                        setTimeout(function(){ iscrashed = false; }, 3000);
                    }
                  
                } 

                
            }

            myGameArea.clear();
            myGameArea.frameNo += 1;
            if (myGameArea.frameNo == 1 || everyinterval(150)) {
                x = myGameArea.canvas.width;
                minHeight = 20;
                maxHeight = 200;
                height = Math.floor(Math.random()*(maxHeight-minHeight+1)+minHeight);
                minGap = 50;
                maxGap = 200;
                gap = Math.floor(Math.random()*(maxGap-minGap+1)+minGap);
                myObstacles.push(new component(10, height, "green", x, 0));
                myObstacles.push(new component(10, x - height - gap, "green", x, height + gap));
            }
            for (i = 0; i < myObstacles.length; i += 1) {
                myObstacles[i].x += -1;
                myObstacles[i].update();
            }
            //myScore.text="SCORE: " + myGameArea.frameNo;
            //myScore.update();
            myGamePiece.newPos();
            myGamePiece.update();
        }
        
        function everyinterval(n) {
            if ((myGameArea.frameNo / n) % 1 == 0) {return true;}
            return false;
        }
        
        function accelerate(n) 
        {
            myGamePiece.gravity = n;
            
            if(totalenergy > 0 && myGameArea.frameNo <= 2100)
            {
                const options = {
                    method: 'post',
                    url:'/posts/score',
                    data: {
                        userid: userid,
                        score: "SCORE: " + myGameArea.frameNo,
                        iswinner: 0
                        
                        
                    }
                }


                axios(options);
            }
            
            
        }
        </script>
  
 
</body>
</html>