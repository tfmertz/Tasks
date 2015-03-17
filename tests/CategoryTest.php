<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Category.php";
    require_once "src/Task.php";

    $DB = new PDO('pgsql:host=localhost;dbname=to_do_test');


    class CategoryTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Category::deleteAll();
        }

        function test_getName()
        {
            //arrange
            $name = "Work stuff";
            $id = null;
            $test_Category = new Category($name, $id);

            //act
            $result = $test_Category->getName();

            //assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //arrange
            $name = "Work stuff";
            $id = 1;
            $test_Category = new Category($name, $id);

            //act
            $result = $test_Category->getId();

            //assert
            $this->assertEquals(1, $result);
        }

        function test_setId()
        {
            //arrange
            $name = "Home stuff";
            $id = null;
            $test_Category = new Category($name, $id);

            //act
            $test_Category->setId(2);

            //assert
            $result = $test_Category->getId();
            $this->assertEquals(2, $result);
        }

        function test_save()
        {
            //arrange
            $name = "Work stuff";
            $id = null;
            $test_Category = new Category($name, $id);
            $test_Category->save();

            //act
            $result = Category::getAll();

            //assert
            $this->assertEquals($test_Category, $result[0]);
        }

        function test_getAll()
        {
            //arrange
            $name = "Work stuff";
            $id = null;
            $name2 = "Home stuff";
            $id2 = null;
            $test_Category = new Category($name, $id);
            $test_Category->save();
            $test_Category2 = new Category($name, $id2);
            $test_Category2->save();

            //act
            $result = Category::getAll();

            //assert
            $this->assertEquals([$test_Category, $test_Category2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Wash the dog";
            $id = null;
            $name2 = "Home stuff";
            $id2 = null;
            $test_Category = new Category($name, $id);
            $test_Category->save();
            $test_Category2 = new Category($name2, $id2);
            $test_Category2->save();

            //Act
            Category::deleteAll();
            $result = Category::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Wash the dog";
            $id = 1;
            $name2 = "Home stuff";
            $id2 = 2;
            $test_Category = new Category($name, $id);
            $test_Category->save();
            $test_Category2 = new Category($name2, $id2);
            $test_Category2->save();

            //Act
            $result = Category::find($test_Category->getId());

            //Assert
            $this->assertEquals($test_Category, $result);
        }

        function testGetTasks()
        {
            //Arrange
            $name = "Work stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $test_category_id = $test_category->getId();

            $description = "Email client";
            $test_task = new Task($description, $id, $test_category_id);
            $test_task->save();

            $description2 = "Meet with boss";
            $test_task2 = new Task($description2, $id, $test_category_id);
            $test_task2->save();

            //Act
            $result = $test_category->getTasks();

            //Assert
            $this->assertEquals([$test_task, $test_task2], $result);
        }


    }


 ?>
