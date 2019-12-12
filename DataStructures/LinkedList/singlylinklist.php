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

/**
 * This class is the nodes of the SinglyLinked List.
 * They consist of a value and a pointer to the node
 * after them.
 */
class Node
{
    /**
     * The value of the node
     */
    public $value;

    /**
     * Point to the next node
     */
    public $next;

    public function __construct($value=0, $next=null)
    {
        $this->value = $value;
        $this->next = $next;
    }
}

class SinglyLinkedList
{
    /**
     * Head refer to the front of the list
     */
    private $head;

    /**
     * size of SinglyLinkedList
     */
    private $size;

    /**
     * init SinglyLinkedList
     */
    public function __construct($head=null, $size=0)
    {
        $this->head = is_null($head)?(new Node(0)):$head;
        $this->size = $size;
    }

    /**
     * This method inserts an element at the head
     *
     * @param x Element to be added
     */
    public function insertHead($x)
    {
        $this->insertNth($x, 0);
    }

    /**
     * insert an element at the tail of list
     *
     * @param data Element to be added
     */
    public function insert($data)
    {
        $this->insertNth($data, $this->size);
    }

    /**
     * Inserts a new node at a specified position
     *
     * @param data     data to be stored in a new node
     * @param position position at which a new node is to be inserted
     */
    public function insertNth($data, $position)
    {
        $this->checkBounds($position, 0, $this->size);
        $cur = $this->head;
        for ($i = 0; $i <$position; ++$i)
        {
            $cur = $cur->next;
        }
        $node = new Node($data);
        $node->next = $cur->next;
        $cur->next = $node;
        $this->size++;
    }

    /**
     * Insert element to list, always sorted
     *
     * @param data to be inserted
     */
    public function insertSorted($data)
    {
        $cur = $this->head;
        while ($cur->next != null && $data > $cur->next->value)
        {
            $cur = $cur->next;
        }

        $newNode = new Node($data);
        $newNode->next = $cur->next;
        $cur->next = $newNode;
        $this->size++;
    }

    /**
     * This method deletes an element at the head
     *
     * @return The element deleted
     */
    public function deleteHead()
    {
        $this->deleteNth(0);
    }

    /**
     * This method deletes an element at the tail
     */
    public function delete()
    {
        $this->deleteNth($this->size - 1);
    }

    /**
     * This method deletes an element at Nth position
     */
    public function deleteNth($position)
    {
        $this->checkBounds($position, 0, $this->size - 1);
        $cur = $this->head;
        for ($i = 0; $i < $position; ++$i)
        {
            $cur = $cur->next;
        }

        $destroy = $cur->next;
        $cur->next = $cur->next->next;
        $destroy = null; // clear to let GC do its work

        $this->size--;
    }

    /**
     * @param position to check position
     * @param low      low index
     * @param high     high index
     * @throws IndexOutOfBoundsException if {@code position} not in range {@code low} to {@code high}
     */
    public function checkBounds($position, $low, $high)
    {
        if ($position > $high || $position < $low)
        {
            throw new \Exception($position . "");
        }
    }

    /**
     * clear all nodes in list
     */
    public function clear()
    {
        if ($this->size == 0) {
            return;
        }
        $prev = $this->head->next;
        $cur = $prev->next;
        while ($cur != null)
        {
            $prev = null; // clear to let GC do its work
            $prev = $cur;
            $cur = $cur->next;
        }
        $prev = null;
        $this->head->next = null;
        $this->size = 0;
    }

    /**
     * Checks if the list is empty
     *
     * @return true is list is empty
     */
    public function isEmpty()
    {
        return $this->size == 0;
    }

    /**
     * Returns the size of the linked list
     */
    public function size()
    {
        return $this->size;
    }

    public function toString() {
        if ($this->size == 0)
        {
            return "";
        }
        $builder = '';
        $cur = $this->head->next;
        while ($cur != null) {
            $builder = $builder. ($cur->value)."->";
            $cur = $cur->next;
        }
        return substr($builder, 0,strlen($builder)-2);
    }

    /**
     * Merge two sorted SingleLinkedList
     *
     * @param listA the first sorted list
     * @param listB the second sored list
     * @return merged sorted list
     */
    public static function merge($listA, $listB)
    {
        $headA = $listA->head->next;
        $headB = $listB->head->next;

        $size = $listA->size() + $listB->size();

        $head = new Node();
        $tail = $head;
        while ($headA != null && $headB != null)
        {
            if ($headA->value <= $headB->value)
            {
                $tail->next = $headA;
                $headA = $headA->next;
            }
            else
            {
                $tail->next = $headB;
                $headB = $headB->next;
            }
            $tail = $tail->next;
        }
        if ($headA == null)
        {
            $tail->next = $headB;
        }
        if ($headB == null)
        {
            $tail->next = $headA;
        }
        return new SinglyLinkedList($head, $size);
    }

    /**
     * Main method
     *
     * @param args Command line arguments
     */
    public static function run()
    {
        $myList = new SinglyLinkedList();

        $myList->insertHead(5);
        $myList->insertHead(7);
        $myList->insertHead(10);
        consoleLog($myList->toString());

        $myList->deleteHead();
        consoleLog($myList->toString());

        $myList->insertNth(11, 2);
        consoleLog($myList->toString());

        $myList->deleteNth(1);
        consoleLog($myList->toString());

        $myList->clear();
        consoleLog($myList->toString());

        /* Test MergeTwoSortedLinkedList */
        $listA = new SinglyLinkedList();
        $listB = new SinglyLinkedList();

        for ($i = 10; $i >= 2; $i -= 2)
        {
            $listA->insertSorted($i);
            $listB->insertSorted($i - 1);
        }

        consoleLog($listA->toString());
        consoleLog($listB->toString());
        consoleLog(SinglyLinkedList::merge($listA, $listB)->toString());

    }
}

SinglyLinkedList::run();