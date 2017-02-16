<?php

// suppressing warnings (because fsockopen will also dump garbage on fail)
error_reporting(E_ALL ^ E_WARNING);

// validating that env vars are available
$envVarNames = [
    'APP_PORT',
    'APP_LOG_DIR',
    'DATABASE_HOST'
];
$envVars = array_combine($envVarNames, array_map(function($name) {
  return getenv($name);
}, $envVarNames));
$missingEnvVars = array_filter($envVars, function($value) {
  return $value === false || strlen($value) === 0;
});

if (count($missingEnvVars) > 0) {
  foreach ($missingEnvVars as $name => $value) {
    printf("%s was missing\n", $name);
  }

  exit(1);
}

// validating that the database port is accessible
$dbPort = 5432;
$fp = fsockopen($envVars["DATABASE_HOST"], $dbPort);
if ($fp === false) {
  printf("%s was not accessible at %s\n", $envVars["DATABASE_HOST"], $dbPort);

  exit(1);
}
fclose($fp);

// validating that the log dir exists
if (!file_exists($envVars["APP_LOG_DIR"])) {
  printf("%s log dir does not exist\n", $envVars["APP_LOG_DIR"]);

  exit(1);
}

exit(0);