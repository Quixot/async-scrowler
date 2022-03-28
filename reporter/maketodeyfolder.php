<?php 
	if (!file_exists('/var/www/reporter/reports/'.date('d.m.y'))) {
		mkdir('/var/www/reporter/reports/'.date('d.m.y'));
		chmod('/var/www/reporter/reports/'.date('d.m.y'), 0777);
	}
