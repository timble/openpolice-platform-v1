# Stages settings.
require "capistrano/ext/multistage"

set :stages, ["staging", "production"]
set :default_stage, "staging"

set :application, "portal"

# Server user settings.
set :user, "deploy"
set :port, 9999
set :use_sudo, false

# Deployment settings.
set :deploy_to, "/var/www/capistrano"
set :deploy_via, :remote_cache
set :keep_releases, 3

# Repository settings.
set :repository,  "git@git.assembla.com:timble-police.git"
set :scm, :git
set :scm_username, "deploy@timble.net"
set :branch, "develop"

namespace :deploy do
    # Overwrite :finalize_update to prevent unrelevant command executions.
    task :finalize_update, :roles => :app, :except => { :no_release => true } do
        run "chmod -R g+w #{release_path}" if fetch(:group_writable, true)
    end
    
    # Create symbolink links for shared directories.
    task :symlink_shared, :roles => :app do
        run "ln -nfs #{shared_path}/cache #{release_path}/code/cache"
        run "ln -nfs #{shared_path}/sites #{release_path}/code/sites"
        run "ln -nfs #{shared_path}/configuration.php #{release_path}/code/configuration.php"
    end
    
    # Do nothing in these tasks.
    task :migrate do; end
    task :migrations do; end
    task :cold do; end
    task :start do; end
    task :stop do; end
    task :restart do; end
end

# Hook into default tasks.
after "deploy:update_code", "deploy:symlink_shared"
after "deploy:update", "deploy:cleanup"