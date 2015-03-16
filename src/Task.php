<?php



class Task
{
    private $description;
    private $id;

    function __construct($description, $id)
    {
        $this->description = $description;
        if($id !== null) {
            $this->id = $id;
        }
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
        $GLOBALS['DB']->exec("INSERT INTO tasks (description) VALUES ('{$this->getDescription()}');");
    }

    static function getAll()
    {
        $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks;");
        $tasks = array();
        foreach ($returned_tasks as $task) {
            $description = $task['description'];
            $new_task = new Task($description);
            array_push($tasks, $new_task);

        }
        return $tasks;
    }
    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM tasks *;");
    }
}
?>
