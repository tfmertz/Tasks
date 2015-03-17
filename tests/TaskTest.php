<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Task.php";

    $DB = new PDO('pgsql:host=localhost;dbname=to_do_test');

    class TaskTest extends PHPUnit_Framework_TestCase
    {
        //clear out the to_do_test database after every test is run
        protected function tearDown()
        {
            Task::deleteAll();
        }


        //test that our Task->save() method stores our objects
        //information into our to_do_test database
        function test_save()
        {
            $description = "Wash the dog";
            $id = null;
            $test_task = new Task($description, $id);

            $test_task->save();

            $result = Task::getAll();
            $this->assertEquals($test_task, $result[0]);
        }


        //test to make sure that the getAll function collects all the task information
        //correctly and then recreates the tasks to be identical with this information
        function test_getAll()
        {
            //arrange
            $description = "Wash the dog";
            $description2 = "Water the lawn";
            $id = null;
            $test_Task = new Task($description, $id);
            $test_Task2 = new Task($description2, $id);
            $test_Task->save();
            $test_Task2->save();

            //act
            $result = Task::getAll();

            //assert
            $this->assertEquals([$test_Task, $test_Task2], $result);
        }

        //tests if function properly deletes all entries from the database.
        function test_deleteAll()
        {
            //Arrange
            $id = null;
            $description = "Wash the dog";
            $description2 = "Water the lawn";
            $test_Task = new Task($description, $id);
            $test_Task->save();
            $test_Task2 = new Task($description2, $id);
            $test_Task2->save();

            //Act
            Task::deleteAll();

            //Assert
            $result = Task::getAll();
            $this->assertEquals([], $result);
        }

        //tests if function properly retrieves id.
        function test_getId()
        {
            //Arrange
            $description = "Wash the dog";
            $id = 1;
            $test_Task = new Task($description, $id);

            //Act
            $result = $test_Task->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        //tests if function properly sets id within the class that corresponds with the database
        //id.
        function test_setId()
        {
            //Arrange
            $description = "Wash the dog";
            $id = null;
            $test_Task = new Task($description, $id);

            //Act
            $test_Task->setId(2);

            //Assert
            $result = $test_Task->getId();
            $this->assertEquals(2, $result);
        }

        //tests if function properly locates id.
        function test_find()
        {
            //arrange
            $description = "Wash the dog";
            $id = null;
            $description2 = "Water the lawn";
            $test_Task = new Task($description, $id);
            $test_Task->save();
            $test_Task2 = new Task($description2, $id);
            $test_Task2->save();

            //act
            $result = Task::find($test_Task->getId());

            //assert
            $this->assertEquals($test_Task, $result);
        }
    }
?>
