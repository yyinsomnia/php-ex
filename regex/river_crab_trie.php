<?php

class TrieTree
{
	public $root;
	public $nodeNum = 0;
	public $wordNum = 0;

	public function __construct()
	{
		$this->root = new TrieNode();
		$this->nodeNum = 0;
	}

	public function insert($word)
	{
		$unicode_char_arr = preg_split('//u', $word, -1, PREG_SPLIT_NO_EMPTY); //sth wrong
		$len = count($unicode_char_arr);
		$prev_node = $this->root;
		for ($i = 0; $i < $len; $i++) {
			$chr = $unicode_char_arr[$i];
			if (isset($prev_node->next[$chr])) {
				$prev_node->next[$chr]->passCount++;
			} else {
				$prev_node->next[$chr] = new TrieNode;
				$prev_node->next[$chr]->passCount++;
			}
			$prev_node = $prev_node->next[$chr];
			$this->nodeNum++;
		}
		$prev_node->wordCount++;
		$this->wordNum++;
	}

}

class TrieNode
{
	public $wordCount = 0;
	public $passCount = 0;
	public $next = array();
}



$words = array('16大','1989','21世纪中国基金会','3P','4-Jun','4.25','425','6-4tianwang','6.4','64','7.22','722','89','89-64cdjp','AV女');

$trie_tree = new TrieTree();
foreach ($words as $word) {
	$trie_tree->insert($word);
}

// printNode($trie_tree->root->next);
// var_dump($trie_tree->root);
// exit(0);
$post_str = 'tomorrow simida21世纪中国基金会';

$post_str_arr = preg_split('//u', $post_str, -1, PREG_SPLIT_NO_EMPTY);
$DFA_pool = [];
$mutation = [];
foreach ($post_str_arr as $index => $chr) {
	$new_DFA = new DFA($trie_tree, $DFA_pool, $index, $mutation);
	$DFA_pool[spl_object_hash($new_DFA)] = $new_DFA; //dirty...
	foreach ($DFA_pool as $DFA) {
		$DFA->eat($index, $chr);
	}
}
var_dump($post_str_arr);
var_dump($mutation);

function printNode(array $trie_node_arr)
{
	if ($trie_node_arr) {
		foreach ($trie_node_arr as $chr => $node) {
			echo $chr;
			printNode($node->next);
		}
	} else {
		echo '<br />';
	}
}

class DFA
{
	public $trieTree;
	public $trieNode;
	public $DFAPool;
	public $mutation;
	public $startIndex;

	public function __construct(TrieTree $trie, &$DFA_pool, $index, &$mutation)
	{
		$this->DFAPool = &$DFA_pool;
		$this->trieTree = $trie;
		$this->trieNode = $this->trieTree->root;
		$this->mutation = &$mutation;
		$this->startIndex = $index;
	}

	function eat($index, $chr)
	{
		if (isset($this->trieNode->next[$chr])) {
			$this->trieNode = $this->trieNode->next[$chr];
			if (!$this->trieNode->next) { //match word
				//do sth
				for ($i = $this->startIndex; $i <= $index; $i++) {
					$this->mutation[$i] = '*';
				}
			}
		} else {
			unset($this->DFAPool[spl_object_hash($this)]); //don't match ,destruct the DFA
		}
	}
}
