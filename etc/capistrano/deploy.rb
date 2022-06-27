# config valid only for current version of Capistrano
lock '>= 3.11.0'

set :symfony_directory_structure, 3
set :sensio_distribution_version, 5

set :format_options, log_file: "var/log/capistrano.log"

# symfony-standard edition directories
set :config_path, "config"
set :web_path, "public"
set :var_path, "var"
set :bin_path, "bin"

# The next 3 settings are lazily evaluated from the above values, so take care
# when modifying them
set :log_path, "var/log"
set :cache_path, "var/cache"

set :symfony_console_path, "bin/console"
set :symfony_console_flags, "--no-debug"

# asset management
set :assets_install_path, "public"
set :assets_install_flags,  '--symlink'

# Share files/directories between releases
set :linked_files, ['.env.local']
set :linked_dirs, ["var/log", "var/sessions", "public/media"]

set :application, 'monofony_demo'
set :repo_url, 'git@github.com-monofony-demo:monofony/demo.git'

# Default branch is :master
ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp

set :deploy_to, '/home/monofony/demo'

# Default value for :scm is :git
# set :scm, :git

# Default value for :format is :pretty
# set :format, :pretty

# Default value for :log_level is :debug
# set :log_level, :debug

# Default value for :pty is false
set :pty, true

set :nvm_type, :user
set :nvm_node, 'v14.19.3'
set :nvm_map_bins, %w{node npm yarn}

append :linked_files, fetch(:web_path) + '/robots.txt'
append :linked_dirs, fetch(:web_path) + '/media'

set :file_permissions_paths, ["var", "var/log", "public/media"]
set :file_permissions_users, ["www-data"]

set :permission_method,   :acl
set :use_set_permissions, true

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Add extra environment variables:
# set :default_env, {
#  'APP_ENV' => 'prod',
#  'APP_SECRET' => 'foobar'
# }

set :keep_releases, 3

namespace :deploy do

  after :restart, :clear_cache do
    on roles(:web), in: :groups, limit: 3, wait: 10 do
      # Here we can do anything such as:
      # within release_path do
      #   execute :rake, 'cache:clear'
      # end
    end
  end

end

namespace :deploy do
  task :migrate do
    invoke 'symfony:console', 'doctrine:migrations:migrate', '--no-interaction', 'db'
  end
end

before "deploy:updated", "deploy:set_permissions:acl"

after 'deploy:updated', :post_deploy do
   on roles(:web) do
       puts "Build assets"
       within release_path do
           execute :yarn, "install"
           execute :yarn, "build"
       end
   end
end

after 'deploy:updated', :post_deploy do
   on roles(:web) do
       puts "Dump env vars"
       execute "cd #{release_path} && composer dump-env prod"
   end
end

after 'deploy:updated', 'symfony:assets:install'
after 'deploy:updated', 'deploy:migrate'

set :branch do
  puts "Ten last tags are:"
  puts `git tag --sort=creatordate | tail -10`
  default_tag = `git tag --sort=creatordate`.split("\n").last
  tag = nil
  set :tag, ask("the server-pushed tag to deploy", default_tag)
  tag = fetch :tag
  tag_commit = `git rev-list -n 1 #{tag}`.chomp
  puts "The following tag is going to be deployed : #{tag} -> #{tag_commit}"
  tag_commit
end