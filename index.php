<?php
require("db.php");
echo '<link rel="stylesheet" href="./styles/styles.css">';

echo "<body>";
echo '<div class="Nav">
<div class="Buttons">
<form action="" method="get">
<input type="submit" name="employees" value="Employees">
<input type="submit" name="projects" value="Projects">';
if(isset($_GET['employees']) or isset($_GET['addProject']) or isset($_GET['update'])){
    echo '<input type="submit" name="addEmployees" value="Add Employees">';
} elseif (isset($_GET['projects']) or isset($_GET['addEmployees']) or isset($_GET['full']) or isset($_GET['updateProject'])) {
    echo '<input type="submit" name="addProject" value="Add Project">';
}
echo '</form></div></div>';

if($_SERVER['REQUEST_URI'] == "/mysqli/" or $_SERVER['REQUEST_URI'] == "/mysqli/index.php"){
    echo '<meta http-equiv="Refresh" content="0; url=?employees=Employees">';
}

echo "</body>";