<div class="ui tab segment" data-tab="server">
  <div class="ui dividing header">
    <i class="server icon"></i>
    <div class="content">
      Server Information
    </div>
  </div>

  @if (!str_contains(phpversion(), "7.4"))
  <div class="ui red icon message">
    <i class="exclamation circle icon"></i>
    <div class="content">
      <div class="header">
        You are running Astral on an unsupported version of PHP!
      </div>
      <p>Make sure you update to the latest PHP 7.4.x series in order to be secure.</p>
    </div>
  </div>
  @endif

  <div class="ui black image label">
    <img src="/astral-logo-light.png" class="ui small image" alt="Astral">
    {{ config('app.version') }}
  </div>

  <div class="ui black label">
    PHP <div class="detail">{{ phpversion() }}</div>
  </div>

  <div class="ui black label">
    Database
    <div class="detail">
      <?php
        $database = config()->get('database.default');
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
    Date and Time <div class="detail">{{ now() }}</div>
  </div>

  <div class="ui black label">
    Timezone <div class="detail">{{ config('app.timezone') }}</div>
  </div>

  <div class="ui dividing header">
    PHP Extensions
  </div>

  @if (!in_array("openssl", get_loaded_extensions()))
  <div class="ui red icon message">
    <i class="exclamation circle icon"></i>
    <div class="content">
      <div class="header">
        You are missing the <div class="ui red basic label">openssl</div> PHP extension!
      </div>
      <p>Make sure it is installed and enabled as Astral's functionality depends on it.</p>
    </div>
  </div>
  @endif

  @if (!in_array("PDO", get_loaded_extensions()))
  <div class="ui red icon message">
    <i class="exclamation circle icon"></i>
    <div class="content">
      <div class="header">
        You are missing the <div class="ui red basic label">PDO</div> PHP extension!
      </div>
      <p>Make sure it is installed and enabled as Astral's functionality depends on it.</p>
    </div>
  </div>
  @endif

  @if (!in_array("mbstring", get_loaded_extensions()))
  <div class="ui red icon message">
    <i class="exclamation circle icon"></i>
    <div class="content">
      <div class="header">
        You are missing the <div class="ui red basic label">mbstring</div> PHP extension!
      </div>
      <p>Make sure it is installed and enabled as Astral's functionality depends on it.</p>
    </div>
  </div>
  @endif

  @if (!in_array("tokenizer", get_loaded_extensions()))
  <div class="ui red icon message">
    <i class="exclamation circle icon"></i>
    <div class="content">
      <div class="header">
        You are missing the <div class="ui red basic label">tokenizer</div> PHP extension!
      </div>
      <p>Make sure it is installed and enabled as Astral's functionality depends on it.</p>
    </div>
  </div>
  @endif

  @if (!in_array("xml", get_loaded_extensions()))
  <div class="ui red icon message">
    <i class="exclamation circle icon"></i>
    <div class="content">
      <div class="header">
        You are missing the <div class="ui red basic label">xml</div> PHP extension!
      </div>
      <p>Make sure it is installed and enabled as Astral's functionality depends on it.</p>
    </div>
  </div>
  @endif

  @if (!in_array("dom", get_loaded_extensions()))
  <div class="ui red icon message">
    <i class="exclamation circle icon"></i>
    <div class="content">
      <div class="header">
        You are missing the <div class="ui red basic label">dom</div> PHP extension!
      </div>
      <p>Make sure it is installed and enabled as Astral's functionality depends on it.</p>
    </div>
  </div>
  @endif

  @foreach (get_loaded_extensions() as $extension)
    <div class="ui basic black label">{{ $extension }}</div>
  @endforeach

  <div class="ui dividing header">
    PHP Settings
  </div>

  <div class="ui basic black label">
    maximum_memory
    <div class="detail">{{ ini_get('memory_limit') }}</div>
  </div>

  <div class="ui basic black label">
    max_execution_time
    <div class="detail">{{ ini_get('max_execution_time') }} seconds</div>
  </div>

</div>