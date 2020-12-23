<?php
include_once "dtb/dtb.php";
include_once "php/functions/checkAuth.php";
include_once "header.php";
setTitle('Статистика отправки данных');
?>


<section class="main"> 
	<div class='data-div' id='dd1'> 
		<p id='data-text-loading'> Получаю данные<span id='loading-span'>...</span> </p>
		<div class='data-display' id='ddy1' style='display: none;'> </div>
	</div>
</section>


<script src='js/dataPanel.js'></script>
<script type="text/javascript"> 
	getDataCommonInfo()
</script>
</body>
</html>
