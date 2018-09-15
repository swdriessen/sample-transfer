<script src="/js/jquery-3.3.1.slim.min.js"></script>
<script src="/js/popper.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script>
	$('[data-toggle="tooltip"]').tooltip()
	function serveFile($file) {
		window.location = "/serve/" + $file;
	}
</script>