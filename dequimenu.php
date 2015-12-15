<?php
	function dequy($data, $parent){
		foreach ($data as $value) {
			# code...
			if($value['parent']==$parent){
				echo "$value['name]"."</br>";
				$id=$value['id'];
				dequy($data,$id);
			}
		}
	}
	foreach ($variable as $value) {
		# code...
		if($variable['parent']==0){
			echo $value['name'];
			$id=$value['id'];
			dequy($variable,$id);
		}
	}
?>