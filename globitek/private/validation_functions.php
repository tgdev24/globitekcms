<?php

  // is_blank('abcd')
  function is_blank($value='') {
    // TODO
      return !isset($value) || trim($value) == '';
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  function has_length($value, $options=array()) {
    // TODO
      $length = strlen($value);
    if(isset($options['max']) && ($length > $options['max'])) 
      return false;
    
    elseif(isset($options['min']) && ($length < $options['min'])) 
      return false;
    
    elseif(isset($options['exact']) && ($length != $options['exact'])) 
      return false;
    
    else 
      return true;
  }

  // has_valid_email_format('test@test.com')
  function has_valid_email_format($value) {
    // TODO
      return filter_var($value, FILTER_VALIDATE_EMAIL);
  }
  
  function exists($value) {
    $value = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    global $db;
    $sql = "SELECT * FROM users ";
    $sql .= "WHERE username='" . $value . "';";
    $query = db_query($db, $sql);
    while ($result = $query->fetch_assoc()) {
      if ($value == $result['username']) {
        return true;
      }
    }
    return false;
  }

?>
