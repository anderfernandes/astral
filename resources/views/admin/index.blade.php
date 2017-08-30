@extends('layout.admin')

@section('title', 'Dashboard')

@section('subtitle', Auth::user()->firstname.' '. Auth::user()->lastname)

@section('icon', 'dashboard')

@section('content')

  <div class="ui icon message">
    <i class="sun icon"></i>
    <div class="content">
      <div class="header">
        Welcome, {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}!
      </div>
      <p>Why don't you start by clicking the menu button at the top left of the screen?</p>
    </div>
  </div>

  <div class="ui three column stackable grid">
    <div class="column">
      <div class="ui segments">
        <div class="ui inverted center aligned segment">
          <div class="ui inverted huge centered statistic">
            <div class="value">{{ \App\Show::all()->count() }}</div>
            <div class="label">Shows</div>
          </div>
          <div class="ui two column grid">
            <div class="column">
              <div class="ui mini inverted statistic">
                <div class="value">{{ \App\Show::where('type', 'Planetarium')->count() }}</div>
                <div class="label">Planetarium</div>
              </div>
            </div>
            <div class="column">
              <div class="ui mini inverted statistic">
                <div class="value">{{ \App\Show::where('type', 'Laser Light')->count() }}</div>
                <div class="label">Laser Light</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="ui segments">
        <div class="ui inverted center aligned segment">
          <div class="ui inverted huge centered statistic">
            <div class="value">{{ \App\User::all()->count() - 1 }}</div>
            <div class="label">Users</div>
          </div>
          <div class="ui three column grid">
            <div class="column">
              <div class="ui mini inverted statistic">
                <div class="value">0</div>
                <div class="label">Organizations</div>
              </div>
            </div>
            <div class="column">
              <div class="ui mini inverted statistic">
                <div class="value">0</div>
                <div class="label">Visitors</div>
              </div>
            </div>
            <div class="column">
              <div class="ui mini inverted statistic">
                <div class="value">0</div>
                <div class="label">Members</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="column">
      <div class="ui segments">
        <div class="ui inverted center aligned segment">
          <div class="ui inverted huge statistic">
            <div class="value">
              {{ \App\Event::where('start','>=', Date::now('America/Chicago')->toDateTimeString())->where('start','<=', Date::now('America/Chicago')->endOfDay())->count()}}
              </div>
            <div class="label">Events Today</div>
          </div>
          <div class="ui two column grid">
            <div class="column">
              <div class="ui mini inverted statistic">
                <div class="value">
                  {{ \App\Event::where('start','>=', Date::yesterday('America/Chicago')->toDateTimeString())->where('start','<=', Date::yesterday('America/Chicago')->endOfDay())->count()}}
                </div>
                <div class="label">Yesterday</div>
              </div>
            </div>
            <div class="column">
              <div class="ui mini inverted statistic">
                <div class="value">{{ \App\Event::where('start','>=', Date::tomorrow('America/Chicago')->toDateTimeString())->where('start','<=', Date::tomorrow('America/Chicago')->endOfDay())->count()}}</div>
                <div class="label">Tomorrow</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="ui segments">
        <div class="ui inverted center aligned segment">
          <div class="ui inverted huge centered statistic">
            <div class="value">{{ \App\Ticket::where('created_at','>=', Date::now('America/Chicago')->startOfDay()->toDateTimeString())->where('created_at','<=', Date::now('America/Chicago')->endOfDay())->count()}}</div>
            <div class="label">Attendance Today</div>
          </div>
          <div class="ui three column grid">
            <div class="column">
              <div class="ui mini inverted statistic">
                <div class="value">
                  {{ \App\Ticket::where('created_at','>=', Date::yesterday('America/Chicago')->startOfDay()->toDateTimeString())->where('created_at','<=', Date::yesterday('America/Chicago')->endOfDay())->count()}}
                </div>
                <div class="label">Yesterday</div>
              </div>
            </div>
            <div class="column">
              <div class="ui mini inverted statistic">
                <div class="value">
                  {{ \App\Ticket::where('created_at','>=', Date::now('America/Chicago')->startOfWeek()->toDateTimeString())->where('created_at','<=', Date::now('America/Chicago')->endOfWeek())->count()}}
                </div>
                <div class="label">This Week</div>
              </div>
            </div>
            <div class="column">
              <div class="ui mini inverted statistic">
                <div class="value">{{ \App\Ticket::where('created_at','>=', Date::now('America/Chicago')->startOfMonth()->toDateTimeString())->where('created_at','<=', Date::now('America/Chicago')->endOfMonth())->count()}}</div>
                <div class="label">This Month</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="column">
      <div class="ui segments">
        <div class="ui inverted center aligned segment">
          <div class="ui inverted huge statistic">
            <!-- Pending sale paid for tru or false field -->
            <div class="value">$ 
              <?php 

                $salesTotalToday = 0;

                $salesToday = \App\Sale::where('created_at','>=', Date::now('America/Chicago')->startofDay())
                                        ->where('created_at','<=', Date::now('America/Chicago')->endOfDay())
                                        ->get();
                foreach ($salesToday as $sale) {
                  $salesTotalToday += $sale->total;
                }
                echo number_format($salesTotalToday, 2);
              ?>
            </div>
            <div class="label">Earned Today</div>
          </div>
          <div class="ui two column grid">
            <div class="column">
              <div class="ui mini inverted statistic">
                <div class="value">$ 
                  <?php 

                    $salesTotalYesterday = 0;

                    $salesYesterday = \App\Sale::where('created_at','>=', Date::yesterday('America/Chicago')->startOfDay())
                                               ->where('created_at','<=', Date::yesterday('America/Chicago')->endOfDay())
                                               ->get();
                    foreach ($salesYesterday as $sale) {
                      $salesTotalYesterday += $sale->total;
                    }
                    echo number_format($salesTotalYesterday, 2);
                  ?>
                </div>
                <div class="label">Yesterday</div>
              </div>
            </div>
            <div class="column">
              <div class="ui mini inverted statistic">
                <div class="value">$ 
                  <?php 

                    $salesTotalWeek = 0;

                    $salesWeek = \App\Sale::where('created_at','>=', Date::now('America/Chicago')->startOfWeek())
                                          ->where('created_at','<=', Date::now('America/Chicago')->endOfWeek())
                                          ->get();
                    foreach ($salesWeek as $sale) {
                      $salesTotalWeek += $sale->total;
                    }
                    echo number_format($salesTotalWeek, 2);
                  ?>
                </div>
                <div class="label">This Week</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="ui segments">
        <div class="ui inverted center aligned segment">
          <div class="ui inverted huge statistic">
            <div class="value">{{ \App\Sale::where('created_at','>=', Date::now('America/Chicago')->startOfDay()->toDateTimeString())->where('created_at','<=', Date::now('America/Chicago')->endOfDay())->count() }}</div>
            <div class="label">Sales Today</div>
          </div>
          <div class="ui three column grid">
            <div class="column">
              <div class="ui mini inverted statistic">
                <div class="value"> 
                <?php

                  $totalSalesToday = \App\Sale::where('created_at','>=', Date::now('America/Chicago')->startOfDay()->toDateTimeString())->where('created_at','<=', Date::now('America/Chicago')->endOfDay())->count();

                  $cardSales = \App\Sale::where('created_at','>=', Date::now('America/Chicago')->startOfDay())
                                        ->where('created_at','<=', Date::now('America/Chicago')->endOfDay())
                                        ->where('payment_method', '!=', 'cash')
                                        ->where('payment_method', '!=', 'check')
                                        ->count();

                  if ($cardSales <= 0)
                    echo $cardSales;
                  else
                    echo (($cardSales / $totalSalesToday) * 100);
                ?> %

                </div>
                <div class="label">Card</div>
              </div>
            </div>
            <div class="column">
              <div class="ui mini inverted statistic">
                <div class="value">
                <?php
                  
                  $cashSales = \App\Sale::where('created_at','>=', Date::now('America/Chicago')->startOfDay())
                                        ->where('created_at','<=', Date::now('America/Chicago')->endOfDay())
                                        ->where('payment_method', '=', 'cash')
                                        ->count();

                   if ($cashSales <= 0)
                    echo $cashSales;
                  else
                    echo (($cashSales / $totalSalesToday) * 100);                     

                ?> %
                </div>
                <div class="label">Cash</div>
              </div>
            </div>
            <div class="column">
              <div class="ui mini inverted statistic">
                <div class="value">
                <?php
                  
                  $checkSales = \App\Sale::where('created_at','>=', Date::now('America/Chicago')->startOfDay())
                                        ->where('created_at','<=', Date::now('America/Chicago')->endOfDay())
                                        ->where('payment_method', '=', 'check')
                                        ->count();

                   if ($checkSales <= 0)
                    echo $checkSales;
                  else
                    echo (($checkSales / $totalSalesToday)* 100);

                ?> %
                </div>
                <div class="label">Check</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>   
  </div>

@endsection
