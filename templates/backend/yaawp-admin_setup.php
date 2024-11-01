<div style="width: 100%; float: left;">
	<form id="yaawp_settings" class="settings" method="POST" style="padding: 0 8px; height: 600px; border-style: solid; border-width: 1px 1px 0; border-color: #dfdfdf #dfdfdf #fff;">
	<div id="titlediv">

		<div class="header">
			<h1><?php echo __('Datenschutz', $this->var_sTextdomain); ?></h1>
		</div>

		<p><?php echo __('Wir wissen, dass Sie als Websitenbetreiber dem Thema
		Datenschutz gro&szlig;e Bedeutung bemessen. Uns ist der Schutz Ihrer pers&ouml;nlichen
		Daten daher ein wichtiges Anliegen. Pers&ouml;nliche Daten, die Sie elektronisch
		&uuml;bermitteln, z.B. Ihre IP-Adresse oder Email-Adresse, werden von uns dem technischen Standard entsprechend
		verwahrt und nicht an Dritte weitergegeben.', $this->var_sTextdomain); ?></p>

		<p><?php echo __('Etwaige Haftungsanspr&uuml;che, welche sich auf Schaden materieller oder ideeller Art
		beziehen, die durch die Nutzung oder Nichtnutzung der dargebotenen Informationen
		bzw. durch die Nutzung fehlerhafter und unvollst&auml;ndiger Informationen verursacht
		wurden, sind grunds&auml;tzlich ausgeschlossen.', $this->var_sTextdomain); ?></p>

		<p><?php echo __('Das Yet Another Amazon Wordpress Plugin befindet sich weiterhin in der Entwicklung, um aktuelle Informationen
		zum Plugin oder zur Pro Version zu erhalten m&ouml;chten wir Sie bitten uns zu erlauben einen IFrame im "Dashboard" des Plugin zu laden.
		<strong>Es werden keinelei Daten von Ihnen &uuml;bertragen bzw. gespeichert!</strong>', $this->var_sTextdomain); ?></p>

		<div style="padding-top:5px;">
			<a href="edit.php?post_type=shop&amp;page=yaawp-einstellungen&amp;yaawp_news=1" name="publish" class="button button-primary button-large"><?php echo __('Ja, ich bin damit einverstanden', $this->var_sTextdomain); ?></a>
			<a href="edit.php?post_type=shop&amp;page=yaawp-einstellungen&amp;yaawp_news=2" name="publish" class="button button-error button-large"><?php echo __('Nein, ich bin nicht damit einverstanden', $this->var_sTextdomain); ?></a>
		</div>

	</div>
</form>
</div>