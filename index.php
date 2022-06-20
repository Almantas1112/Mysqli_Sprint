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

if (isset($_GET['employees'])) {
    $retrive_employees = "SELECT employees.id as id, employees.name as name, projects.project_name as project
    FROM employees, projects
    WHERE employees.project_id=projects.id;";
    $result = mysqli_query($conn, $retrive_employees);
    if(mysqli_num_rows($result)==0){
        echo "No Employees found!";
    } else {
        echo "<table style='font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse; width: 99.99%; margin-top: 2rem; text-align: center;'>";
        echo "<tr style='text-transform: uppercase;'>";
        echo "<th style='padding-top: 12px;padding-bottom: 12px;
        background-color: #04AA6D;color: white;'>ID</th>";
        echo "<th style='padding-top: 12px;padding-bottom: 12px;
        background-color: #04AA6D;color: white;'>Name</th>";
        echo "<th style='padding-top: 12px;padding-bottom: 12px;
        background-color: #04AA6D;color: white;'>Project</th>";
        echo "<th style='padding-top: 12px;padding-bottom: 12px;
        background-color: #04AA6D;color: white;'>Action</th>";
        echo "</tr>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
            echo "<td style='border: 1px solid #ddd;padding: 8px;'>".$row['id']."</td>";
            echo "<td style='border: 1px solid #ddd;padding: 8px;'>".$row['name']."</td>";
            echo "<td style='border: 1px solid #ddd;padding: 8px;'>".$row['project']."</td>";
            echo '<td style="border: 1px solid #ddd;padding: 8px;">
            <form action="" method="post" style="display: inline;">
            <input type="hidden" name="delete" value="'.$row['name'].'">
            <input type="submit" value="Delete">
            </form>
            <form action="" method="get" style="display: inline;">
            <input type="hidden" name="update" value="'.$row['name'].'">
            <input type="submit" value="Update">
            </form>
            </td>';
            echo "</tr>";
        }
        echo "</table>";
        if (isset($_POST['delete'])){
            $name = $_POST['delete'];
            $delete_employee = "DELETE FROM employees WHERE name = '$name';";
            mysqli_query($conn,$delete_employee);
            mysqli_close($conn);
            ob_start();
            header('Location: ?employees=Employees');
            ob_end_flush();
            die();
        }
    }
} elseif (isset($_GET['projects'])) {
    $retrive_projects = "SELECT employees.project_id as id, projects.project_name as name, employees.name as employee
    FROM employees, projects
    WHERE employees.project_id=projects.id AND employees.project_id > 0
    ORDER BY id;";
    $res = mysqli_query($conn, $retrive_projects);
    if(mysqli_num_rows($res)==0){
            $full_projects = "SELECT * FROM projects WHERE id > 0;";
            $full = mysqli_query($conn, $full_projects);
            echo "<table style='font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse; width: 99.99%; margin-top: 2rem; text-align: center;'>";
            echo "<tr style='text-transform: uppercase;'>";
            echo "<th style='padding-top: 12px;padding-bottom: 12px;
            background-color: #04AA6D;color: white;'>ID</th>";
            echo "<th style='padding-top: 12px;padding-bottom: 12px;
            background-color: #04AA6D;color: white;'>Project</th>";
            echo "<th style='padding-top: 12px;padding-bottom: 12px;
            background-color: #04AA6D;color: white;'>Action</th>";
            echo "</tr>";
        while($row = mysqli_fetch_array($full)){
            echo "<tr>";
            echo "<td style='border: 1px solid #ddd;padding: 8px;'>".$row['id']."</td>";
            echo "<td style='border: 1px solid #ddd;padding: 8px;'>".$row['project_name']."</td>";
            echo '<td style="border: 1px solid #ddd;padding: 8px;">
            <form action="" method="post" style="display: inline;">
            <input type="hidden" name="deleteProject" value="'.$row['id'].'">
            <input type="submit" value="Delete">
            </form>
            <form action="" method="post" style="display: inline;">
            <input type="submit" name="update" value="Update">
            </form>
            </td>';
            echo "</tr>";
        }
    } else {
        echo "<table style='font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse; width: 99.99%; margin-top: 2rem; text-align: center;'>";
        echo "<tr style='text-transform: uppercase;'>";
        echo "<th style='padding-top: 12px;padding-bottom: 12px;
        background-color: #04AA6D;color: white;'>ID</th>";
        echo "<th style='padding-top: 12px;padding-bottom: 12px;
        background-color: #04AA6D;color: white;'>Project</th>";
        echo "<th style='padding-top: 12px;padding-bottom: 12px;
        background-color: #04AA6D;color: white;'>Employee</th>";
        echo "</tr>";
        while($rows = mysqli_fetch_assoc($res)){
            echo "<tr>";
            echo "<td style='border: 1px solid #ddd;padding: 8px;'>".$rows['id']."</td>";
            echo "<td style='border: 1px solid #ddd;padding: 8px;'>".$rows['name']."</td>";
            echo "<td style='border: 1px solid #ddd;padding: 8px;'>".$rows['employee']."</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<form action='' method='GET'>
        <div style='text-align:center; font-size: 3.5rem;'>
        <label for='full'>Show full list of projects: </label>
        </div>
        <div style='text-align:center;'>
        <input type='submit' name='full' value='Show'>
        </div>
        </form>";
    }
    mysqli_close($conn);
}

if (isset($_GET['update'])){
    $name = $_GET['update'];
    $project = "SELECT * FROM projects;";
    $result = mysqli_query($conn,$project);
    echo '<div class="updatingEmployees">
    <form action="" method="post">
    <label for="newName">New name for '.$name.' will be:</label>
    <input type="text" name="newName" value="'.$name.'">
    <label for="newProject">And new project will be:</label>
    <select name="newProject">';
        while ($row = mysqli_fetch_array($result)){
            echo '<option value="'.$row['id'].'">'.$row['project_name'].'</option>';
        }
    echo '</select>
    <input type="hidden" name="submit" value="'.$name.'">
    <input type="submit" value="Submit">
    </form></div>';
    if(isset($_POST['submit'])){
        $oldName = $_POST['submit'];
        $newName = $_POST['newName'];
        $newProject = $_POST['newProject'];
        $update = "UPDATE employees SET name='$newName', project_id=$newProject WHERE name='$oldName';";
        mysqli_query($conn,$update);
        mysqli_close($conn);
        ob_start();
        header('Location: ?employees=Employees');
        ob_end_flush();
        die();
    }
}

if (isset($_GET['updateProject'])){
    $name = $_GET['updateProject']; //id
    echo '<div class="updatingProject">
    <form action="" method="post">
    <label for="newName">New project name will be:</label>
    <input type="text" name="newName">
    <input type="hidden" name="submit" value="'.$name.'">
    <input type="submit" value="Submit">
    </form></div>';
    if(isset($_POST['submit'])){
        $oldProjectID = $_POST['submit'];
        $newProjectName = $_POST['newName'];
        $update = "UPDATE projects SET project_name='$newProjectName' WHERE id='$oldProjectID';";
        mysqli_query($conn,$update);
        mysqli_close($conn);
        ob_start();
        header('Location: ?full=Show');
        ob_end_flush();
        die();
    }
}

if(isset($_GET['full'])){
    $full_projects = "SELECT * FROM projects WHERE id > 0;";
    $full = mysqli_query($conn, $full_projects);
    if(mysqli_num_rows($full)==0){
        echo "No projects found!";
    } else {
        echo "<table style='font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse; width: 99.99%; margin-top: 2rem; text-align: center;'>";
        echo "<tr style='text-transform: uppercase;'>";
        echo "<th style='padding-top: 12px;padding-bottom: 12px;
        background-color: #04AA6D;color: white;'>ID</th>";
        echo "<th style='padding-top: 12px;padding-bottom: 12px;
        background-color: #04AA6D;color: white;'>Project</th>";
        echo "<th style='padding-top: 12px;padding-bottom: 12px;
        background-color: #04AA6D;color: white;'>Action</th>";
        echo "</tr>";
        while($row = mysqli_fetch_array($full)){
            echo "<tr>";
            echo "<td style='border: 1px solid #ddd;padding: 8px;'>".$row['id']."</td>";
            echo "<td style='border: 1px solid #ddd;padding: 8px;'>".$row['project_name']."</td>";
            echo '<td style="border: 1px solid #ddd;padding: 8px;">
            <form action="" method="post" style="display: inline;">
            <input type="hidden" name="deleteProject" value="'.$row['id'].'">
            <input type="submit" value="Delete">
            </form>
            <form action="" method="get" style="display: inline;">
            <input type="hidden" name="updateProject" value="'.$row['id'].'">
            <input type="submit" value="Update">
            </form>
            </td>';
            echo "</tr>";
        }
        echo "</table>";
        echo "<form action='' method='GET'>
        <div style='text-align:center; font-size: 3.5rem;'>
        <label for='projects'>Press here to get back: </label>
        </div>
        <div style='text-align:center;'>
        <input type='submit' name='projects' value='Back'>
        </div>
        </form>";
    }
    if (isset($_POST['deleteProject'])){
        $name = $_POST['deleteProject'];
        $delete_project = "DELETE FROM projects WHERE id = '$name';";
        $update_employee = "UPDATE employees SET project_id = 0 WHERE project_id = '$name';";
        mysqli_query($conn,$delete_project);
        mysqli_query($conn,$update_employee);
        ob_start();
        header('Location: ?full=Show');
        ob_end_flush();
        die();
    }
    mysqli_close($conn);
}

echo "</body>";