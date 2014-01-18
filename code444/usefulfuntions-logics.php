<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script>
    /*
    Date.prototype.monthNames = [
                                "January", "February", "March",
                                "April", "May", "June",
                                "July", "August", "September",
                                "October", "November", "December"
                            ];

    Date.prototype.getMonthName = function() {
        return this.monthNames[this.getMonth()];
    };
    Date.prototype.getShortMonthName = function () {
        return this.getMonthName().substr(0, 3);
    };
    
    // usage:
    var d = new Date();
    alert(d.getMonthName());      // "October"
    alert(d.getShortMonthName()); // "Oct"
    */
   /*
    *Javascript
   box.removeAttribute("class")
    OR
        // to add
        box.className = 'move';
        // to remove
        box.className = ''; //IE also Supports
   */
    /*function hasClass(ele,cls) {
      return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
    }
    function addClass(ele,cls) {
        if (!this.hasClass(ele,cls)) ele.className += " "+cls;
    }
    function removeClass(ele,cls) {
        if (hasClass(ele,cls)) {
            var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
            ele.className=ele.className.replace(reg,' ');
        }
    }
    var forEach = Array.prototype.forEach;
    var className = "yourclass";

    forEach.call(document.querySelectorAll("." + className), function(node) {
        node.classList.remove(className);
    });
    */
    //editorBtn.addEventListener('click', function(e) {});
    
    
    
    //====================================================
    
    /**
     * Return the interactive code for the given module. This code is saved using
     * HTML localStorage and is unique per application.
     * @param {string} moduleName The name of the module whose code should be
     *     returned.
     * @return {string} The code for the given module. If no code was previously
     *     saved for this module then some example code is returned.
     */
    function getCode(moduleName) {
      var text = localStorage.getItem('dev~project-init:' + moduleName);
      if (text == null) {
        var runtime = SERVER_NAME_TO_RUNTIME_NAME_[moduleName];
        if (runtime == 'python' || runtime  == 'python27') {
          return DEFAULT_PYTHON_SOURCE_;
        } else if (runtime == 'php') {
          return DEFAULT_PHP_SOURCE_;
        } else {
          return '';
        }
      }
      return text;
    }

    /**
     * Set the interactive code for the given module. This code is saved using
     * HTML localStorage and is unique per application.
     * @param {string} moduleName The name of the module to save the code for.
     * @param {string} code The code to save.
     */
    function setCode(moduleName, code) {
      localStorage.setItem('dev~project-init:' + moduleName, code);
    }
    
    $(window).unload(function() {
        // Save the current code text.
        setCode($('#module_name').val(), $('#code_text').val());
    });
    
    // ('^(?:^([0-9]+(\.[0-9]*)?[BKMGT]?))$')
</script>
<?php
/*    include 'includes/myclasses.php';
                                        $url=$site_url."api/search/?action_object=list_content&limit_start=1&limit_end=4";
                                        //die($url);&uid=6585877897&content_type=all
                                      
                                        $ob=new mycurl();

                                        $post = array("uid"=>$uid,"content_type"=>"all");
                                        //$result = $ob->getApiContent($url,$post,"json");
                                      */


#Configuring the processing rate
#- name: optimize-queue
#  rate: 20/s
#  bucket_size: 40
#  max_concurrent_requests: 10

#Retrying tasks in push queues
#- name: fooqueue
#  rate: 1/s
#  retry_parameters:
#    task_retry_limit: 7
#    task_age_limit: 2d
#- name: barqueue
#  rate: 1/s
#  retry_parameters:
#    min_backoff_seconds: 10
#    max_backoff_seconds: 200
#    max_doublings: 0
#- name: bazqueue
#  rate: 1/s
#  retry_parameters:
#    min_backoff_seconds: 10
#    max_backoff_seconds: 200
#    max_doublings: 2


#  bucket_size: 100
#  max_concurrent_requests: 2
  
#- name: tagextractor
#  rate: 1/s
#  retry_parameters:
#    min_backoff_seconds: 10
#    max_backoff_seconds: 200
#    max_doublings: 2
# Change the refresh rate of the default queue from 5/s to 1/s
#- name: tagextractor1



// Single
//require_once 'google/appengine/api/taskqueue/PushTask.php';
//use \google\appengine\api\taskqueue\PushTask;
//$task = new PushTask('/worker.php', ['name' => name, 'action' => 'send_reminder']);
//echo $task_name = $task->add();

// Multiple
/*
require_once 'google/appengine/api/taskqueue/PushQueue.php';
require_once 'google/appengine/api/taskqueue/PushTask.php';

use google\appengine\api\taskqueue\PushTask;
use google\appengine\api\taskqueue\PushQueue;

$task1 = new PushTask('/someUrl');
$task2 = new PushTask('/someOtherUrl');
$queue = new PushQueue();
$queue->addTasks([$task1, $task2]);
*/
#======================================================
#require_once 'google/appengine/api/taskqueue/PushTask.php';
//use \google\appengine\api\taskqueue\PushTask;
//(new PushTask('/path/to/my/worker', ['data_for_task' => 1234]))->add();

#======================================================
//require_once 'google/appengine/api/mail/Message.php';
//use \google\appengine\api\mail\Message;
//require_once 'google/appengine/api/users/UserService.php';
//use google\appengine\api\users\UserService;

//echo '<pre>';print_r($_SERVER);


//require_once 'google/appengine/api/taskqueue/PushTask.php';
//use \google\appengine\api\taskqueue\PushTask;
//$task = new PushTask('/worker.php', ['name' => name, 'action' => 'send_reminder']);
//echo $task_name = $task->add();

/*
require_once 'google/appengine/api/taskqueue/PushQueue.php';
require_once 'google/appengine/api/taskqueue/PushTask.php';

use google\appengine\api\taskqueue\PushTask;
use google\appengine\api\taskqueue\PushQueue;

$task1 = new PushTask('/tagsextractor');
$task2 = new PushTask('/');
$queue = new PushQueue();
$queue->addTasks([$task1, $task2]);*/


//app.yaml
//- url: /(.*\.(gif|png|jpg))
//  static_files: static/\1
//  upload: static/(.*\.(gif|png|jpg))

/*
require_once 'google/appengine/api/taskqueue/PushQueue.php';
use \google\appengine\api\taskqueue\PushQueue;
$queue = new PushQueue('tagextractor');
$task = new PushTask('/worker/tagextractor/1', ['content_id' => $content_id, 'content_type' => $content_type]);
echo "Task Name = ".$task_name = $task->add();
$queue->addTasks([$task]);
*/

//cron.yaml
//cron:
//    - description: ingestion cron task for users
//      url: /ingestion.php
//      schedule: every 2 hours

    //$load_js['jquery.autosize'] = 'jquery.autosize';
    //$load_js['jquery.hashtags'] = 'jquery.hashtags';
    //$load_css['file'] = 'jquery.hashtags';
?>
