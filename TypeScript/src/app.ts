// app.ts

interface iCounter {
    setIntervalValue(time:number):any;
    start():any;
    stop():any;
}

class ClockDisplay implements iCounter {
    timeTemplate: string = "00:00:00";
    clockHandler: number;
    target: HTMLElement;

    setIntervalValue(time:number) {
        let interval = time;
    }

    // getting current time
    getTime() {
        var date = new Date();
        return [date.getHours(), date.getMinutes(), date.getSeconds()]
            .map(current => current >= 10 ? current : "0" + current).join(":");
    }

    // starting the clock
    start(): void {
        this.clockHandler = setInterval(function (this: any) {
            this.target.innerHTML = this.getTime();
        }.bind(this), 5000);
    }

    // stop method
    stop(): void {
        clearInterval(this.clockHandler);
    }

    // binding the clock to specified element
    bindTo(elem:any): void {
        this.target = elem;
        this.target.innerHTML = this.timeTemplate;
    }
}

(function (window, document) {
    var clock = new ClockDisplay();

    clock.bindTo(document.getElementById("timeDisplay"));
    clock.start();
} (window, document));
