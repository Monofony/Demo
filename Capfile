# Configure required variables for Symfony2 deployment
set :deploy_config_path, 'etc/capistrano/deploy.rb'
set :stage_config_path,  'etc/capistrano/deploy'

# Load DSL and set up stages
require 'capistrano/setup'

# Include default deployment tasks
require 'capistrano/deploy'

# Include tasks from other gems included in your Gemfile
#
# For documentation on these, see for example:
#
#   https://github.com/capistrano/rvm
#   https://github.com/capistrano/rbenv
#   https://github.com/capistrano/chruby
#   https://github.com/capistrano/bundler
#   https://github.com/capistrano/rails
#   https://github.com/capistrano/passenger
#
# require 'capistrano/rvm'
# require 'capistrano/rbenv'
# require 'capistrano/chruby'
# require 'capistrano/bundler'
# require 'capistrano/rails/assets'
# require 'capistrano/rails/migrations'
# require 'capistrano/passenger'

require 'capistrano/symfony'
require 'capistrano/scm/git'
install_plugin Capistrano::SCM::Git
require 'capistrano/nvm'

# Load custom tasks from `etc/capistrano/tasks` if you have any defined
Dir.glob('etc/capistrano/tasks/*.rake').each { |r| import r }
