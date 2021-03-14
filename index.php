<!DOCTYPE html>
<html>

<head>
    <title>Asteroids!</title>
    <style>
        #racingCanvas {
            border: 5px solid black;
            background-color: lightgreen;
        }
    </style>
</head>

<body>
    <h1>Asteroids!</h1>
    <p>by Mr. Rowe 2021</p>
    <canvas id="racingCanvas" width="480" height="320"></canvas>
    <script>
        //VARIABLES
            //Canvas
                var racingCanvas = document.getElementById("racingCanvas");
                var tool = racingCanvas.getContext("2d");
            //Player
                var playerX = 10;
                var playerY = 10;
                var playerR = 10;
                var rightPressed = false;
                var leftPressed = false;
                var upPressed = false;
                var downPressed = false;
                var hit = false;
            //Obstacles
                var obstacleStartX = racingCanvas.width/2;
                var obstacleStartY = racingCanvas.height/2;
                var obstacleStartR = 20;
                var obstacleStartD = 0;
                var obstacleStartN = 10;
                var obstaclesA = [];
                for (i = 0; i < obstacleStartN; i++) {
                    obstaclesA.push([obstacleStartX, obstacleStartY, obstacleStartR, obstacleStartD]);
                }
                var obstaclesGo = 0;
            //Goal
                var win = 0;
                var goalObtained = false;
                var goalStartX = 0;
                var goalStartY = 0;
                var goalStartR = 5;
                var goalStartN = 10;
                var goalA = [];
                for (i = 0; i < goalStartN; i++) {
                    goalStartX = Math.floor(Math.random() * racingCanvas.width);
                    goalStartY = Math.floor(Math.random() * racingCanvas.height);
                    goalA.push([goalStartX, goalStartY, goalObtained]);
                }
            //Score
                var playerScore = 0;
        //MAIN FUNCTION
            function startGame() {
                //clear each frame
                    tool.clearRect(0 , 0 , racingCanvas.width, racingCanvas.height);
                //execute secondary functions
                    goal();    
                    player();
                    obstacles();
                    score();
                    playerControls();
                    obstacleCollission();
                //LOOP
                    requestAnimationFrame(startGame);
            }
        //SECONDARY FUNCTIONS
            //RESTART game
                function restart() {
                    //player variables
                        playerX = 10;
                        playerY = 10;
                        playerR = 10;
                        rightPressed = false;
                        leftPressed = false;
                        upPressed = false;
                        downPressed = false;
                        hit = false;
                    //obstacle variables
                        obstacleStartX = racingCanvas.width/2;
                        obstacleStartY = racingCanvas.height/2;
                        obstacleStartR = 20;
                        obstacleStartD = 0;
                        obstacleStartN = 10;
                        obstaclesA = [];
                        for (i = 0; i < obstacleStartN; i++) {
                            obstaclesA.push([obstacleStartX, obstacleStartY, obstacleStartR, obstacleStartD]);
                        }
                        obstaclesGo = 0;
                    //goal variables
                        goalObtained = false;
                        goalStartX = 0;
                        goalStartY = 0;
                        goalStartR = 5;
                        goalStartN = 10;
                        goalA = [];
                        for (i = 0; i < goalStartN; i++) {
                            goalStartX = Math.floor(Math.random() * racingCanvas.width);
                            goalStartY = Math.floor(Math.random() * racingCanvas.height);
                            goalA.push([goalStartX, goalStartY, goalObtained]);
                        }
                    //score variables
                        playerScore = 0;
                }
            //draw SCORE
                function score() {
                    tool.font = "16px Arial";
                    tool.fillStyle = "#0095DD";
                    tool.fillText("Score: " + playerScore, racingCanvas.width - 100, 20);
                    playerScore++;
                }
            //draw OBSTACLES
                function obstacles() {
                    for (i = 0; i < obstacleStartN; i++) {
                        //draw
                            tool.beginPath();
                            tool.arc(obstaclesA[i][0], obstaclesA[i][1], obstaclesA[i][2], 0, Math.PI*2);
                            tool.fillStyle = "blue";
                            tool.fill();
                            tool.closePath();
                        //move
                            if(obstaclesA[i][3] == 0) {
                                //randomize
                                obstaclesA[i][3] = Math.floor(Math.random() * 8) + 1;
                            }
                            if(obstaclesA[i][3] == 1) {
                                //move up
                                obstaclesA[i][1] = obstaclesA[i][1] - 2;
                            }
                            if(obstaclesA[i][3] == 2) {
                                //move up right
                                obstaclesA[i][0] = obstaclesA[i][0] + 2;
                                obstaclesA[i][1] = obstaclesA[i][1] - 2;
                            }
                            if(obstaclesA[i][3] == 3) {
                                //move right
                                obstaclesA[i][0] = obstaclesA[i][0] + 2;
                            }
                            if(obstaclesA[i][3] == 4) {
                                //move down right
                                obstaclesA[i][0] = obstaclesA[i][0] + 2;
                                obstaclesA[i][1] = obstaclesA[i][1] + 2;
                            }
                            if(obstaclesA[i][3] == 5) {
                                //move down
                                obstaclesA[i][1] = obstaclesA[i][1] + 2;
                            }
                            if(obstaclesA[i][3] == 6) {
                                //move down left
                                obstaclesA[i][0] = obstaclesA[i][0] - 2;
                                obstaclesA[i][1] = obstaclesA[i][1] + 2;
                            }
                            if(obstaclesA[i][3] == 7) {
                                //move left
                                obstaclesA[i][0] = obstaclesA[i][0] - 2;
                            }
                            if(obstaclesA[i][3] == 8) {
                                //move up left
                                obstaclesA[i][0] = obstaclesA[i][0] - 2;
                                obstaclesA[i][1] = obstaclesA[i][1] - 2;
                            }
                    }
                }
            //draw GOAL
                function goal() {
                    for (i = 0; i < goalStartN; i++) {
                        //check if obtained yet
                        if (goalA[i][2] == false) {
                            //draw
                                tool.beginPath();
                                tool.arc(goalA[i][0], goalA[i][1], goalStartR, 0, Math.PI*2);
                                tool.fillStyle = "red";
                                tool.fill();
                                tool.closePath();
                            //check if hit
                                var hit = circleCollission(goalA[i][0], goalA[i][1], goalStartR, playerX, playerY, playerR);
                                if (hit == true) {
                                    goalA[i][2] = true;
                                    win++;
                                    if (win == 10) {
                                        alert("You Won! Your score is: " + playerScore);
                                        restart();
                                        document.location.reload();
                                    }
                                }
                        }
                    }
                }
            //draw PLAYER
                function player() {
                    tool.beginPath();
                    tool.arc(playerX , playerY , playerR , 0, Math.PI*2);
                    tool.fillStyle = "black";
                    tool.fill();
                    tool.closePath();
                }
            //circle Collission
                function circleCollission(x1, y1, r1, x2, y2, r2) {
                    var distance = Math.sqrt(Math.pow(x1 - x2, 2) + Math.pow(y1 - y2, 2));
                    var trueDistance = distance - r1 - r2;
                    if(distance < r2 || distance < r1) {
                        return true;
                    }
                    else {
                        return false;
                    }
                }
            //Obstacle Collision
                function obstacleCollission() {
                    for (i = 0; i < obstacleStartN; i++) {
                        //hit sides
                            //left
                                if(obstaclesA[i][0] < obstaclesA[i][2]) {
                                    obstaclesA[i][3] = Math.floor(Math.random() * 3) + 2;
                                }
                            //right
                                if(obstaclesA[i][0] > racingCanvas.width - obstaclesA[i][2]) {
                                    obstaclesA[i][3] = Math.floor(Math.random() * 3) + 6;
                                }
                            //top
                                if(obstaclesA[i][1] < obstaclesA[i][2]) {
                                    obstaclesA[i][3] = Math.floor(Math.random() * 3) + 4;
                                }
                            //bottom
                                if(obstaclesA[i][1] > racingCanvas.height - obstaclesA[i][2]) {
                                    var randomizer = Math.floor(Math.random() * 3) + 1;
                                    if (randomizer == 1) {
                                        obstaclesA[i][3] = 8;
                                    }
                                    if (randomizer == 2) {
                                        obstaclesA[i][3] = 1;
                                    }
                                    if (randomizer == 3) {
                                        obstaclesA[i][3] = 2;
                                    }
                                }
                        //hit player
                                var hit = circleCollission(obstaclesA[i][0], obstaclesA[i][1], obstacleStartR, playerX, playerY, playerR);
                                if(hit == true) {
                                    alert("Game Over!");
                                    restart();
                                    document.location.reload();
                                }
                    }
                }
            //Player CONTROLS
                function playerControls() {
                    if (rightPressed && playerX < racingCanvas.width - playerR) {
                        playerX += 2;
                    }
                    if (leftPressed && playerX > 0 + playerR) {
                        playerX -= 2;
                    }
                    if (upPressed && playerY > 0 + playerR) {
                        playerY -= 2;
                    }
                    if (downPressed && playerY < racingCanvas.height - playerR) {
                        playerY += 2;
                    }
                }
            //player CONTROLS listener
                document.addEventListener("keydown", keyDownHandler, false);
                document.addEventListener("keyup", keyUpHandler, false);

                function keyDownHandler(e) {
                    if(e.key == "Right" || e.key == "ArrowRight") {
                        rightPressed = true;
                    }
                    else if(e.key == "Left" || e.key == "ArrowLeft") {
                        leftPressed = true;
                    }
                    else if(e.key == "Up" || e.key == "ArrowUp") {
                        upPressed = true;
                    }
                    else if(e.key == "Down" || e.key == "ArrowDown") {
                        downPressed = true;
                    }
                }

                function keyUpHandler(e) {
                    if(e.key == "Right" || e.key == "ArrowRight") {
                        rightPressed = false;
                    }
                    else if(e.key == "Left" || e.key == "ArrowLeft") {
                        leftPressed = false;
                    }
                    else if(e.key == "Up" || e.key == "ArrowUp") {
                        upPressed = false;
                    }
                    else if(e.key == "Down" || e.key == "ArrowDown") {
                        downPressed = false;
                    }
                }
        //START GAME
            startGame();
    </script>
</body>

</html>
