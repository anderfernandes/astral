{!! Form::select('state',
  App\Helpers\States::get(),
  "Texas",
  ['placeholder' => 'Select a State', 'class' => 'ui search dropdown'])
!!}
