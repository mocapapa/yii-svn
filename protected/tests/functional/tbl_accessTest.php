<?php

class tbl_accessTest extends WebTestCase
{
	public $fixtures=array(
		'tbl_accesses'=>'tbl_access',
	);

	public function testShow()
	{
		$this->open('?r=access/view&id=1');
	}

	public function testCreate()
	{
		$this->open('?r=access/create');
	}

	public function testUpdate()
	{
		$this->open('?r=access/update&id=1');
	}

	public function testDelete()
	{
		$this->open('?r=access/view&id=1');
	}

	public function testList()
	{
		$this->open('?r=access/index');
	}

	public function testAdmin()
	{
		$this->open('?r=access/admin');
	}
}
