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

class MinPriorityQueue
{
    public $heap;
    public $capacity;
    public $size;

    public function __construct($c)
    {
        $this->heap = array();
        $this->capacity = $c;
        $this->size = 0;
    }

    public function insert($key)
    {
        if ($this->isFull()) {
            return;
        }
        $this->heap[$this->size + 1] = $key;
        $k = $this->size + 1;
        while ($k > 1) {
            if ($this->heap[$k] < $this->heap[floor($k / 2)]) {
                $temp = $this->heap[$k];
                $this->heap[$k] = $this->heap[floor($k / 2)];
                $this->heap[floor($k / 2)] = $temp;
            }
            $k = floor($k / 2);
        }
        $this->size++;
    }

    public function peek()
    {
        return $this->heap[1];
    }

    public function isEmpty()
    {
        if (0 == $this->size) {
            return true;
        }
        return false;
    }

    public function isFull()
    {
        if ($this->size == $this->capacity) {
            return true;
        }
        return false;
    }

    public function log()
    {
        consoleLog($this->heap);
    }

    public function heapSort()
    {
        for ($i = 1;
             $i < $this->capacity; $i++) {
            $this->delete();
        }
    }

    public function sink()
    {
        $k = 1;
        while (2 * $k <= $this->size || 2 * $k + 1 <= $this->size) {
            $minIndex = null;
            if ($this->heap[2 * $k] >= $this->heap[$k]) {
                if (2 * $k + 1 <= $this->size && $this->heap[2 * $k + 1] >= $this->heap[$k]) {
                    break;
                } else if (2 * $k + 1 > $this->size) {
                    break;
                }
            }
            if (2 * $k + 1 > $this->size) {
                $minIndex = ($this->heap[2 * $k] < $this->heap[$k]) ? 2 * $k : $k;
            } else {
                if ($this->heap[$k] > $this->heap[2 * $k] || $this->heap[$k] > $this->heap[2 * $k + 1]) {
                    $minIndex = ($this->heap[2 * $k] < $this->heap[2 * $k + 1]) ? 2 * $k : 2 * $k + 1;
                } else {
                    $minIndex = $k;
                }
            }
            $temp = $this->heap[$k];
            $this->heap[$k] = $this->heap[$minIndex];
            $this->heap[$minIndex] = $temp;
            $k = $minIndex;
        }
    }

    public function delete()
    {
        $min = $this->heap[1];
        $this->heap[1] = $this->heap[$this->size];
        $this->heap[$this->size] = $min;
        $this->size--;
        $this->sink();
        return $min;
    }

}

$q = new MinPriorityQueue(8);
$q->insert(5);
$q->insert(2);
$q->insert(4);
$q->insert(1);
$q->insert(7);
$q->insert(6);
$q->insert(3);
$q->insert(8);
$q->log();
$q->heapSort();
$q->log();

