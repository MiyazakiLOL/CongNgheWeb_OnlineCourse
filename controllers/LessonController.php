<?php
require_once 'models/Lesson.php';

class LessonController
{
    private $lessonModel;

    public function __construct()
    {
        $this->lessonModel = new Lesson();
    }

    public function index()
    {
        $lessons = $this->lessonModel->all();
        require 'views/lessons/index.php';
    }

    public function create()
    {
        require 'views/lessons/create.php';
    }

    public function store()
    {
        $this->lessonModel->create($_POST);
        header("Location: index.php?uri=lesson/index");
    }

    public function show()
    {
        $id = $_GET['id'];
        $lesson = $this->lessonModel->find($id);
        require 'views/lessons/show.php';
    }

    public function edit()
    {
        $id = $_GET['id'];
        $lesson = $this->lessonModel->find($id);
        require 'views/lessons/edit.php';
    }

    public function update()
    {
        $id = $_GET['id'];
        $this->lessonModel->updateLesson($id, $_POST);
        header("Location: index.php?uri=lesson/index");
    }

    public function delete()
    {
        $id = $_GET['id'];
        $this->lessonModel->delete($id);
        header("Location: index.php?uri=lesson/index");
    }
}