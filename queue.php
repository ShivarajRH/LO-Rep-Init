<?php
require_once 'google/appengine/api/taskqueue/PushTask.php';

use \google\appengine\api\taskqueue\PushTask;

$task = new PushTask('/worker.php', ['name' => name, 'action' => 'send_reminder']);
$task_name = $task->add();

?>
