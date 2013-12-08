<?php
date_default_timezone_set('America/New_York');

class Todo
{
  private $id;
  private $title;
  private $note;
  private $project;
  private $due_date;
  private $priority;
  private $complete;

  public static function create($title, $note, $project, $due_date, $priority, $complete) {
    $mysqli = new mysqli("classroom.cs.unc.edu", "cchunhao", "abroad#1", "cchunhaodb");

    if ($due_date == null) {
      $dstr = "null";
    } else {
      $dstr = "'" . $due_date->format('Y-m-d') . "'";
    }

    if ($complete) {
      $cstr = "1";
    } else {
      $cstr = "0";
    }

    $result = $mysqli->query("insert into Todo values (0, " .
			     "'" . $mysqli->real_escape_string($title) . "', " .
			     "'" . $mysqli->real_escape_string($note) . "', " .
			     "'" . $mysqli->real_escape_string($project) . "', " .
			     $dstr . ", " .
			     $priority . ", " .
			     $cstr . ")");
    
    if ($result) {
      $id = $mysqli->insert_id;
      return new Todo($id, $title, $note, $project, $due_date, $priority, $complete);
    }
    return null;
  }

  public static function findByID($id) {
    $mysqli = new mysqli("classroom.cs.unc.edu", "cchunhao", "abroad#1", "cchunhaodb");

    $result = $mysqli->query("select * from Todo where id = " . $id);
    if ($result) {
      if ($result->num_rows == 0) {
	return null;
      }

      $todo_info = $result->fetch_array();

      if ($todo_info['due_date'] != null) {
	$due_date = new DateTime($todo_info['due_date']);
      } else {
	$due_date = null;
      }

      if (!$todo_info['complete']) {
	$complete = false;
      } else {
	$complete = true;
      }

      return new Todo(intval($todo_info['id']),
		      $todo_info['title'],
		      $todo_info['note'],
		      $todo_info['project'],
		      $due_date,
		      intval($todo_info['priority']),
		      $complete);
    }
    return null;
  }

  public static function getAllIDs() {
    $mysqli = new mysqli("classroom.cs.unc.edu", "cchunhao", "abroad#1", "cchunhaodb");

    $result = $mysqli->query("select id from Todo");
    $id_array = array();

    if ($result) {
      while ($next_row = $result->fetch_array()) {
	$id_array[] = intval($next_row['id']);
      }
    }
    return $id_array;
  }

  private function __construct($id, $title, $note, $project, $due_date, $priority, $complete) {
    $this->id = $id;
    $this->title = $title;
    $this->note = $note;
    $this->project = $project;
    $this->due_date = $due_date;
    $this->priority = $priority;
    $this->complete = $complete;
  }

  public function getID() {
    return $this->id;
  }

  public function getTitle() {
    return $this->title;
  }

  public function getNote() {
    return $this->note;
  }

  public function getProject() {
    return $this->project;
  }

  public function getDueDate() {
    return $this->due_date;
  }

  public function getPriority() {
    return $this->priority;
  }

  public function isComplete() {
    return $this->complete;
  }

  public function setTitle($title) {
    $this->title = $title;
    return $this->update();
  }

  public function setNote($note) {
    $this->note = $note;
    return $this->update();
  }

  public function setProject($project) {
    $this->project = $project;
    return $this->update();
  }

  public function setDueDate($due_date) {
    $this->due_date = $due_date;
    return $this->update();
  }

  public function setPriority($priority) {
    $this->priority = $priority;
    return $this->update();
  }

  public function setComplete() {
    $this->complete = true;
    return $this->update();
  }

  public function clearComplete() {
    $this->complete = false;
    return $this->update();
  }

  private function update() {
    $mysqli = new mysqli("classroom.cs.unc.edu", "cchunhao", "abroad#1", "cchunhaodb");

    if ($this->due_date == null) {
      $dstr = "null";
    } else {
      $dstr = "'" . $this->due_date->format('Y-m-d') . "'";
    }

    if ($this->complete) {
      $cstr = "1";
    } else {
      $cstr = "0";
    }

    $result = $mysqli->query("update Todo set " .
			     "title=" .
			     "'" . $mysqli->real_escape_string($this->title) . "', " .
			     "note=" .
			     "'" . $mysqli->real_escape_string($this->note) . "', " .
			     "project=" .
			     "'" . $mysqli->real_escape_string($this->project) . "', " .
			     "due_date=" . $dstr . ", " .
			     "priority=" . $this->priority . ", " .
			     "complete=" . $cstr . 
			     " where id=" . $this->id);
    return $result;
  }

  public function delete() {
    $mysqli = new mysqli("classroom.cs.unc.edu", "cchunhao", "abroad#1", "cchunhaodb");
    $mysqli->query("delete from Todo where id = " . $this->id);
  }

  public function getJSON() {
    if ($this->due_date == null) {
      $dstr = null;
    } else {
      $dstr = $this->due_date->format('Y-m-d');
    }

    $json_obj = array('id' => $this->id,
		      'title' => $this->title,
		      'note' => $this->note,
		      'project' => $this->project,
		      'due_date' => $dstr,
		      'priority' => $this->priority,
		      'complete' => $this->complete);
    return json_encode($json_obj);
  }
}
