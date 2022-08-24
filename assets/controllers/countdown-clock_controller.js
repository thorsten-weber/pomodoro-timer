import { Controller } from '@hotwired/stimulus';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {

    static values = {
        pomodoroInMinutes: {type: Number, default: 1},
        refreshInterval: {type: Number, default: 1000},
        pausedTimer: {type: Number, default: 0},
    }

    static targets = [
        'timerDisplay',
        'countdownStartButton',
        'countdownStopButton',
        'countdownResetButton'
    ];

    connect() {
        this.setStartTime();
        this.setTimerDisplayTime();
        this.toggleControlButtonOff(this.countdownStopButtonTarget);
        this.toggleControlButtonOff(this.countdownResetButtonTarget);
    }

    start() {

        if (0 < this.pausedTimerValue) {
            this.time = this.pausedTimerValue;
            this.resetPausedTimerValue();
        }
        else{
            this.setStartTime();
        }

        this.refreshTimer = setInterval(() => {
            this.updateCountdown();
        }, this.refreshIntervalValue);

        this.toggleControlButtonOff(this.countdownStartButtonTarget);
        this.toggleControlButtonOn(this.countdownStopButtonTarget);
        this.toggleControlButtonOn(this.countdownResetButtonTarget);

    }

    updateCountdown() {
        if (this.time >= 0) {
            this.setTimerDisplayTime();
            this.time--;
        } else {
            this.playAlarmSound();
            this.reset();
        }
    }

    stop() {
        this.stopTimer();
        this.pausedTimerValue = this.time;

        this.toggleControlButtonOn(this.countdownStartButtonTarget);
        this.toggleControlButtonOff(this.countdownStopButtonTarget);
        this.toggleControlButtonOn(this.countdownResetButtonTarget);

        // is this really necessary?
        this.disconnect();
    }

    stopTimer() {
        if (this.refreshTimer) {
           clearInterval(this.refreshTimer);
        }
    }

    reset() {
        this.stopTimer();
        this.resetTimers();
        this.setTimerDisplayTime();

        this.toggleControlButtonOn(this.countdownStartButtonTarget);
        this.toggleControlButtonOff(this.countdownStopButtonTarget);
        this.toggleControlButtonOff(this.countdownResetButtonTarget);
    }

    setTimerDisplayTime() {
        const minutes = Math.floor(this.time / 60);
        let seconds = this.time % 60;

        seconds = seconds < 10 ? '0' + seconds : seconds;

        this.timerDisplayTarget.innerHTML = `${minutes} : ${seconds}`;
    }

    setStartTime() {
        this.time = this.pomodoroInMinutesValue * 60;
    }

    toggleControlButton(controlButton) {
        if (true === controlButton.disabled) {
            controlButton.disabled = false;
            return;
        }
        controlButton.disabled = true;
    }

    toggleControlButtonOn(controlButton) {
        if (true !== controlButton.disabled) {
            return;
        }
        controlButton.disabled = false;
    }

    toggleControlButtonOff(controlButton) {
        if (true === controlButton.disabled) {
            return;
        }
        controlButton.disabled = true;
    }

    resetTimers() {
        this.setStartTime();
        this.resetPausedTimerValue();
    }

    resetPausedTimerValue() {
        this.pausedTimerValue = 0;
    }

    playAlarmSound() {
        this.alarmSound = new Audio("https://cdn.freesound.org/previews/198/198841_285997-hq.mp3");
        this.alarmSound.play();
    }
}
