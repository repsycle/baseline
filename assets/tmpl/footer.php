<?php
//Check if this is called from the application
if(!defined('SPF'))
{
	header('Location:/');
	exit();
}
$execTime = '';
if (isset($time_start))
{
	$time_end = microtime_float();
	$time = $time_end - $time_start;
	$execTime = "Page generated in " . round($time, 2) . " seconds.";
} 
?>
	<hr />
	<footer>
		<h5>
			<small><?php echo $execTime; ?>&nbsp;<?php echo Options::get('siteName'); ?></small>
		</h5>
		<p>Running on a project called <a class="small" href='https://github.com/drpain/baseline' target="_blank">Baseline</a>, building on awesome building blocks. Namely
		<a href='http://twitter.github.com/bootstrap/index.html' target="_blank">Bootstrap from Twitter</a> and the equally awesome
		<a href='https://github.com/tylerhall/simple-php-framework/' target="_blank">Simple PHP Framework</a>.
		</p>	
	</footer>

    </div><!--/.fluid-container-->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/cookies.js"></script>     
    <script src="assets/js/jquery.js"></script>    
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <!--<script src="assets/js/bootstrap-scrollspy.js"></script>-->
    <script src="assets/js/bootstrap-tab.js"></script>
    <!--<script src="assets/js/bootstrap-tooltip.js"></script>-->
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <!--<script src="assets/js/bootstrap-carousel.js"></script>-->
    <script src="assets/js/bootstrap-typeahead.js"></script>

  </body>
</html>