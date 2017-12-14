<?php
$urls = GetTemplatePath();
?>

<?php
$current_user = wp_get_current_user();

if (0 == $current_user->ID ) { ?>
<div class="container">
    <footer class="text-right">
        <!-- Default to the left -->
        <strong>Soc <i class="fa fa-rocket" aria-hidden="true"></i> Space &copy; 2017 </strong> Все права защищены.
    </footer>
</div>


<?php }
else { ?>
    <!-- Main Footer -->
<footer class="main-footer">
    <!-- Default to the left -->
    <strong>Soc <i class="fa fa-rocket" aria-hidden="true"></i> Space &copy; 2017 </strong> Все права защищены.
</footer>
    </div><!--wrapper-->
<?php } ?>


<!-- REQUIRED JS SCRIPTS -->

<script src="<?php echo $urls['template']; ?>/dist/js/common.min.js"></script>



</body>
</html>