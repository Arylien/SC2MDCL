<?
echo '
			<div id="footer">
				<script type="text/javascript">
					$(document).ready(function(){
						
						var str=location.href.toLowerCase();
						
						$("#menu li a").each(function() {
							if (str.indexOf(this.href.toLowerCase()) > -1) {
								$("li a.active").removeClass("highlight");
								$(this).parent().addClass("highlight");
							}
						});
						
						$("li a.active").parents().each(function(){
							if ($(this).is("a")){
								$(this).addClass("highlight");
							}
						});
					})

				</script>
					<div class="box">
						<p>Designed and Developed by <a href="mailto:Saeris@comcast.net">Drake Costa</a> &#169;2012-2013 | Released under a <a href="http://creativecommons.org/licenses/by-nc-nd/3.0/">Creative Commons License</a> | StarCraft and all related imagry are Copyright/Trademark of <a href="http://us.blizzard.com/en-us/">Blizzard Entertainment</a></p>
					</div>
			</div>
		</div>
	</body>
';

?>