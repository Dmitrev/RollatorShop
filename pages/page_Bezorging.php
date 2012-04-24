<?php

class page_Bezorging{
	public $title = 'Bezorging';

	public function __construct(){
		$this->content = '<h1>Bezorging</h1>
					<p>Alle producten worden normaal gesproken binnen 10 werkdagen geleverd.</p>

					<h2>Uitzonderingen</h2>
					<ul>
						<li>Een product is niet op voorraad</li>
						<li>Feestdagen</li>
					</ul>

					<h3>Product niet op voorraad</h3>
					<p>Als uw bestelde product niet op voorraad is, wordt deze meteen besteld en nemen. 
					Wij bellen u over de levertijd, u hoeft niet zelf contact met ons op te nemen. </p>

					<h3>Feestdagen</h3>
					<p>Tijdens Feestdagen wordt er niet bezorgd, de levering wordt dan 1 dag uitgesteld.</p>

				';
	}
}

?>