<?php

require 'recipe/symfony3.php';

serverList('app/deploy/servers.yml');

/**
 * Configuration
 */
set('repository', 'git@bitbucket.org:sefaireaider/trust-api.git');
set('keep_releases', 5);
set('writable_use_sudo', false);
set('shared_files', ['app/config/parameters.yml', 'web/.htaccess']);
set('shared_dirs', ['var/logs', 'var/sessions', 'var/jwt']);

/**
 * Tasks
 */
task('deploy:vendors', function () {
    run('cd {{release_path}} && composer install');
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
    'deploy:cache:warmup',
    'deploy:writable',
    'deploy:symlink',
    'cleanup',
])->desc('Deploy your project');

after('deploy:vendors', 'database:migrate');
after('deploy', 'success');
