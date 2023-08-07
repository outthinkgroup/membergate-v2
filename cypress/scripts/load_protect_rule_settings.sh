#! /usr/bin/env bash

wp eval-file cypress/scripts/php/load_rule.php $1 --path="../site/app/public";
exit 0;
