// app.ts
var ClockDisplay = /** @class */ (function () {
    function ClockDisplay() {
        this.timeTemplate = "00:00:00";
        this.clockHandler = 0;
    }

    // getting current time
    ClockDisplay.prototype.getTime = function () {
        var date = new Date();
        return [date.getHours(), date.getMinutes(), date.getSeconds()]
            .map(function (current) { return current >= 10 ? current : "0" + current; }).join(":");
    };

    // starting the clock
    ClockDisplay.prototype.start = function () {
        this.clockHandler = setInterval(function () {
            this.target.innerHTML = this.getTime();
        }.bind(this), 5000);
    };

    // stop method
    ClockDisplay.prototype.stop = function () {
        clearInterval(this.clockHandler);
    };
    
    // binding the clock to specified element
    ClockDisplay.prototype.bindTo = function (elem) {
        this.target = elem;
        this.target.innerHTML = this.timeTemplate;
    };
    return ClockDisplay;
}());
(function (window, document) {
    var clock = new ClockDisplay();
    clock.bindTo(document.getElementById("timeDisplay"));
    clock.start();
}(window, document));
