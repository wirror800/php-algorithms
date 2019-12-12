<?php
/* Stack!!
* A stack is exactly what it sounds like. An element gets added to the top of
* the stack and only the element on the top may be removed. This is an example
* of an array implementation of a Stack. So an element can only be added/removed
* from the end of the array.
*/

// Functions: push, pop, peek, view, length

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

class Stack
{
    public $top = 0;
    public $stack = [];

    public function __construct()
    {
        $this->top = 0;
        $this->stack = [];
    }

    public function push($value)
    {
        $this->stack[$this->top] = $value;
        $this->top ++;
    }

    public function pop()
    {
        if($this->top == 0)
        {
            throw new \Exception('Stack is Empty');
        }

        $this->top --;

        $result = $this->stack[$this->top];
        unset($this->stack[$this->top]);
        return $result;
    }

    public function size()
    {
        return count($this->stack);
    }

    public function peek()
    {
        return $this->stack[$this->top - 1];
    }

    //To see all the elements in the stack
    public function view () {
        for ($i = 0; $i < $this->top; $i++)
          consoleLog($this->stack[$i]);
    }
}

//Implementation
$myStack = new Stack();

$myStack->push(1);
$myStack->push(5);
$myStack->push(76);
$myStack->push(69);
$myStack->push(32);
$myStack->push(54);
consoleLog('size:'.$myStack->size());
consoleLog('peek:'.$myStack->peek());
consoleLog('pop:'.$myStack->pop());
consoleLog('peek:'.$myStack->peek());
consoleLog('pop:'.$myStack->pop());
consoleLog('peek:'.$myStack->peek());
$myStack->push(55);
consoleLog('peek:'.$myStack->peek());
$myStack->view();