<?php

$ldap_host = getenv('LDAP_HOST');
$ldap_domain = getenv('LDAP_DOMAIN');

$ldap_group_user_dn = getenv('LDAP_GROUP_USER_DN');
$ldap_group_admin_dn = getenv('LDAP_GROUP_ADMIN_DN');

$db_cristal_host = getenv('BDD_CRISTAL_HOST');
$db_cristal_user = getenv('BDD_CRISTAL_USER');
$db_cristal_password = getenv('BDD_CRISTAL_USER_PASSWORD');
$db_cristal_base = getenv('BDD_CRISTAL_BASE');

$db_bridge_host = getenv('BDD_BRIDGE_HOST');
$db_bridge_user = getenv('BDD_BRIDGE_USER');
$db_bridge_password = getenv('BDD_BRIDGE_USER_PASSWORD');
$db_bridge_base = getenv('BDD_BRIDGE_BASE');

$db_bridge_dsn = "sqlsrv:Server=$db_bridge_host;Database=$db_bridge_base;Encrypt=1;TrustServerCertificate=yes;";
// le encrypt =Ça crypte la connexion, comme si on mettait ton message dans une boîte fermée à clé

$db_cristal_dsn  = "sqlsrv:Server=$db_cristal_host;Database=$db_cristal_base;Encrypt=1;TrustServerCertificate=yes;";