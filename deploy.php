<?php
namespace Deployer;
require 'recipe/laravel.php';

// Configuration
set('keep_releases', 5);
set('ssh_type', 'native');
set('ssh_multiplexing', true);

set('repository', 'https://turtle.do-johodai.ac.jp/gitea/s1512073/dropitems.git');

add('shared_files', []);
add('shared_dirs', []);

add('writable_dirs', []);

// Servers

server('production', '192.168.1.9', 22)
    ->user('nishi')
    ->identityFile()
    ->set('deploy_path', '/home/nishi/nginx/html/dropitems')
    ->pty(true);

task('mytask', function() {
    writeln('<info>php artisan storage:link</info>');
    run('{{bin/php}} {{release_path}}/artisan storage:link');
});

after('deploy:unlock', 'mytask');

/**
 * Upload .env.production file as .env
 */
//task('deploy:upload', function() {
//    upload('.env.production', '/home/nishi/nginx/html/dropitems/shared/.env');
//});
//
//before('deploy', 'deploy:upload');

// Tasks

//desc('Restart PHP-FPM service');
//task('php-fpm:restart', function () {
//    // The user must have rights for restart service
//    // /etc/sudoers: username ALL=NOPASSWD:/bin/systemctl restart php-fpm.service
//    run('sudo systemctl restart php-fpm.service');
//});
//after('deploy:symlink', 'php-fpm:restart');
//
//// [Optional] if deploy fails automatically unlock.
//after('deploy:failed', 'deploy:unlock');
//
//// Migrate database before symlink new release.
//
//before('deploy:symlink', 'artisan:migrate');
