<?php

class Logsurat extends Eloquent {
	protected $table = 'logs';
	protected $primaryKey = 'log_id';

	public function surat() {
		#param 1 => nama class
		#param 2 => FK
		#param 3 => PK pada model tujuan
		return $this->belongsTo('surat', 'surat_id', 'surat_id');
	}

	public function users() {
		#param 1 => nama class
		#param 2 => FK
		#param 3 => PK pada model tujuan
		return $this->belongsTo('user', 'user_id', 'user_id');
	}
}