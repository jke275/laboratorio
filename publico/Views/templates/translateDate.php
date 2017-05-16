<?php
	function translateDate($date){
		$months = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
		$date = explode('-', $date);
		$day = $date[2];
		$month = $date[1];
		$year = $date[0];
		$newDate = $day . '-' . $months[$month - 1] . '-' . $year;
		return $newDate;
	}
?>