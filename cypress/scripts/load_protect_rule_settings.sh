#! /usr/bin/env bash
echo "Loading rule settings from $1";
wp eval-file cypress/scripts/php/load_rule.php $1;
exit 0;
