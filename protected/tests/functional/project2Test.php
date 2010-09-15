<?php

class project2Test extends WebTestCase
{
	public $fixtures=array(
		'project2s'=>'project2',
	);

	public function testShow()
	{
		$this->open('?r=project2/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=project2/create');
	}

	public function testUpdate()
	{
		$this->open('?r=project2/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=project2/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=project2/index');
	}

	public function testAdmin()
	{
		$this->open('?r=project2/admin');
	}
}
