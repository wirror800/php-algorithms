<?php
function consoleLog()
{
    $args = func_get_args();
    if(!$args)
    {
        return;
    }
    $output = $args[0];
    if(count($args)>1)
    {
        $output = call_user_func_array('sprintf', $args);
    }
    else
    {
        if(!is_scalar($output))
        {
            $output = var_export($output, true);
        }
    }

    echo "$output \n";
}

class Node
{
    public function __construct($val)
    {
        $this->value = $val;
        $this->left = null;
        $this->right = null;
    }

    public function search($val)
    {
        if ($this->value == $val)
        {
            return $this;
        }
        else if ($val < $this->value && $this->left != null)
        {
            return $this->left->search($val);
        }
        else if ($val > $this->value && $this->right != null)
        {
            return $this->right->search($val);
        }
        return null;
    }

    public function visit ()
    {
        if ($this->left != null)
        {
            $this->left->visit();
        }
        consoleLog($this->value);
        if ($this->right != null)
        {
            $this->right->visit();
        }
    }

    public function addNode($n)
    {
        if ($n->value < $this->value)
        {
            if ($this->left == null)
            {
                $this->left = $n;
            }
            else
            {
                $this->left->addNode($n);
            }
        }
        else if ($n->value > $this->value)
        {
            if ($this->right == null)
            {
                $this->right = $n;
            }
            else
            {
                $this->right->addNode($n);
            }
        }
    }
}

class Tree
{
    public function __construct()
    {
        $this->root = null;
    }

    public function traverse()
    {
        $this->root->visit();
    }

    public function search($val)
    {
        $found = $this->root->search($val);
        if ($found === null)
        {
            consoleLog($val . " not found");
        }
        else
        {
            consoleLog("Found:" . $found->value);
        }
    }

    public function addValue($val)
    {
        $n = new Node($val);
        if ($this->root == null)
        {
            $this->root = $n;
        }
        else
        {
            $this->root->addNode($n);
        }
    }
}

$bst = new Tree();
$bst->addValue(6);
$bst->addValue(3);
$bst->addValue(9);
$bst->addValue(2);
$bst->addValue(8);
$bst->addValue(4);
$bst->traverse();
$bst->search(8);

