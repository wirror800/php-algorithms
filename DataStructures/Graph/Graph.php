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

class Graph
{
    public $adjacencyMap;

    public function __construct()
    {
        $this->adjacencyMap = array();
    }

    public function addVertex($v)
    {
        $this->adjacencyMap[$v] = array();
    }

    public function containsVertex($vertex)
    {
        return gettype($this->adjacencyMap[$vertex]) !== NULL;
    }

    public function addEdge($v, $w)
    {
        $result = false;
        if ($this->containsVertex($v) && $this->containsVertex($w)) {
            array_push($this->adjacencyMap[$v], $w);
            array_push($this->adjacencyMap[$w], $v);
            $result = true;
        }
        return $result;
    }

    public function printGraph()
    {
        $keys = array_keys($this->adjacencyMap);
        foreach ($keys as $i) {
            $values = $this->adjacencyMap[$i];
            $vertex = "";
            foreach ($values as $j) {
                $vertex .= $j . " ";
            }
            consoleLog($i . " -> " . $vertex);
        }
    }

}

$g = new Graph();
$g->addVertex(1);
$g->addVertex(2);
$g->addVertex(3);
$g->addEdge(1, 2);
$g->addEdge(1, 3);
$g->printGraph();

