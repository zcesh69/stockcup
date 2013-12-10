<?php
include 'db_connect.php';
include 'functions.php';
require_once('list_content_orm.php');
sec_session_start();

if (!login_check($mysqli)) {
  header("HTTP/1.0 404 Not Found");
  print("Not found user!");
  exit();
}

$path_components = explode('/', $_SERVER['PATH_INFO']);

$user_id = intval($_SESSION['user_id']);

// Note that since extra path info starts with '/'
// First element of path_components is always defined and always empty.

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  // GET means either instance look up, index generation, or deletion

  if ((count($path_components) >= 2) &&
      ($path_components[1] != "")) {

      header("HTTP/1.0 404 Not Found");
      print("Bad request.");
      exit();
    }

    // Check to see if deleting
    if (isset($_REQUEST['delete'])) {

      if (!isset($_REQUEST['stock_name'])) {
          header("HTTP/1.0 404 Not Found");
          print("stock_name isn't set with user id " . $user_id);
          exit();
      }

      $stock_name = trim($_REQUEST['stock_name']);
      $stock = Stock::findByKey($user_id, $stock_name);
      
      if ($stock != null) {
        $result = Stock::delete($stock);
      } else {
        $result = false;
      }
      
      if ($result == false) {
        header("HTTP/1.0 500 Server error");
        print("server can't delete that stock. With " . $stock_name . " and id = " . $user_id);
        exit();
      }
      
      header("HTTP/1.0 404 Not Found");
      print("id = " . $stock[0] . " name = " . $stock[1] . " result = " . $result);
      exit();
    
    }
    // Normal lookup.
    // Generate JSON encoding as response
    $stock_array = Stock::findByUserID($user_id);

    header("Content-type: application/json");
    print(json_encode($stock_array));
    exit();

} else if ($_SERVER['REQUEST_METHOD'] == "POST") {

  // Either creating or updating

  // Following matches /todo.php/<id> form
  if ((count($path_components) >= 2) &&
      ($path_components[1] != "")) {
    /*
    //Interpret <id> as integer and look up via ORM
    $stock_id = intval($path_components[1]);
    $stock = Stock::findByID($stock_id);

    if ($todo == null) {
      // Todo not found.
      header("HTTP/1.0 404 Not Found");
      print("Todo id: " . $todo_id . " not found while attempting update.");
      exit();
    }

    // Validate values
    $new_title = false;
    if (isset($_REQUEST['title'])) {
      $new_title = trim($_REQUEST['title']);
      if ($new_title == "") {
      	header("HTTP/1.0 400 Bad Request");
      	print("Bad title");
      	exit();
      }
    }

    $new_note = false;
    if (isset($_REQUEST['note'])) {
      $new_note = trim($_REQUEST['note']);
    }

    $new_project = false;
    if (isset($_REQUEST['project'])) {
      $new_project = trim($_REQUEST['project']);
    }

    $new_due_date = false;
    $new_date_obj = null;
    if (isset($_REQUEST['due_date'])) {
      $new_due_date = true;
      $date_str = trim($_REQUEST['due_date']);
      if ($date_str != "") {
	$new_date_obj = new DateTime($date_str);
      }
    }

    $new_priority = false;
    if (isset($_REQUEST['priority'])) {
      $new_priority = intval($_REQUEST['priority']);
      if (!($new_priority > 0 && $new_priority <= 10)) {
	header("HTTP/1.0 400 Bad Request");
	print("Priority value out of range.");
	exit();
      }
    }*/

    /*
    if (isset($_REQUEST['complete'])) {
      $new_complete = true;
    } else {
      $new_complete = false;
    }

    // Update via ORM
    if ($new_title) {
      $todo->setTitle($new_title);
    }
    if ($new_note != false) {
      $todo->setNote($new_note);
    }
    if ($new_project != false) {
      $todo->setProject($new_project);
    }
    if ($new_due_date) {
      $todo->setDueDate($new_date_obj);
    }
    if ($new_priority != false) {
      $todo->setPriority($new_priority);
    }
    
    if (!$new_complete) {
      $todo->clearComplete();
    } else {
      $todo->setComplete();
    }
    
    // Return JSON encoding of updated Todo
    header("Content-type: application/json");
    print($todo->getJSON());*/
    exit();
  } else {

    // Creating a new Todo item

    // Validate values
    if (!isset($_REQUEST['stock_name']) || !isset($_REQUEST['stock_long_name'])) {
      header("HTTP/1.0 400 Bad Request");
      print("Missing title");
      exit();
    }
    
    $stock_name = trim($_REQUEST['stock_name']);
    $stock_long_name = trim($_REQUEST['stock_long_name']);
    if ($stock_name == "" || $stock_long_name == "") {
      header("HTTP/1.0 400 Bad Request");
      print("Bad title");
      exit();
    }

    // Create new stock name via ORM
    $new_stock = Stock::create($user_id, $stock_name, $stock_long_name);

    // Report if failed
    if ($new_stock == null) {
      header("HTTP/1.0 500 Server Error");
      print("Server couldn't create new todo.");
      exit();
    }
    
    //Generate JSON encoding of new Todo
    header("Content-type: application/json");
    print($new_stock->getJSON());
    exit();
  }
}

// If here, none of the above applied and URL could
// not be interpreted with respect to RESTful conventions.

header("HTTP/1.0 400 Bad Request");
print("Did not understand URL");

?>