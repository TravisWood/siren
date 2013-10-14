<header class="clearfix left">
    <nav>
        <ul>
            <? if ($_SESSION['type'] == 'admin'): ?>
    		<li><a href="manage.php">Manage</a></li>
    		<? endif; ?>
            <li><a href="reports.php">Reports</a></li>
        </ul>
    </nav>        
</header>