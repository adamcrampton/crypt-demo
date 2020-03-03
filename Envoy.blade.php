@include('vendor/autoload.php');

@setup
  $dotenv = Dotenv\Dotenv::create(__DIR__);
  $dotenv->load();
  $server = env('AWS_ENVOY');
@endsetup

@servers(['web' => $server])

@task('list', ['on' => 'web'])
    ls -l
@endtask
