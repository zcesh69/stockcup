<?php
date_default_timezone_set('America/New_York');

class Stock
{
  private $list_id;
  private $stock_name;

  public static function create($stock_name) {
    $mysqli = new mysqli("classroom.cs.unc.edu", "cchunhao", "abroad#1", "cchunhaodb");

    $result = $mysqli->query("insert into list_content values (0, " .
			     "'" . $mysqli->real_escape_string($stock_name) . "')");
    
    if ($result) {
      $id = $mysqli->insert_id;
      if ($id == "")
        return new Stock(20, $stock_name);
      else
        return new Stock($id, $stock_name);
    }
    return null;
  }

  public static function findByListID($id) {
    $mysqli = new mysqli("classroom.cs.unc.edu", "cchunhao", "abroad#1", "cchunhaodb");

    $result = $mysqli->query("select * from list_content where list_id = " . $id);
    if ($result) {
      if ($result->num_rows == 0) {
	       return null;
      }

      $stock_name_array = array();

      while($next_row = $result->fetch_array()) {
        $stock_name_array[] = $next_row['stock_name'];
      }

      return $stock_name_array;
    }
    return null;
  }

  public static function findByKey($id, $stock_name) {
    $mysqli = new mysqli("classroom.cs.unc.edu", "cchunhao", "abroad#1", "cchunhaodb");

    $result = $mysqli->query("select * from list_content where list_id = " . $id . 
      " and stock_name = " . $stock_name);

    if ($result) {
      if ($result->num_rows == 0) {
         return null;
      }

      $stock_info = $result->fetch_array();

      return new Stock(intval($stock_info['list_id']),
          $stock_info['stock_name']);
    }
    return null;
  }


  public static function getAllIDs() {
    $mysqli = new mysqli("classroom.cs.unc.edu", "cchunhao", "abroad#1", "cchunhaodb");

    $result = $mysqli->query("select list_id from list_content");
    $id_array = array();

    if ($result) {
      while ($next_row = $result->fetch_array()) {
	       $id_array[] = intval($next_row['list_id']);
      }
    }
    return $id_array;
  }
  
  private function __construct($list_id, $stock_name) {
    $this->list_id = $list_id;
    $this->stock_name = $stock_name;
  }
  /*
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
*/
  public function delete() {
    $mysqli = new mysqli("classroom.cs.unc.edu", "cchunhao", "abroad#1", "cchunhaodb");
    $mysqli->query("delete from list_content where list_id = " . $this->id . 
      " and stock_name = " . $this->stock_name);
  }

  public function getJSON() {

    $json_obj = array('list_id' => $this->list_id,
		      'stock_name' => $this->stock_name);
    return json_encode($json_obj);
  }

}
