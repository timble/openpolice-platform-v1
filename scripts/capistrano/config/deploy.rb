set :application, "staging"
set :repository,  "git@git.assembla.com:timble-police.git"

set :scm, :git

role :web, "s.pol-nl.be"
role :app, "s.pol-nl.be"
role :db,  "s.pol-nl.be", :primary => true

set :user, "capistrano"
set :port, 9999
set :use_sudo, false

set :deploy_to, "/var/www/capistrano"
set :branch, "develop"


# If you are using Passenger mod_rails uncomment this:
# namespace :deploy do
#   task :start do ; end
#   task :stop do ; end
#   task :restart, :roles => :app, :except => { :no_release => true } do
#     run "#{try_sudo} touch #{File.join(current_path,'tmp','restart.txt')}"
#   end
# end
