<?php
	class block_simplehtml extends block_base {
		function init() {
			$this->title   = get_string('maskot', 'block_maskot');
    		$this->version = 2021041700;
		}

		function get_content() {
			if ($this->content !== NULL) {
				return $this->content;
			}

			$this->content         =  new stdClass;
			$this->content->text   = 'Здороваемся с Миром :)';
			$this->content->footer = 'Завершающий вывод...';

			return $this->content;
		}
	}

	// hi!
?>