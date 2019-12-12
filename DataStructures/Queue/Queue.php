<?php
function consoleLog()
{
    $args = func_get_args();
    if (!$args) {
        return;
    }
    $output = $args[0];
    if (count($args) > 1) {
        $output = call_user_func_array('sprintf', $args);
    } else {
        if (!is_scalar($output)) {
            $output = var_export($output, true);
        }
    }

    echo "$output \n";
}

class Queue
{
    public $queue;
    public function __construct()
    {
        $this->queue = array();
    }

    public function enqueue($item)
    {
        $this->queue[count($this->queue)] = $item;
    }

    public function dequeue()
    {
        if (count($this->queue) === 0)
        {
            throw new \Exception("Queue is Empty");
        }
        $result = $this->queue[0];
        array_splice($this->queue, 0, 1);
        return $result;
    }

    public function count()
    {
        return count($this->queue);
    }

    public function peek()
    {
        return $this->queue[0];
    }

    public function view()
    {
        consoleLog($this->queue);
    }
}
$myQueue = new Queue();
$myQueue->enqueue(1);
$myQueue->enqueue(5);
$myQueue->enqueue(76);
$myQueue->enqueue(69);
$myQueue->enqueue(32);
$myQueue->enqueue(54);
$myQueue->view();
consoleLog("Length: " . $myQueue->count());
consoleLog("Front item: " . $myQueue->peek());
consoleLog("Removed " . $myQueue->dequeue() . " from front.");
consoleLog("New front item: " . $myQueue->peek());
consoleLog("Removed " . $myQueue->dequeue() . " from front.");
consoleLog("New front item: " . $myQueue->peek());
$myQueue->enqueue(55);
consoleLog("Inserted 55");
consoleLog("New front item: " . $myQueue->peek());
for ($i = 0;
     $i < 5; $i++) {
    $myQueue->dequeue();
    $myQueue->view();
}
