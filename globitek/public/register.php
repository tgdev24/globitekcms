<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.
    $firstname = $lastname = $username = $email = "";

  // if this is a POST request, process the form
  if (is_post_request()) {
  // Hint: private/functions.php can help
        $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
        $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
        $username = isset($_POST['username']) ? $_POST['username'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $errors = [];
        
        if (is_blank($_POST['firstname'])) {
            $errors[] = "First name cannot be blank.";
        } 
        elseif (!has_length($_POST['firstname'], ['min' => 2, 'max' => 255])) {
            $errors[] = "First name must be between 2 and 255 characters.";
        }
        if (is_blank($_POST['lastname'])) {
            $errors[] = "Last name cannot be blank.";
        } 
        elseif (!has_length($_POST['lastname'], ['min' => 2, 'max' => 255])) {
            $errors[] = "Last name must be between 2 and 255 characters.";
        }
        if (is_blank($_POST['username'])) {
            $errors[] = "Username cannot be blank.";
        } 
        elseif (!has_length($_POST['username'], ['min' => 8])) {
            $errors[] = "Username must be at least 8 characters.";
        } 
        elseif (!has_length($_POST['username'], ['max' => 255])) {
            $errors[] = "Username must less than 255 characters.";
        }
        elseif (exists($_POST['username'])) {
            $errors[]= "Username already exists.";
        }
    
        if (is_blank($_POST['email'])) {
            $errors[] = "Email cannot be blank.";
        } 
        elseif (!has_valid_email_format($_POST['email'])) {
            $errors[] = "Email must be a valid form.";
        }
        
        
  

  

  
    // Confirm that POST values are present before accessing them.

    // Perform Validations
    // Hint: Write these in private/validation_functions.php

    // if there were no errors, submit data to database
        if(empty($errors)){
            $created_at = date("Y-m-d H:i:s");
            $firstname = filter_var($firstname, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $lastname = filter_var($lastname, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            $username = filter_var($username, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      // Write SQL INSERT statement
      $sql = "INSERT INTO users (first_name, last_name, email, username, created_at) VALUES (";
      $sql .= "'{$firstname}', '{$lastname}', '{$email}', '{$username}', '{$created_at}')";

      // For INSERT statments, $result is just true/false
      $result = db_query($db, $sql);
      if($result) {
        db_close($db);

      //  TODO redirect user to success page
        redirect_to( './registration_success.php' );

      } else {
      //   // The SQL INSERT statement failed.
      //   // Just show the error, not the form
        echo db_error($db);
        db_close($db);
        exit;
        }
        }      
}

?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <?php
    // TODO: display any form errors here
    // Hint: private/functions.php can help
    if (isset($errors)){
      $error = display_errors($errors);
      if ($error != '') { echo $error; }
    }
  ?>

  <!-- TODO: HTML form goes here -->
<form action="register.php"  method="post">
    First name:<br>
    <input type="text" name="firstname" value="<?php if (isset($firstname)) { echo ($firstname); } ?>"><br>
    Last name:<br>
    <input type="text" name="lastname" value="<?php if (isset($lastname)) { echo ($lastname); } ?>"><br>
    Username:<br>
    <input type="text" name="username" value="<?php if (isset($username)) { echo ($username); } ?>"><br>
    Email:<br>
    <input type="text" name="email" value="<?php if (isset($email)) { echo ($email); } ?>"><br><br>
    <input type="submit" name="submit" value="Submit">
</form>

</div>



<?php include(SHARED_PATH . '/footer.php'); ?>
