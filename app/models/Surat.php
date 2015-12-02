<?php

class Surat extends Eloquent {
	protected $table = 'surat';
	protected $primaryKey = 'surat_id';

	public function logs() {
		return $this->hasMany('Logsurat');
	}
}