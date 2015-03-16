<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Task.php";

    $DB = new PDO('pgsql:host=localhost;dbname=to_do_test');

    class TaskTest extends PHPUnit_Framework_TestCase
    {

        function test_save()
        {
            $description = "Wash the dog";
            $test_task = new Task($description);

            $test_task->save();

            $result = Task::getAll();
            $this->assertEquals($test_task, $result[0]);
        }

        function test_getAll()
        {
            //arrange
            $description = "Wash the dog";
            $description2 = "Water the lawn";
            $test_Task = new Task($description);
            $test_Task2 = new Task($description2);
            $test_Task->save();
            $test_Task2->save();

            //act
            $result = Task::getAll();

            //assert
            $this->assertEquals([$test_Task, $test_Task2], $result);
        }
    }
?>
