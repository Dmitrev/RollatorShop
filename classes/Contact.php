<?php

class Contact{
	public $message;
	private $sent = false;

	public function __construct($a, $b, $c){
		$this->formValidation = new formValidation;
		if(isset($_POST[$a]) && isset($_POST[$b]) && isset($_POST[$c])){
			$this->setValues($a, $b, $c);
			$this->checks();
		}
		else{
			$this->resetValues();
		}
		
	}

	private function resetValues(){
		$this->values = array('name' => '', 'subject' => '', 'message' => '');
	}

	private function setValues($a, $b, $c){

		$this->values = array('name' => $_POST[$a], 'subject' => $_POST[$b], 'message' => $_POST[$c]);
	} 

	private function checks(){
		if($this->values['name'] !== '' && $this->values['subject'] !== '' && $this->values['message'] !== ''){
			if(!$this->formValidation->valid_name($this->values['name'])){
				$this->message = 'Uw naam bevat tekens die niet zijn toegestaan.';
			}
			elseif(strlen($this->values['message']) < 20){
				$this->message = 'Het bericht mag niet korter zijn dan 20 tekens';
			}
			else{
				$this->sendContact();
			}
		}
		else{
			$this->message = 'Graag alle velden invullen';
		}
	}

	private function sendContact(){

		$query = mysql_query("INSERT INTO contact VALUES(
															'', 
															'".mysql_real_escape_string($this->values['name'])."',
															'".mysql_real_escape_string($this->values['subject'])."',
															'".mysql_real_escape_string($this->values['message'])."',
															'".$_SERVER['REMOTE_ADDR']."',
															NOW())");

		if(!$query){
			$this->message = 'LALALALALA';
		}
		else{
			$this->sent = true;
		}
	}

	public function createForm(){
		if($this->sent === true){
			return 'Ewa '.$this->values['name'].', wij contacten je nog wel..';
		}
		else{
			return  '<form action="" method="post">
					<table>
						<tr>
							<td>Uw naam: </td>
							<td><input type="text" name="c_name" value="'.$this->values['name'].'" />
						</tr>
						<tr>
							<td>Onderwerp: </td>
							<td><input type="text" name="c_subject" value="'.$this->values['subject'].'" /></td>
						</tr>
						<tr>
							<td>Bericht: </td>
							<td><textarea name="c_message">'.$this->values['message'].'</textarea></td>
						</tr>
						<tr>
							<td></td>
							<td>
								<input type="submit" value="versturen" />
							</td>
						</tr>
					</table>
				</form>';
		}	
	}
}

?>