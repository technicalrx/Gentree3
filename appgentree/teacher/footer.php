<footer id="footer">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center footr">
						<p>copyright &copy; GenTree 2016</p>
					</div>
				</div>
			</div>
		</footer>
		<script type="text/javascript">
			var headerHeight = document.getElementById('header').offsetHeight;
			var footerHeight = document.getElementById('footer').offsetHeight;
			var windowHeight = window.innerHeight;
			var contentHeight = windowHeight-(headerHeight+footerHeight);
			document.getElementById('content-1').style.height=contentHeight+"px";
		</script>
	</body>
</html>