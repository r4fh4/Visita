		</div>
		<div id="footer">
			<?php if($no_footer) { ?>
				TODOS OS DIREITOS RESERVADOS<br />
				VISITASANTOS.COM <?=date('Y');?>
			<?php } else { ?>
			<div id='box-footer'>
				<ul id='option-list'>
					<li>
						<input type="button" class="btn-option blue" value="Informações" id='info'>
					</li>
					<li>
						<a href="<?=$base_url_site;?>logout">
							<input type="button" class="btn-option red" value="Log Out" id='logout'>
						</a>
					</li>
				</ul>
				<br class='clean' />
			</div>
			<?php } ?>
		</div>
	</body>
</html>