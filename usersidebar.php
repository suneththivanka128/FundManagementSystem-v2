<link rel="stylesheet" href="css/sidebar.css">

<aside class="sidebar">
    <div class="logo">
        <img src="images/logocolor.png" alt="Logo">
    </div>
    <nav>
        <ul>
            <?php
            $current_page = basename($_SERVER['PHP_SELF']);
            $menu_items = include 'config/user_menu_items.php';
            
            foreach ($menu_items as $page => $title) {
                $active_class = ($current_page === $page) ? 'active' : '';
                echo "<li><a href=\"$page\" class=\"$active_class\">$title</a></li>";
            }
            ?>
        </ul>
    </nav>
</aside>
