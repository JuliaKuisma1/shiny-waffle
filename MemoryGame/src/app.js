// app.js

console.log('app starting...');

var CONST = {
    BOARD_SIZE: 20,
    CARDS_PER_ROW: 4,
    CARD_INVISIBLE: "text-primary oi oi-aperture",
    CARD_PAIR_FOUND: "oi oi-check text-success",
    CARD_PAIRS: 0,

    GAME_STATE_NO_TURNED_CARD: 0,
    GAME_STATE_ONE_TURNED_CARD: 1,
    GAME_STATE_TWO_TURNED_CARD: 2,
    GAME_STATE_GAME_OVER: 3,

    CARD_STATE_IN_GAME: 0,
    CARD_STATE_GAME_OVER: 1,

    TURN_INVISIBLE_DELAY: 800
};

var MemoryCard = function(id, gameController)
{
    var that = this;
    this.id = id;
    this.iconClass = "";
    this.gameController = gameController;
    this.state = CONST.CARD_STATE_IN_GAME;

    this.onClickHandler = function(e)
    {
        var id = that.id.substr(5);
        console.log("clicked:"+that.id);
        if (that.state == CONST.CARD_STATE_IN_GAME)
        {
            that.gameController.turnCard(id);
        }
        else
        {
            console.log("Card "+that.id+" is no longer playable!");
        }
    }

    this.turnVisible = function()
    {
        var id = this.id.substr(5);
        //document.getElementById("span-"+id).className = this.iconClass;
        document.getElementById("span-"+id).className += " animated flipOutX";
        document.getElementById("span-"+id).className = this.iconClass+" animated flipInX";
    }

    this.turnInvisible = function()
    {
        var id = this.id.substr(5);
        //document.getElementById("span-"+id).className = CONST.CARD_INVISIBLE;
        document.getElementById("span-"+id).className += " animated flipOutX";
        document.getElementById("span-"+id).className = CONST.CARD_INVISIBLE+" animated flipInX";
    }
    this.turnGameOver = function()
    {
        var id = this.id.substr(5);
        document.getElementById("span-"+id).className = CONST.CARD_PAIR_FOUND;
        this.setCardState(CONST.CARD_STATE_GAME_OVER);
    }

    this.getIconClass = function()
    {
        return this.iconClass;
    }

    this.setIconClass = function(icon)
    {
        this.iconClass = icon;
    }

    this.setCardState = function(state)
    {
        this.state = state;
    }
}
var MemoryGame = function(size, cardsPerRow) 
{
    var that = this;
    this.nbrOfCards = size;
    this.cardsPerRow = cardsPerRow;
    this.state = CONST.GAME_STATE_NO_TURNED_CARD;
    this.counter = 0;
    this.firstCard = -1;
    this.secondCard = -1;
    this.startTime = -1;
    this.playTime = 0;
    this.cards = [];

    this.width = 0;
    this.ariavaluenow = 0;

    this.initialize = function() {
        this.createDivs();
        this.setEventListeners();
        this.setIconClassToCards();
    }

    this.getNextUninitializedIconClassIndex = function(x)
    {
        var i;
        for(i=0;i<this.nbrOfCards;i++)
        {
            if (this.cards[(x + i) % this.nbrOfCards].getIconClass() == "")
            {
                return (x+i) % this.nbrOfCards;
            }
        }
        return 0; // should never reach here
    }

    this.setIconClassToCards = function()
    {
        var i;
        var icon;
        var x, y;

        for(i=0;i<this.nbrOfCards/2;i++)
        {
            icon = Math.floor(Math.random() * ICONNAMES.length);
            x = Math.floor(Math.random() * this.nbrOfCards);
            y = Math.floor(Math.random() * this.nbrOfCards);

            x = this.getNextUninitializedIconClassIndex(x);
            this.cards[x].setIconClass(ICONNAMES[icon]);

            y = this.getNextUninitializedIconClassIndex(y);            
            this.cards[y].setIconClass(ICONNAMES[icon]);

            console.log("Icon "+ICONNAMES[icon]+" set to "+x+" and "+y);
        }
    }

    this.setEventListeners = function()
    {
        var i;
        var cardId = "";

        for(i=0;i<this.nbrOfCards;i++)
        {
            cardId = "card-"+i;
            this.cards[i] = new MemoryCard(cardId, this);
            document.getElementById(cardId).addEventListener("click", this.cards[i].onClickHandler);
        }
    }

    this.createRow = function(id)
    {
        var divRow;
        divRow = document.createElement("div");
        divRow.id = "row-"+id;
        divRow.className = "row";
        return divRow;
    }

    this.createCard = function (id)
    {
        var divCard;
        divCard = document.createElement("div");
        divCard.id = "card-"+id;
        divCard.className = "col-sm card";
        return divCard;
    }

    this.createCardBody = function ()
    {
        var divCardBody;
        divCardBody = document.createElement("div");
        divCardBody.className = "card-body";
        return divCardBody;
    }

    this.createIcon = function(id)
    {
        var iconSpan;
        iconSpan = document.createElement("span");
        iconSpan.id = "span-"+id;
        iconSpan.className = CONST.CARD_INVISIBLE;
        return iconSpan;
    }

    this.createDivs = function() 
    {
        var i, j;
        var cardId = 0;

        var rowElement;
        var cardElement;
        var cardBodyElement;
        var iconElement;

        for (i = 0; i < this.nbrOfCards / this.cardsPerRow; i++)
        {
            rowElement = this.createRow(i);
            for (j = 0; j < this.cardsPerRow; j++)
            {
                cardId = (j + (i * this.cardsPerRow));
                cardElement = this.createCard(cardId);
                cardBodyElement = this.createCardBody();
                iconElement = this.createIcon(cardId);

                cardBodyElement.appendChild(iconElement);
                cardElement.appendChild(cardBodyElement);
                rowElement.appendChild(cardElement);
            }
            document.getElementById("game-content").appendChild(rowElement);
        }
    }

    this.gameCheck = function()
    {
        if (CONST.CARD_PAIRS == (CONST.BOARD_SIZE/2))
        {
            this.finishTime = Math.floor(this.playTime / 1000);
            myStopFunction();
            
        }
    }

    this.setPlayTime = function()
    {
        if (this.state == CONST.GAME_STATE_GAME_OVER)
        {
            return;
        }
        this.playTime = new Date().getTime() - this.startTime;
    }

    this.turnCard = function(id)
    {
        console.log("turnCard: "+id);
        console.log(this.counter);

        // setting starting time
        if (this.startTime == -1)
        {
            this.startTime = new Date().getTime();
        }
        else if (this.startTime > 0)
        {
            this.setPlayTime();
        }

        // if there is no card turned
        if(this.state == CONST.GAME_STATE_NO_TURNED_CARD)
        {
            this.cards[id].turnVisible();
            this.firstCard = id;
            this.state = CONST.GAME_STATE_ONE_TURNED_CARD;
        }

        // one card turned
        else if(this.state == CONST.GAME_STATE_ONE_TURNED_CARD)
        {
            // if clicked same card
            if (id == this.firstCard) return;
            
            this.cards[id].turnVisible();
            this.secondCard = id;
            this.state = CONST.GAME_STATE_TWO_TURNED_CARD;
            this.counter++;
            document.getElementById("turn-count").innerHTML = "Turns: "+this.counter;

            // are cards matching?
            if (this.cards[this.firstCard].getIconClass() ==
            this.cards[this.secondCard].getIconClass()) 
            {
                
                setTimeout(function()
                {
                    that.cards[that.firstCard].turnGameOver();
                    that.cards[that.secondCard].turnGameOver();
                    that.state = CONST.GAME_STATE_NO_TURNED_CARD;
                }
                    ,CONST.TURN_INVISIBLE_DELAY);

                // counting found pairs
                CONST.CARD_PAIRS++;
                setTimeout(this.gameCheck, 1000);
                progress();
                
                // progress bar function
                function progress()
                {
                    var bar = document.getElementById("progress-bar");

                    //that.ariavaluenow = that.ariavaluenow+25;
                    that.width = that.width+(200/CONST.BOARD_SIZE);

                    bar.style.width = that.width + '%'; 
                    bar.innerHTML = that.width * 1 + '%';
                    //bar.style.ariavaluenow = that.ariavaluenow;
                    //bar.innerHTML = that.ariavaluenow;
                }
                //document.getElementById("progress-bar").aria-valuenow = 10;
            }

            else // no match
            {
                setTimeout(function()
                {
                    that.cards[that.firstCard].turnInvisible();
                    that.cards[that.secondCard].turnInvisible();
                    that.state = CONST.GAME_STATE_NO_TURNED_CARD;
                }
                    ,CONST.TURN_INVISIBLE_DELAY);
            }
        }

        else if(this.state == CONST.GAME_STATE_GAME_OVER)
        {
           
        }
        
    }
}

var memoryGame = new MemoryGame(CONST.BOARD_SIZE, CONST.CARDS_PER_ROW);
var playTimeElement = document.getElementById("play-time");
memoryGame.initialize();

var myVar = setInterval(setTime, 1000);

function setTime()
{
    memoryGame.setPlayTime();
    if (memoryGame.startTime < 0)
    {
        playTimeElement.innerHTML = "Playtime: 0 s";
    }
    else
    {
        playTimeElement.innerHTML = "Playtime: "+Math.floor(memoryGame.playTime / 1000)+" s";
    }
}

// function to stop interval and alert user
function myStopFunction()
{
    clearInterval(myVar);
    alert("You win!\nYour time: "+Math.floor(memoryGame.playTime / 1000)+
    " s\nYour turns: "+memoryGame.counter);
    // displaying your time (time doesn't go on)
    playTimeElement.innerHTML = "Playtime: "+Math.floor(memoryGame.playTime / 1000)+" s";
}
