<?php
setcookie("login","",time()-3600);
setcookie("pword","",time()-3600);
?>

<?php
session_start();

if(session_destroy()) // Destroying All Sessions

{
header("Location: index.php"); // Redirecting To Home Page
}
?>

<script type="text/javascript">
window.location="index.php";
</script>