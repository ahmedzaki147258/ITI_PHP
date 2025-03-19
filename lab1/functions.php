<?php
  function filtersRequest($requestName): string {
    if(is_array($_POST[$requestName])) return implode(', ', $_POST[$requestName]);
    return trim(htmlspecialchars(strip_tags($_POST[$requestName])));
  }
