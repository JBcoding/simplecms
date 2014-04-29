<div id="clear"></div>
            <footer>
                <p id="powered">Proudly powered by</p>
                <a class="no_underline"href="http://www.jbcoding.com"><img id="logo" src="Logo.png"/></a>
                <p><a href="http://www.jbcoding.com">JBcoding</a></p>
            </footer>
        </section>
        <script src="checks.js"></script>
</body>
</html>

<?php
	if(isset($connection)) {
		mysql_close($connection);
	}
?>