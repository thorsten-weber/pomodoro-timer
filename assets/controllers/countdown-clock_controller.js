import { Controller } from '@hotwired/stimulus';
import moment from 'moment';
import timer from 'moment-timer';

/*
 * This is Pomodoro / Toto Tomato Timer - Stimulus controller!
 *
 * This will control the timer with the variables provided
 * by the Symfony backend.
 *
 */
export default class extends Controller {

    static values = {
        pomodoroInMinutes: {type: Number, default: 1},
        refreshInterval: {type: Number, default: 1000},
        pausedTimer: {type: Number, default: 0},
        pomodoroCycles: {type: Number, default: 0},
        pomodoroCyclesToLongBreak: {type: Number, default: 0},
        pomodoroShortBreak: {type: Number, default: 0},
        pomodoroLongBreak: {type: Number, default: 0},
    }

    static targets = [
        'timerDisplay',
        'countdownStartButton',
        'countdownStopButton',
        'countdownResetButton'
    ];

    // TODO: remove when finished
    // wording:
    // duration = time span
    // interval = length of repetetive duration
    // pomodoroCountdown actual Countdown
    // shortBreakCountdown actual Countdown
    // longBreakCountdown: actual Countdown
    // pomodoroDuration default = 25min
    // shortBreakDuration default = 5min
    // longBreakDuration default = 15min
    // totalCycles default = 1
    // cyclesToLongBreak default = 2

    /**
     * Setup pomodoro duration in seconds
     * @param pomodoroDuration
     */
    setPomodoroDurationTimeInSeconds(pomodoroDuration) {
        this.duration = pomodoroDuration * 60;
    }

    /**
     *
     * @param pomodoroShortBreak
     */
    setPomodoroShortBreakTimeInSeconds(pomodoroShortBreak) {
        this.shortBreakInSeconds = pomodoroShortBreak * 60;
    }

    /**
     *
     * @param pomodoroLongBreak
     */
    setPomodoroLongBreakTimeInSeconds(pomodoroLongBreak) {
        this.longBreakInSeconds = pomodoroLongBreak * 60;
    }

    /**
     * Set(up) all provided values as seconds
     */
    setupPomodoroValues() {
        this.totalCycles = this.pomodoroCyclesValue;
        this.cyclesToLongBreak = this.pomodoroCyclesToLongBreakValue;
        this.currentCycle = 0;
        this.setPomodoroDurationTimeInSeconds(this.pomodoroInMinutesValue);
        this.setPomodoroShortBreakTimeInSeconds(this.pomodoroShortBreakValue);
        this.setPomodoroLongBreakTimeInSeconds(this.pomodoroLongBreakValue);
    }

    setStartTime() {
        this.setPomodoroDurationTimeInSeconds(this.pomodoroInMinutesValue);
    }

    /**
     * Invoked with initial load of the timer component
     */
    connect() {
        console.log(this.pomodoroCyclesValue, this.pomodoroCyclesToLongBreakValue, this.pomodoroShortBreakValue,  this.pomodoroLongBreakValue );
        this.setupPomodoroValues();
        // this.setStartTime();
        console.log(this.duration, this.shortBreakInSeconds, this.longBreakInSeconds);
        this.setTimerDisplayTime();
        this.toggleControlButtonOff(this.countdownStopButtonTarget);
        this.toggleControlButtonOff(this.countdownResetButtonTarget);
    }

    /**
     * startAction, triggered by start button
     */
    start() {

        if (0 < this.pausedTimerValue) {
            this.duration = this.pausedTimerValue;
            this.resetPausedTimerValue();
        }
        else{
            this.setStartTime();
        }

        this.startTimer();

        this.toggleControlButtonOff(this.countdownStartButtonTarget);
        this.toggleControlButtonOn(this.countdownStopButtonTarget);
        this.toggleControlButtonOn(this.countdownResetButtonTarget);

    }

    /**
     * stopAction, triggered by stop button
     */
    stop() {
        this.stopTimer();
        this.pausedTimerValue = this.duration;

        this.toggleControlButtonOn(this.countdownStartButtonTarget);
        this.toggleControlButtonOff(this.countdownStopButtonTarget);
        this.toggleControlButtonOn(this.countdownResetButtonTarget);

        // is this really necessary?
        this.disconnect();
    }

    /**
     * resetAction, triggered by reset button
     */
    reset() {
        this.stopTimer();
        this.resetTimers();
        this.setTimerDisplayTime();

        this.toggleControlButtonOn(this.countdownStartButtonTarget);
        this.toggleControlButtonOff(this.countdownStopButtonTarget);
        this.toggleControlButtonOff(this.countdownResetButtonTarget);
    }

    startTimer() {
        this.refreshTimer = moment
            .duration(this.refreshIntervalValue)
            .timer(
                {
                    loop: true
                },
                () => {
                    this.updateCountdown();
                }
            );
        this.refreshTimer.start();

        // this.refreshTimer = setInterval(() => {
        //     this.updateCountdown();
        // }, this.refreshIntervalValue);
    }

    updateCountdown() {
        // this.duration will be set initially with setStartTime()
        if (this.duration >= 0) {
            this.setTimerDisplayTime();
            this.duration--;
        } else {
            this.stopTimer();
            this.playAlarmSound();
            // this.endOfCycle();
        }
    }

    stopTimer() {
        if (this.refreshTimer) {
            this.refreshTimer.stop();

            // clearInterval(this.refreshTimer);
        }
    }

    resetTimers() {
        this.setStartTime();
        this.resetPausedTimerValue();
    }

    resetPausedTimerValue() {
        this.pausedTimerValue = 0;
    }

    /**
     * Write values to frontend
     */
    setTimerDisplayTime() {
        const minutes = Math.floor(this.duration / 60);
        let seconds = this.duration % 60;

        seconds = seconds < 10 ? '0' + seconds : seconds;

        this.timerDisplayTarget.innerHTML = `${minutes} : ${seconds}`;
    }

    toggleControlButton(controlButton) {
        if (true === controlButton.disabled) {
            controlButton.disabled = false;
            return;
        }
        controlButton.disabled = true;
    }

    /**
     * Enable Button
     * @param controlButton
     */
    toggleControlButtonOn(controlButton) {
        if (true !== controlButton.disabled) {
            return;
        }
        controlButton.disabled = false;
    }

    /**
     * Disable Button
     * @param controlButton
     */
    toggleControlButtonOff(controlButton) {
        if (true === controlButton.disabled) {
            return;
        }
        controlButton.disabled = true;
    }


    // TODO: get sound per api call
    playAlarmSound() {
        this.alarmSound = new Audio("https://cdn.freesound.org/previews/198/198841_285997-hq.mp3");
        this.alarmSound.play();
    }
}
