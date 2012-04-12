require "new_relic/recipes"

server "p.pol-nl.be", :app, :web, :db, :primary => true

set :rails_env, "production"
set :branch, "master"

after "deploy:update", "newrelic:notice_deployment"