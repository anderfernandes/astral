<div class="ui tab segment" data-tab="server">
  <div class="ui dividing header">
    <i class="server icon"></i>
    <div class="content">
      Server Information
    </div>
  </div>
  
  <div class="ui black label">
    Astral Version <div class="detail">{{ config('app.version') }}</div>
  </div>

  <div class="ui black label">
    PHP <div class="detail">{{ phpversion() }}</div>
  </div>

  <div class="ui black label">
    Database
    <div class="detail">
      <?php
        $database = Config::get('database.default');
        switch ($database) {
          case 'sqlsrv': echo 'Microsoft SQL Server'; break;
          case 'sqlite': echo 'SQLite'; break;
          case 'mysql' : echo 'MySQL/MariaDB'; break;
          case 'pgsql' : echo 'PostgreSQL'; break;
        }
      ?>
    </div>
  </div>
  

  <div class="ui black label">
    Timezone <div class="detail">{{ config('app.timezone') }}</div>
  </div>

  <div class="ui dividing header">
    PHP Extensions
  </div>

  @foreach (get_loaded_extensions() as $extension)
    <div class="ui basic black label">{{ $extension }}</div>
  @endforeach

</div>