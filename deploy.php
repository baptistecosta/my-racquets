<?php

require 'recipe/symfony3.php';

serverList('app/deploy/servers.yml');

env('release_path', function () {
    $result = explode("\n", run("readlink {{deploy_path}}/release"));
    $result = ($result[0] != "stdin: is not a tty") ? $result[0] : $result[1];

    return str_replace("\n", '', $result);
});

/**
 * Configuration
 */
set('repository', 'https://github.com/baptistecosta/my-racquets.git');
set('keep_releases', 5);
set('writable_use_sudo', false);
set('shared_files', ['app/config/parameters.yml', 'web/.htaccess']);
set('shared_dirs', ['var/logs', 'var/sessions', 'var/jwt']);

/**
 * Tasks
 */
task('deploy:vendors', function () {
    run('cd {{release_path}} && ./composer.phar install -n');
})->desc('Composer install');

task('deploy:writable', function () {
    run('cd {{release_path}} && chmod -R 777 var/cache');
})->desc('Permissions on cache dir');

task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:create_cache_dir',
    'deploy:shared',
    'deploy:vendors',
    'database:migrate',
    'deploy:cache:warmup',
    'deploy:writable',
    'deploy:symlink',
    'cleanup',
])->desc('Deploy your project');

after('deploy', 'success');
