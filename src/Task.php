<?php



class Task
{
    private $description;
    private $id;


    //create constructor with a default id value of null
    function __construct($description, $id = null)
    {
        $this->description = $description;
        $this->id = $id;
    }

    function getId()
    {
        return $this->id;
    }

    function setId($new_id)
    {
        $this->id = (int) $new_id;
    }

    function setDescription($new_description)
    {
        $this->description = (string) $new_description;
    }

    function getDescription()
    {
        return $this->description;
    }

    function save()
    {
        //save the task's description into the column named description in the tasks table of the to_do(_test) database
        //return the id that corresponds to to the row that we input the description
        $statement = $GLOBALS['DB']->query("INSERT INTO tasks (description) VALUES ('{$this->getDescription()}') RETURNING id;");
        //set a new variable equal to an associative array containing the id
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        //set the class's id property equal to the value in the associative array
        $this->setId($result['id']);
    }

    static function getAll()
    {
        //get all the columns and rows from table tasks and store them in
        //and associative array called $returned_tasks
        $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks;");
        //create and empty array to store our task object
        $tasks = array();
        //loop through each row in the tasks table
        foreach ($returned_tasks as $task) {
            //store the value at the description key from the current row
            //in the associative array
            $description = $task['description'];
            //do the same for id
            $id = $task['id'];
            //make a new Task object with the data from the database
            $new_task = new Task($description, $id);
            //save that object into our array to return
            array_push($tasks, $new_task);

        }
        return $tasks;
    }





    static function deleteAll()
    {
        //delete all data from database
        $GLOBALS['DB']->exec("DELETE FROM tasks *;");
    }

    static function find($search_id)
    {
        //set a variable equal to null
        $found_task = null;
        //set a variavle equal to the array created in getAll
        $tasks = Task::getAll();
        //loop through our new array and if it is equal to what we're searching for,
        //set it equal to our new variable $found_task.
        foreach($tasks as $task)
        {
            $task_id = $task->getId();
            if($task_id == $search_id) {
                $found_task = $task;
            }
        }
        return $found_task;
    }
}
?>
