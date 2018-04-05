<?php

namespace Deployer;

require 'recipe/symfony4.php';

set('ssh_multiplexing', true);

// Project name
set('application', 'forum');

// Environment vars
set('env', [
    'APP_ENV' => 'prod'
]);
set('composer_options', '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --no-dev --optimize-autoloader  --ignore-platform-reqs');

// Project repository
set('repository', 'https://github.com/OrbitronDev/service-forum.git');
set('branch', 'master');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
add('shared_files', ['.htaccess']);
add('shared_dirs', []);

// Writable dirs by web server 
//add('writable_dirs', []);
set('writable_dirs', []);

// Hosts
host('local')
    ->set('deploy_path', '/var/www/html/{{application}}')
    ->set('http_user', 'www-data');

// Tasks
task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.
//before('deploy:symlink', 'database:migrate');