<?php

namespace Membergate\FormHandlers;

class AddSubscriberToService implements FormHandlerInterface{
	public function execute_action($submission){
		error_log(print_r($submission,true));	
	}
}
