<?php
	function formalize_to_variable($txt) {
		 $txt = str_replace("�", "i", $txt);
		 $txt = str_replace("�", "i", $txt);
		 $txt = str_replace("�", "i", $txt);
		 $txt = str_replace("�", "n", $txt);
		 $txt = str_replace("�", "a", $txt);
		 $txt = str_replace("�", "a", $txt);
		 $txt = str_replace("�", "a", $txt);
		 $txt = str_replace("�", "a", $txt);
		 $txt = str_replace("�", "e", $txt);
		 $txt = str_replace("�", "e", $txt);
		 $txt = str_replace("�", "e", $txt);
		 $txt = str_replace("�", "e", $txt);
		 $txt = str_replace(")", "", $txt);
		 $txt = str_replace("(", "", $txt);
		 $txt = str_replace("]", "", $txt);
		 $txt = str_replace("[", "", $txt);
		 $txt = str_replace("-", "", $txt);
		 $txt = str_replace("�", "s", $txt);
		 $txt = str_replace("�", "n", $txt);
		 $txt = str_replace("�", "o", $txt);
		 $txt = str_replace("�", "c", $txt);
		 $txt = str_replace("�", "u", $txt);
		 $txt = str_replace("�", "u", $txt);
		 $txt = str_replace("�", "u", $txt);
		 $txt = str_replace("$", "", $txt);
		 $txt = str_replace("@", "", $txt);
		 $txt = str_replace("#", "", $txt);
		 $txt = str_replace("/", "", $txt);
		 $txt = str_replace("\"", "", $txt);
		 $txt = str_replace(".", "", $txt);
		 $txt = str_replace("|", "", $txt);
		 $txt = str_replace(":", "", $txt);
		 $txt = str_replace(";", "", $txt);
		 $txt = str_replace(",", "", $txt);
		 $txt = str_replace("?", "", $txt);
		 $txt = str_replace("!", "", $txt);
		 $txt = str_replace("\'", "", $txt);
		 $txt = str_replace("'", "", $txt);
		 $txt = str_replace("\\", "", $txt);
		 $txt = str_replace(" ", "_", $txt);
		 $txt = str_replace("�", "2", $txt);
		 $txt = str_replace("%", "", $txt);
		 $txt = str_replace("&", "", $txt);
		
		return strtolower($txt);
	}
?>