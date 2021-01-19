@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../laravel/envoy/bin/envoy
php "%BIN_TARGET%" %*
