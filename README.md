# pomodoro-timer

A pomodoro-timer webapp based on symfony 6.

This project is work in progress

### TODOs are as follows

#### timer / countdown
* Form
  * fields
    * Pomodoro / Iteration duration
    * short break duration
    * long break duration
    * estimated pomodoros / iterations
* Start / Stop | Reset | Skip Button
* clock / countdown
* clock / time in title 
* nice to have
  * Background music (deezer / spotify )
  * estimated finish time (hh:mm)


#### tasks / todos
* Add Button
  * Form
    * fields
      * title 
      * project 
      * description 
      * estimated pomodoros / iterations 
  * summary
    * Estimations / Iterations
    * actual / current
    * estimated finish time (hh:mm)


#### Todos - Entities / Models

* Project
  * relations
    * has 1 user
    * has 0 to many tasks
  * id
  * title
  * description
  * creation_date
  * user

* Task / Todo
  * relations
    * has 1 user
    * has 1 project
    * has 1 pomodoro
  * creation date
  * title
  * description
  * has subtasks (optional)
  * is subtask (optional)
  * 

* Pomodoros
  * relations
    * has 0 or many user
    * has 0 or many tasks
  * time (default 25min)
  * short break (default 5min)
  * long break (default 25min)
  * cycles 

* user
  * relations
    * has 0 or many projects
    * has 0 or many tasks
    * has 0 or many pomodoros
  * id
  * name
  * session_id
  * password
  * creation_date