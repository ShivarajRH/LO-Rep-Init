<?php
$output= '';
require_once 'google/appengine/api/taskqueue/PushTask.php';
use \google\appengine\api\taskqueue\PushTask;
    
function createTaskQueue($content_id,$content_type) {
    $task = new PushTask('/worker/tagextractor/', ['content_id' => $content_id, 'content_type' => $content_type]);
    echo "Task Name = ".$task_name = $task->add();
}
createTaskQueue(2,'note');

die();
?>