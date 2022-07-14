<?php

function hasRole(AuthLogin $login, $role) {
	return $login->hasRoles(array($role));
}
